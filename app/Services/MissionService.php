<?php
namespace App\Services;

use App\Entities\MissionHero;
use App\Entities\MissionResolution;
use Exception;

class MissionService
{
    protected $missionModel;
    protected $heroModel;
    protected $playerModel;

    public function __construct() {
        $this->missionModel = model('MissionModel');
        $this->heroModel = model('HeroModel');
        $this->playerModel = model('PlayerModel');
    }
    public function processMission($player, int $missionId, array $heroesIds)
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

        $this->validateSquad($mission, $heroes);

        $rewards = $this->calculateRewards($mission);

        $rewards['heroes'] = $this->applyEffects($player, $heroes, $mission, $rewards);

        return $rewards;
    }

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
                if(!in_array($specId, $squadSpecIds)) {
                    throw new Exception("L'escoude ne possède pas les spécialisations requises.");
                }
            }
        }
    }

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

    private function applyEffects($player, array $heroes, $mission, $rewards) {
        $staminaRequired = (int) $mission->getStaminaRequired();
        //Historique global de la mission
        $missionResolutionModel = model('MissionResolutionModel');
        $missionHeroModel = model('MissionHeroModel');
        $mr = new MissionResolution();
        $mr->credits_gained = $rewards['credits'];
        $mr->energy_gained = $rewards['energy'];
        $mr->experience_gained = $rewards['xp'];
        $mr->mission_id = $mission->id;
        $mr->player_id = $player->id;
        $mr->success = true;
        $id_mr = $missionResolutionModel->insert($mr);

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