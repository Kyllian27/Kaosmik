<?php

namespace App\Entities;

use App\Models\LevelThresholdModel;
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

    public function setExperience(int $exp): self {
        $this->attributes['experience'] = $exp;

        $newlevel = $this->checklevel($exp);
        $this->attributes['level'] = $newlevel;

        return $this;
    }

    /**
     * calcule le niveaux corespondant à un montant d'experience
     * @param int $exp Experience à chercher
     * @return int Niveaux correspondant
     */
    public function checklevel(int $exp) : int {
        $levelthresholdModel = model(LevelThresholdModel::class);

        //cherche le niveaux le plus élevé débloquer pour cette experience
        $threshold = $levelthresholdModel
            ->where('experience_required <=', $exp)
            ->orderBy('level', 'DESC')
            ->first();
        //On retourne le niveaux trouvé sinon 1
        return $threshold ? (int)$threshold['level'] : 1;


    }
}