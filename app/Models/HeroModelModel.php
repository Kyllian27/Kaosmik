<?php

namespace App\Models;

use App\Entities\HeroModel;
use CodeIgniter\Model;

class HeroModelModel extends Model
{
    protected $table            = 'hero_models';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = HeroModel::class;
    protected $useSoftDeletes   = false; // Désactivé car la colonne 'deleted_at' n'existe pas en BDD
    protected $protectFields    = true;
    protected $allowedFields    = ['specialization_id','name', 'description','power_min','power_max', 'cost_credits_min', 'cost_credits_max', 'level_required'];

    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;

    protected array $casts = [];
    protected array $castHandlers = [];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules      = [];
    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = [];
    protected $afterInsert    = [];
    protected $beforeUpdate   = [];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];

    public function getRandom(int $playerlevel = 1) {
        return $this->where('level_required <=', $playerlevel)
            ->orderBy('RAND()')
            ->first();
    }
}