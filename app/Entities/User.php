<?php

namespace App\Entities;

use App\Models\PlayerModel;
use CodeIgniter\Shield\Entities\User as ShieldUser;

class User extends ShieldUser
{
    protected ?Player $player = null;

    public function getPlayer(): ?Player
    {
        if ($this->player === null && isset($this->id)) {
            $playerModel = model(PlayerModel::class);

            $this->player = $playerModel->findByUserId($this->id);
            if ($this->player) {
                $this->player->setUser($this);
            }
        }
        return $this->player;
    }

    public function setPlayer(Player $player): self
    {
        $this->player = $player;
        return $this;
    }
}