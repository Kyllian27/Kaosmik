<?php

namespace App\Models;

use CodeIgniter\Model;

class MissionHeroModel extends Model
{
    protected $table            = 'mission_heroes';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['mission_resolution_id', 'hero_id'];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    /**
     * Permet de savoir si un héros est dans une mission non terminée
     * @param int $heroId identifiant du héros
     * @return bool true/false
     */
    public function isOnMission(int $heroId): bool
    {
        return $this->join('mission_resolutions', 'mission_heroes.mission_resolution_id = mission_resolutions.id')
                ->where('mission_heroes.hero_id', $heroId)
                ->where('mission_resolutions.resolved_at', null)
                ->countAllResults() > 0;
    }

    /**
     * Permet de connaitre les héros d'un joueur qui sont actuellement en mission non résolues (resolved_at)
     * @param int $playerId identifiant du joueur
     * @return array Tableau d'entier
     */
    public function getBusyHeroIds(int $playerId): array {
        $rows = $this->select('mission_heroes.hero_id')
            ->join('mission_resolutions', 'mission_heroes.mission_resolution_id = mission_resolutions.id')
            ->where('mission_resolutions.player_id', $playerId)
            ->where('mission_resolutions.resolved_at', null)
            ->findAll();
        $final_array = array_map('intval', array_column($rows, 'hero_id'));
        return $final_array;
    }
}