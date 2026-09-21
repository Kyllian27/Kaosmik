<?php

namespace App\Models;

use App\Entities\Cantina;
use CodeIgniter\Model;

class CantinaModel extends Model
{
    protected $table            = 'cantinas';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = Cantina::class;
    protected $useSoftDeletes   = false;
    protected $allowedFields    = ['player_id','hero_model_id','rarity_id','name','power','cost_credit'];

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
}