<?php

namespace App\Entities;

use App\Models\LevelThresholdModel;
use CodeIgniter\Entity\Entity;
use CodeIgniter\Shield\Entities\User;
use CodeIgniter\Shield\Models\UserModel;

class Player extends Entity
{
    protected $attributes = [
        'id'             => null,
        'user_id'        => null,
        'level'          => 1,
        'experience'     => 0,
        'credits'        => 1000,
        'fusion_energy'  => 0,
        'fleet_capacity' => 10,
    ];

    protected $casts = [
        'id'             => 'integer',
        'user_id'        => 'integer',
        'level'          => 'integer',
        'experience'     => 'integer',
        'credits'        => 'integer',
        'fusion_energy'  => 'integer',
        'fleet_capacity' => 'integer',
    ];

    protected $dates = ['created_at', 'updated_at', 'deleted_at'];

    protected ?User $user = null;

    protected $heroes = [];

    public function getUser(): ?User
    {
        if ($this->user === null && !empty($this->attributes['user_id'])) {
            $userModel  = model(UserModel::class);
            $this->user = $userModel->find($this->attributes['user_id']);
        }

        return $this->user;
    }

    public function setUser(User $user): self
    {
        $this->user                  = $user;
        $this->attributes['user_id'] = $user->id;

        return $this;
    }

    public function setExperience($exp): self
    {
        // Met à jour l'expérience
        $this->attributes['experience'] = $exp;

        // Vérifie et met à jour le niveau
        $newLevel                  = $this->checkLevel((int) $exp);
        $this->attributes['level'] = $newLevel;

        return $this;
    }

    /**
     * Calcule le niveau correspondant à un montant d'expérience
     * @param int $exp Expérience à chercher
     * @return int Niveau correspondant ou par défaut 1
     */
    public function checkLevel(int $exp): int
    {
        $levelThresholdModel = model(LevelThresholdModel::class);

        // Cherche le niveau le plus élevé débloqué par cette expérience
        $threshold = $levelThresholdModel
            ->where('experience_required <=', $exp)
            ->orderBy('level', 'DESC')
            ->first();

        if (!$threshold) {
            return 1;
        }

        return is_array($threshold) ? (int) $threshold['level'] : (int) $threshold->level;
    }

    public function getHeroes(): array
    {
        if (!empty($this->heroes)) {
            return $this->heroes;
        }

        $heroModel    = model('HeroModel');
        $this->heroes = $heroModel->where('player_id', $this->attributes['id'])->findAll() ?? [];

        return $this->heroes;
    }

    public function isFleetFull(): bool
    {
        if ($this->attributes['fleet_capacity'] >= count($this->getHeroes())) {
            return false;
        }
        return true;
    }

    public function getTotalPower(): int
    {
        $totalPower = 0;
        foreach ($this->getHeroes() as $hero) {
            $totalPower += $hero->power ?? 0;
        }

        return $totalPower;
    }
}