<?php

namespace App\Entities;

use CodeIgniter\Entity\Entity;
use CodeIgniter\Shield\Entities\User;
use CodeIgniter\Shield\Models\UserModel;

class Player extends Entity
{
    protected $attributes = [
        'id'  => null,
        'user_id' => null,
        'level' => 1,
        'experience' => 0,
        'credits' => 1000,
        'fusion_energy' => 0,
    ];
    protected $casts   = [
        'id'  => 'integer',
        'user_id' => 'integer',
        'level' => 'integer',
        'experience' => 'integer',
        'credits' => 'integer',
        'fusion_energy' => 'integer',
    ];
    protected $dates   = ['created_at', 'updated_at', 'deleted_at'];

    protected ?User $user = null;

    public function getUser(): ?User
    {
        if($this->user === null && !empty($this->attributes['user_id'])) {
            $userModel = model(UserModel::class);
            $this->user = $userModel->find($this->attributes['user_id']);
        }

        return $this->user;
    }

    public function setUser(User $user): self {
        $this->user = $user;
        $this->attributes['user_id'] = $user->id;

        return $this;
    }
}
