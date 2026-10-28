<?php
namespace App\Services;

use App\Entities\MissionResolution;
use Exception;

class MissionService
{
    protected $missionModel;
    protected $heroModel;
    protected $playerModel;
    protected $missionResolutionModel;
    protected $missionHeroModel;

    public function __construct() {
        $this->missionModel = model('MissionModel');
        $this->heroModel = model('HeroModel');
        $this->playerModel = model('PlayerModel');
        $this->missionResolutionModel = model('missionResolutionModel');
        $this->missionHeroModel = model('MissionHeroModel');
    }

    /**
     * Démarrer une mission : vérification de l'existence de la mission et des héros (appartenant au joueur).
     *
     * @param mixed $player
     * @param int $missionId
     * @param array $heroesIds
     * @return int
     * @throws Exception
     */
    public function starMission($player, int $missionId, array $heroesIds)
    {
        $mission = $this->missionModel->find($missionId);
        if(!$mission){
            throw new Exception("Mission introuvable.");
        }

        if(empty($heroesIds)) {
            throw new Exception("Aucun héros selectionné.");
        }

        $heroes = $this->heroModel
            ->where('player_id', $player->id)
            ->whereIn('id', $heroesIds)
            ->findAll();

        if(count($heroes) !== count($heroesIds)) {
            throw new Exception("Un ou plusieurs mercenaires ne sont pas à vous.");
        }
        $busyHeroIds = $this->missionHeroModel->getBusyHeroIds($player->id);
        foreach($heroes as $hero){
            if(in_array((int)$hero->id, $busyHeroIds,true)) {
                throw new Exception("un hero propose est deja en mission");
            }
        }
        $this->validateSquad($mission, $heroes);
        return $this->dispatchSquad($player, $heroes,$mission);
    }

    /**
     * Dispatch de l'escouade et mise à jour de la stamina.
     *
     * @param mixed $player
     * @param array $heroes
     * @param mixed $mission
     * @return int
     */
    public function dispatchSquad($player, array $heroes,$mission){
        $staminaRequired = (int) $mission->getStaminaRequired();
        $endsAt = date("Y-m-d H:i:s", time()+(int) $mission->duration);

        $mrId = $this->missionResolutionModel->insert([
            'player_id' => $player->id,
            'mission_id' => $mission->id,
            'success'=>false,
            'ends_at' => $endsAt,
        ]);

        $missionHeroes = [];
        foreach($heroes as $hero){
            $missionHeroes[] = ['mission_resolution_id'=>$mrId,'hero_id'=>$hero->id];

            $newStamina = max(0, (int)$hero->stamina_current - $staminaRequired);
            $this->heroModel->update($hero->id,[
                'stamina_current'=>$newStamina,
                'last_stamina_updated'=>$endsAt
            ]);

        }
        $this->missionHeroModel->insertBatch($missionHeroes);

        return (int)$mrId;
    }

    /**
     * Validation de l'escouade (endurance, puissance et spécialisations).
     *
     * @param mixed $mission
     * @param array $heroes
     * @return void
     * @throws Exception
     */
    private function validateSquad($mission, array $heroes) {
        $totalPower = 0;
        $squadSpecIds = array();
        $staminaRequired = (int) $mission->getStaminaRequired();

        foreach($heroes as $hero) {
            if ( (int) $hero->stamina_current < $staminaRequired ) {
                throw new Exception("Le héros {$hero->name} n'a pas suffisamment d'endurance.");
            }

            $totalPower += (int) $hero->power;

            $spec = $hero->getHeroModel()->getSpecialization();
            if($spec) {
                $squadSpecIds[] = (int) $spec['id'];
            }
        }

        if($totalPower < (int) $mission->getPowerRequired()) {
            throw new Exception("La puissance de votre escouade est bien trop faible.");
        }

        $requiredSpecs = $mission->getSpecializations();
        if(!empty($requiredSpecs)){
            foreach($requiredSpecs as $spec) {
                $specId = (int) $spec['id'];
                if(!in_array($specId, $squadSpecIds,true)) {
                    throw new Exception("L'escoude ne possède pas les spécialisations requises.");
                }
            }
        }
    }

    /**
     * Calcul des récompenses aléatoires de la mission.
     *
     * @param mixed $mission
     * @return array
     */
    private function calculateRewards($mission) {
        $creditGain = (int) mt_rand((int) $mission->credits_reward_min, (int) $mission->credits_reward_max);
        $energyGain = (int) mt_rand((int) $mission->energy_reward_min, (int) $mission->energy_reward_max);
        $xpGain = (int) mt_rand((int) $mission->experience_reward_min, (int) $mission->experience_reward_max);

        return [
            'credits' => $creditGain,
            'energy' => $energyGain,
            'xp' => $xpGain,
        ];
    }

    /**
     * Résolution des missions terminées.
     *
     * @param mixed $player
     * @return array|int[]
     * @throws \ReflectionException
     */
    public function resolveFinishedMission($player) {
        $resolved = [];
        $missions =$this->missionResolutionModel->getMissionFinishedNotResolved($player->id);
        foreach($missions as $mr){
            $result = $this->resolveMission($player, $mr);
            if($result !== null){
                $resolved[] = $result;
            }
        }
        return $resolved;
    }

    private function resolveMission($player,$mr){
        $mission = $mr->getMission();
        $rewards = $this->calculateRewards($mission);
        $now = date("Y-m-d H:i:s");

        $dataUpdate = [
            'success'=>1,
            'credits_gained'=>$rewards['credits'],
            'energy_gained'=>$rewards['energy'],
            'experience_gained'=>$rewards['experience'],
            'resolved_at'=>$now,
        ];
        $mr->fill($dataUpdate);
        $this->missionResolutionModel->save($mr);

        $player->credits += $rewards['credits'];
        $player->fusion_energy += $rewards['energy'];
        $player->experience += $rewards['xp'];
        $this->playerModel->save($player);

        return['mission'=>$mission]+$rewards;
    }

    /**
     * Application des effets de fin de mission sur les héros et le joueur.
     *
     * @param mixed $player
     * @param array $heroes
     * @param mixed $mission
     * @param array $rewards
     * @return array
     */
    private function applyEffects($player, array $heroes, $mission, $rewards) {
        $staminaRequired = (int) $mission->getStaminaRequired();
        //Historique global de la mission
        $missionResolutionModel = model('missionResolutionModel');
        $mr = new MissionResolution();
        $mr->credits_gained = $rewards['credits'];
        $mr->energy_gained = $rewards['energy'];
        $mr->experience_gained = $rewards['xp'];
        $mr->mission_id = $mission->id;
        $mr->player_id = $player->id;
        $mr->success = true;
        $missionResolutionModel->insert($mr);

        foreach($heroes as $hero) {
            $newStamina = max(0, (int) $hero->stamina_current - $staminaRequired);
            $hero->stamina_current = $newStamina;
            //Sauvegarde de la modification du héro (stamina)
            $this->heroModel->update($hero->id, ['stamina_current' => $newStamina, 'last_stamina_update' => date('Y-m-d H:i:s')]);
        }

        //Sauvegarde des modifications du joueur (récompense)
        $player->credits += $rewards['credits'];
        $player->fusion_energy += $rewards['energy'];
        $player->experience += $rewards['xp'];
        $this->playerModel->save($player);

        return $heroes;
    }
}