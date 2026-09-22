<?php

namespace App\Entities;

use App\Models\HeroModelModel;
use App\Models\PlayerModel;
use App\Models\RarityLevelModel;
use CodeIgniter\Entity\Entity;

class Cantina extends Entity
{
    protected $attributes = [
        'id' => null,
        'player_id' => null,
        'hero_model_id' => null,
        'rarity_id' => null,
        'name' => null,
        'power' => 1,
        'cost_credit' => 1,
    ];
    protected $datamap = [];
    protected $dates   = ['created_at', 'updated_at'];
    protected $casts   = [
        'id' => 'int',
        'player_id' => 'int',
        'hero_model_id' => 'int',
        'rarity_id' => 'int',
        'name' => 'string',
        'power' => 'int',
        'cost_credit' => 'int',
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
}
