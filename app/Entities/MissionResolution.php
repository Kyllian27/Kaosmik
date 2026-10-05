<?php

namespace App\Entities;

use App\Models\MissionModel;
use App\Models\PlayerModel;
use CodeIgniter\Entity\Entity;

class MissionResolution extends Entity
{
    protected $attributes = [
        'id' => null,
        'player_id' => null,
        'mission_id' => null,
        'success' => false,
        'credits_gained' => 0,
        'energy_gained' => 0,
        'experience_gained' => 0,
    ];
    protected $datamap = [];
    protected $dates   = ['created_at', 'updated_at'];
    protected $casts   = [
        'id' => 'int',
        'player_id' => 'int',
        'mission_id' => 'int',
        'success' => 'boolean',
        'credits_gained' => 'int',
        'energy_gained' => 'int',
        'experience_gained' => 'int',
    ];

    protected ?Player  $player = null;
    protected ?Mission $mission = null;

    public function getPlayer(): ?Player {
        if($this->player === null && ($this->attributes['player_id'])) {
            $playerModel = model(PlayerModel::class);
            $this->player = $playerModel->find($this->attributes['player_id']);
        }
        return $this->player;
    }

    public function getMission(): ?Mission {
        if($this->mission === null && ($this->attributes['mission_id'])) {
            $missionModel = model(MissionModel::class);
            $this->mission = $missionModel->find($this->attributes['mission_id']);
        }
        return $this->mission;
    }
}
