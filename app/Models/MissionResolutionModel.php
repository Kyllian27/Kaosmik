<?php

namespace App\Models;

use App\Entities\MissionResolution;
use CodeIgniter\Model;

class MissionResolutionModel extends Model
{
    protected $table            = 'mission_resolutions';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = MissionResolution::class;
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'player_id',
        'mission_id',
        'success',
        'credits_gained',
        'energy_gained',
        'experience_gained',
        'ends_at',
        'resolved_at',
    ];

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

    /**
     * Missions d'un joueur terminée (ends_at) mais pas encore noté comme résolues (resolved_at)
     * @param int $playerId identifiant du joueur
     * @return array|null
     */
    public function getMissionFinishedNotResolved(int $playerId) : array
    {
        return $this->where('player_id', $playerId)
            ->where('resolved_at', null)
            ->where('ends_at <=', date('Y-m-d H:i:s'))
            ->orderBy('ends_at', 'ASC')
            ->findAll();
    }

    /**
     * Missions d'un joueur en cours
     * @param int $playerId identifiant du joueur
     * @return array
     */
    public function getMissionInProgress(int $playerId) : array {
        return $this->where('player_id', $playerId)
            ->where('resolved_at', null)
            ->where('ends_at >', date('Y-m-d H:i:s'))
            ->orderBy('ends_at', 'ASC')
            ->findAll();
    }
}