<?php

namespace App\Services;

use App\Entities\Hero;
use App\Models\CantinaModel;
use App\Models\HeroModel;
use App\Models\HeroModelModel;
use App\Models\HeroNameModel;
use App\Models\PlayerModel;
use App\Models\RarityLevelModel;
use CodeIgniter\I18n\Time;

class CantinaService
{
    protected $cantinaModel;
    protected $playerModel;
    protected $heroModelModel;
    protected $rarityModel;
    protected $heroNameModel;
    protected $heroModel;

    public function __construct()
    {
        $this->cantinaModel = model(CantinaModel::Class);
        $this->playerModel = model(PlayerModel::Class);
        $this->heroModelModel = model(HeroModelModel::class);
        $this->rarityModel = model(RarityLevelModel::class);
        $this->heroNameModel = model(HeroNameModel::class);
        $this->heroModel = model(heroModel::class);
    }

    public function generateOffers(int $playerId, int $number = 3) : array
    {
        $this->cantinaModel->where('player_id', $playerId)->delete();

        $player = $this->playerModel->find($playerId);
        $playerLevel = $player->level ?? 1;
        $now = date('Y-m-d H:i:s');
        $batchData = array();

        for($i = 0; $i < $number; $i++) {
            $heromodel = $this->heroModelModel->getRandom($playerLevel);

            if(!$heromodel){ continue; }

            $power = rand((int)$heromodel->power_min, (int)$heromodel->power_max);
            $cost = rand((int)$heromodel->cost_credits_min, (int)$heromodel->cost_credits_max);

            $rarity = $this->rarityModel->getRandomRarity();

            $powermulti = $rarity ? (float)$rarity->power_multiplier : 1 ;
            $costmulti = $rarity ? (float)$rarity->cost_multiplier : 1 ;

            $batchData[] = [
                'player_id' => $playerId,
                'hero_model_id' => $heromodel->id,
                'rarity_id' => $rarity ? $rarity->id : 1,
                'name' => $this->heroNameModel->getRandom(),
                'power' => (int) round($power * $powermulti),
                'cost_credit' => (int) round($cost * $costmulti),
                'created_at' => $now,
                'updated_at' => $now,
            ];

        }

        if(!empty($batchData)){
            $this->cantinaModel->insertBatch($batchData);
        }
        return $this->cantinaModel->where('player_id', $playerId)->findAll();
    }

    public function getOnGeneratedOffers(int $playerId, int $number = 3) : array
    {
        $offers = $this->cantinaModel->where('player_id', $playerId)->findAll();
        if(!empty($offers)){
            $hour = $offers[0]->created_at;
            if($hour != null ){
                $createdTime = Time::parse($hour);
                $now = Time::now();
                $diff = $createdTime->difference($now)->getHours();
                if($diff < 12){
                    return $offers;
                }
            }
        }
        return $this->generateOffers($playerId, $number);
    }
    public function recruit(int $playerId, int $heroCantinaId)
    {
        //Recherche du hero de la cantina
        $cantinaHero = $this->cantinaModel->find($heroCantinaId);
        //Si je n'ai pas de hero je quitte le recrutement
        if($cantinaHero === null){
            return null;
        }
        $player_id = $cantinaHero->player_id;
        $player = $this->playerModel->find($playerId);

        //Verifivation de si on a encore de la place dans l'équipe
        if ($player->isFleetFull() == true){
            return null;
        }

        //Verification du solde

        if($player->credits < $cantinaHero->cost_credit){
            return null;
        }
        //Transformation de l'entité en tableau + nettoyage des info
        $cantinaHero = $cantinaHero->toRawArray();
        unset($cantinaHero['id']);
        unset($cantinaHero['created_at']);
        unset($cantinaHero['updated_at']);
        //Création du héro + gestion du last_stamina_update
        $hero = new Hero($cantinaHero);
        $hero->last_stamina_update = date('Y-m-d H:i:s');
        //Insertion du hero dans la BDD : Si réussi on stock l'ID sinon on stop
        if($id = $this->heroModel->insert($hero)){
            //Réduire le montant du cout du hero
            $player->credits = max(0, ($player->credits - $cantinaHero['cost_credit']));
            $this->playerModel->save($player);
            //on régénère les offres
            $this->generateOffers($player_id);
            //On cherche et on retourne le hero que l'on vient de créer
            return $this->heroModel->find($id);
        }
        return null;
    }
}