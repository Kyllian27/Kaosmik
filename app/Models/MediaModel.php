<?php

namespace App\Models;

use App\Entities\Media;
use CodeIgniter\Model;

class MediaModel extends Model
{
    protected $table            = 'medias';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = Media::class;
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['entity_type','entity_id','name', 'url','alt','title','type'];

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

    public function getOneMedia($entity_type, $entity_id) {
        return $this->where('entity_type', $entity_type)
            ->where('entity_id', $entity_id)
            ->first();
    }
}