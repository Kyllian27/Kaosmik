<?php

namespace App\Entities;

use App\Models\HeroModelModel;
use App\Models\PlayerModel;
use App\Models\RarityLevelModel;
use CodeIgniter\Entity\Entity;
use CodeIgniter\I18n\Time;

class Hero extends Entity
{
    protected $attributes = [
        'id' => null,
        'player_id' => null,
        'hero_model_id' => null,
        'rarity_id' => null,
        'name' => null,
        'power' => 1,
        'cost_credit' => 1,
        'stamina_current' => 100,
        'stamina_max' => 100,
        'last_stamina_update' => null
    ];
    protected $datamap = [];
    protected $dates   = ['created_at', 'updated_at','last_stamina_update'];
    protected $casts   = [
        'id' => 'int',
        'player_id' => 'int',
        'hero_model_id' => 'int',
        'rarity_id' => 'int',
        'name' =>
        'string',
        'power' => 'int',
        'cost_credit' => 'int',
        'stamina_current' => 'int',
        'stamina_max' => 'int',
    ];
    protected ?Player  $player = null;
    protected ?HeroModel $heroModel = null;
    protected ?RarityLevel $rarity = null;
    public function getPlayer(): ?Player {
        if($this->player === null && ($this->attributes['player_id'])) {
            $playerModel = model(PlayerModel::class);
            $this->player = $playerModel->find($this->attributes['player_id']);
        }
        return $this->player;
    }

    public function getHeroModel(): ?HeroModel {
        if($this->heroModel === null && ($this->attributes['hero_model_id'])) {
            $heroModel = model(HeroModelModel::class);
            $this->heroModel = $heroModel->find($this->attributes['hero_model_id']);
        }
        return $this->heroModel;
    }

    public function getRarity() : ?RarityLevel {
        if($this->rarity === null && ($this->attributes['rarity_id'])) {
            $rarityModel = model(RarityLevelModel::class);
            $this->rarity = $rarityModel->find($this->attributes['rarity_id']);
        }
        return $this->rarity;
    }

    /**
     * Calculer et mettre à jours les informations de stamina du héro en fonction du temps écoulé depuis sa dernière mise à jour
     * Recharge 1 point toute les 2 minutes
     * @return bool True si la stamina été modifié (save() à faire), false sinon.
     */
    public function updateStamina() : bool {
        //Si la stamina est déjà au maximum, on sort de la fonction (pas de save)
        if($this->stamina_current >= $this->stamina_max) {
            return false;
        }
        //On stock l'heure de maintenant
        $now = Time::now();

        //Si last_stamina_update est null on l'initialise à maintenant
        if($this->last_stamina_update === null) {
            $this->last_stamina_update = $now;
            return false;
        }

        //Conversion en objet Time si besoin (ternaire)
        $lastUpdate = $this->last_stamina_update instanceof Time ? $this->last_stamina_update : Time::parse($this->last_stamina_update);

        //La différence en seconde (grâce à la conversion TimeStamp)
        $secondsElapsed = $now->getTimestamp() - $lastUpdate->getTimestamp();

        //Moins de 2 minutes, on quitte la fonction
        if ($secondsElapsed < 120) {
            return false;
        }

        //1 points toutes les 2 minutes
        $staminaToGain = (int) floor($secondsElapsed / 120);

        //Si on a rien gagné on quitte la fonction
        if ($staminaToGain <= 0) {
            return false;
        }

        //Calcul de la nouvelle stamina
        $newStamina = min($this->stamina_max, $this->stamina_current + $staminaToGain);
        $actualGained = $newStamina - $this->stamina_current;

        $this->stamina_current = $newStamina;

        if($newStamina >= $this->stamina_max) {
            $this->last_stamina_update = $now;
        } else {
            $secondsConsumed = $actualGained * 120;
            $this->last_stamina_update = $lastUpdate->addSeconds($secondsConsumed);
        }

        return true;
    }
}
