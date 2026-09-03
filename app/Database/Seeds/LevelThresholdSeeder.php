<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use CodeIgniter\I18n\Time;

class LevelThresholdSeeder extends Seeder
{
    public function run()
    {
        $data = [];
        $now  = Time::now()->toDateTimeString();

        // Expérience de base pour le niveau 1
        $baseExp = 100;

        // Exposant d'agressivité de la courbe (1.5 donne une bonne progression de RPG)
        $exponent = 1.2;

        for ($level = 1; $level <= 20; $level++) {
            if ($level === 1) {
                // Niveau 1 : commence à 0 EXP
                $expRequired = 0;
            } else {
                // Calcul courbe exponentielle : base * (level - 1)^exponent
                // Arrondi aux 10 supérieurs pour avoir de beaux chiffres
                $expRequired = (int) round(($baseExp * pow($level - 1, $exponent)) / 10) * 10;
            }

            $data[] = [
                'level'               => $level,
                'experience_required' => $expRequired,
                'created_at'          => $now,
                'updated_at'          => $now,
            ];
        }

        // Insertion groupée dans la table 'level_thresholds'
        $this->db->table('level_thresholds')->insertBatch($data);
    }
}