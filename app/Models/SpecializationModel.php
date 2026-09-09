<?php

namespace App\Models;

use CodeIgniter\Model;

class SpecializationModel extends Model
{
    protected $table            = 'specializations';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['name', 'description', 'created_at', 'updated_at'];

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
    protected $beforeDelete   = ['protectDefaultSpecialization'];
    protected $afterDelete    = [];

    /**
     * Empêche la suppression/modification de la valeur par défaut
     * @throws \Exception
     */
    protected function protectDefaultSpecialization(array $data)
    {
        $id = $data['id'][0] ?? null;
        if ($id == 1) {
            throw new \Exception('Interdiction de modifier ou supprimer la spécialisation par défaut.');
        }
        return $data;
    }
}