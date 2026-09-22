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
    public function __construct() {
        $this->cantinaModel = model(CantinaModel::class);
        $this->playerModel = model(PlayerModel::class);
        $this->heroModelModel = model(HeroModelModel::class );
        $this->rarityModel = model(RarityLevelModel::class );
        $this->heroNameModel = model(HeroNameModel::class );
        $this->heroModel = model(HeroModel::class);
    }

    public function getOrGenerateOffers(int $playerId, int $number = 3): array {
        $offers = $this->cantinaModel->where('player_id', $playerId)->findAll();
        if(!empty($offers) && $offers[0]->created_at != null) {
            $secondsRemaining = $this->getRemainingSeconds($offers[0]->created_at);
            if($secondsRemaining > 0) {
                return [
                    'cantinaHeroes' => $offers,
                    'remaining_time' => $this->getRemainingTime($offers[0]->created_at),
                    'remaining_seconds' => $secondsRemaining,
                ];
            }
        }
        $newOffers = $this->generateOffers($playerId, $number);
        return [
            'cantinaHeroes' => $newOffers,
            'remaining_time' => '12:00:00',
            'remaining_seconds' => 43200,
        ];
    }

    public function generateOffers(int $playerId, int $number = 3) : array {
        $this->cantinaModel->where('player_id', $playerId)->delete();

        $player = $this->playerModel->find($playerId);
        $playerLevel = $player->level ?? 1;

        $now = date('Y-m-d H:i:s');
        $batchData = array();

        for($i = 0; $i < $number; $i++) {
            $heromodel = $this->heroModelModel->getRandom($playerLevel);

            if(!$heromodel) { continue; }

            $power = rand( (int) $heromodel->power_min, (int) $heromodel->power_max );
            $cost = rand( (int) $heromodel->cost_credits_min, (int) $heromodel->cost_credits_max );

            $rarity = $this->rarityModel->getRandomRarity();

            $powermulti = $rarity ? (float) $rarity->power_multiplier : 1;
            $costmulti = $rarity ? (float) $rarity->cost_multiplier : 1;

            $batchData[] = [
                'player_id' => $playerId,
                'hero_model_id' => $heromodel->id,
                'rarity_id' => $rarity ? $rarity->id : 1,
                'name' => $this->heroNameModel->getRandom(),
                'power' => (int) round( $power * $powermulti),
                'cost_credit' => (int) round( $cost * $costmulti),
                'created_at' => $now,
                'updated_at' => $now,
            ];
        }

        if(!empty($batchData)) {
            $this->cantinaModel->insertBatch($batchData);
        }

        return $this->cantinaModel->where('player_id', $playerId)->findAll();
    }

    public function recruit(int $heroCantinaId) {
        //Recherche du hero de la cantina
        $cantinaHero = $this->cantinaModel->find($heroCantinaId);
        //Si je n'ai pas de hero je quitte le recrutement
        if($cantinaHero === null) {
            return null;
        }
        $player_id = $cantinaHero->player_id;
        $player = $this->playerModel->find($player_id);

        //Vérifier si on à encore de la place dans l'équipe
        if ($player->isFleetFull() == true) {
            return null;
        }
        //Verification du solde
        if ($player->credits < $cantinaHero->cost_credit) {
            return null;
        }
        //Transformation de l'entité en tableau + nettoyage des infos
        $cantinaHero = $cantinaHero->toRawArray();
        unset($cantinaHero['id']);
        unset($cantinaHero['created_at']);
        unset($cantinaHero['updated_at']);
        //Création du hero + gestion du last_stamina_update
        $hero = new Hero($cantinaHero);
        $hero->last_stamina_update = date('Y-m-d H:i:s');
        //Insertion du hero en BDD : si réussit on stock l'ID sinon on stop
        if($id = $this->heroModel->insert($hero)) {
            //Déduire le montant du cout du hero
            $player->credits = max(0, ($player->credits - $cantinaHero['cost_credit']));
            $this->playerModel->save($player);
            //On régénère les offres
            $this->generateOffers($player_id);
            //On cherche et on retourne le hero que l'on vient de créer
            return $this->heroModel->find($id);
        }
        return null;
    }

    public function getRemainingTime(string|Time $created_at) {
        //On utilise la fonction getRemainingSeconds pour obtenir les secondes restantes
        $secondsRemaining = $this->getRemainingSeconds($created_at);
        //On test si on est pas à 0 secondes restantes
        if($secondsRemaining <= 0) {
            return "00:00:00";
        }
        //retourne les secondes convertie en date au format souhaité (gmdate exclus les fuseau horaires et décalage)
        return gmdate("H:i:s", $secondsRemaining);
    }

    public function getRemainingSeconds(string|Time $created_at) : int {
        //Si j'ai déjà un objet Time je l'utilise, sinon je le créer
        $createdTime = ($created_at instanceof Time) ? $created_at : Time::parse($created_at);
        //Création d'un objet Time de maintenant
        $now = Time::now();
        //Calcul de l'heure d'expiration
        $expiration_time = $createdTime->addHours(12);
        //Si l'heure est dépassé on retourne 00:00:00
        if($now->isAfter($expiration_time)) {
            return 0;
        }
        //Calcul du temps restant en secondes (Timestamp = Heure Unix = Secondes depuis 01/01/1970)
        return $expiration_time->getTimestamp() - $now->getTimestamp();
    }
}