<?php

namespace App\Entities;

use App\Models\PlayerModel;
use CodeIgniter\Entity\Entity;

class cantina extends Entity
{
    protected $datamap = [];
    protected $dates   = ['created_at', 'updated_at', ];
    protected $casts   = [
        'id'             => 'int',
        'player_id'      => 'int',
        'hero_model_id'  => 'int',
        'rarity_id'      => 'int',
        'name'           => 'string',
        'power'          => 'int',
        'cost_credits'   => 'int',
        'stamina_current'=> 'int',
        'stamina_max'    => 'int',
    ];
    protected $attributes = [
        'id'             => null,
        'player_id'      => null,
        'hero_model_id'  => null,
        'rarity_id'      => null,
        'name'           => 'string',
        'power'          => 1,
        'cost_credits'   => 1,
        'stamina_current'=> 100,
        'stamina_max'    => 100,
    ];

    protected ?Player $player = null;
    protected ?HeroModel $heroModel = null;
    protected ?RarityLevel $rarity = null;

    public function getPlayer(): ?Player{
        if($this->player === null && ($this->attributes['player_id'])) {
            $playerModel = model(PlayerModel::class);

            $this->player = $playerModel->find($this->attributes['player_id']);
            }

        return $this->player;
    }

}
