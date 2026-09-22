<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class HeroModelsSeeder extends Seeder
{
    public function run()
    {
        $now = date('Y-m-d H:i:s');

        // Récupération des spécialisations existantes (name => id)
        $specs = $this->db->table('specializations')
            ->select('id, name')
            ->get()
            ->getResultArray();

        $specMap = array_column($specs, 'id', 'name');

        // Id par défaut (Recrue) au cas où une spécialisation est introuvable
        $defaultSpecId = $specMap['Recrue'] ?? 1;

        $heroModels = [
            // Recrue / Généraliste
            [
                'specialization_id' => $specMap['Recrue'] ?? $defaultSpecId,
                'name'             => 'Cadet de la Flotte',
                'description'      => 'Modèle standard polyvalent, prêt à être assigné à n\'importe quelle tâche.',
                'power_min'        => 10,
                'power_max'        => 25,
                'cost_credits_min' => 50,
                'cost_credits_max' => 100,
                'level_required'   => 1,
            ],
            // Infiltrateur
            [
                'specialization_id' => $specMap['Infiltrateur'] ?? $defaultSpecId,
                'name'             => 'Spectre Ombre',
                'description'      => 'Spécialiste de la furtivité, idéal pour s\'infiltrer derrière les lignes ennemies.',
                'power_min'        => 20,
                'power_max'        => 45,
                'cost_credits_min' => 150,
                'cost_credits_max' => 300,
                'level_required'   => 2,
            ],
            // Techno-Mage
            [
                'specialization_id' => $specMap['Techno-Mage'] ?? $defaultSpecId,
                'name'             => 'Adepte du Flux',
                'description'      => 'Manipulateur d\'énergie capable de court-circuiter la technologie adverse.',
                'power_min'        => 30,
                'power_max'        => 65,
                'cost_credits_min' => 250,
                'cost_credits_max' => 500,
                'level_required'   => 3,
            ],
            // Artilleur
            [
                'specialization_id' => $specMap['Artilleur'] ?? $defaultSpecId,
                'name'             => 'Démolisseur Plasma',
                'description'      => 'Équipé de canons lourds, délivre une puissance de feu dévastatrice.',
                'power_min'        => 35,
                'power_max'        => 70,
                'cost_credits_min' => 300,
                'cost_credits_max' => 600,
                'level_required'   => 4,
            ],
            // Bio-Soigneur
            [
                'specialization_id' => $specMap['Bio-Soigneur'] ?? $defaultSpecId,
                'name'             => 'Médecin de Terrain Nanite',
                'description'      => 'Utilise des nanorobots pour soigner les troupes au cœur du combat.',
                'power_min'        => 15,
                'power_max'        => 40,
                'cost_credits_min' => 180,
                'cost_credits_max' => 350,
                'level_required'   => 2,
            ],
            // Éclaireur
            [
                'specialization_id' => $specMap['Éclaireur'] ?? $defaultSpecId,
                'name'             => 'Chasseur Subsonique',
                'description'      => 'Unité ultra-rapide spécialisée dans le marquage de cibles et la reconnaissance.',
                'power_min'        => 25,
                'power_max'        => 50,
                'cost_credits_min' => 200,
                'cost_credits_max' => 400,
                'level_required'   => 3,
            ],
            // Avant-Garde
            [
                'specialization_id' => $specMap['Avant-Garde'] ?? $defaultSpecId,
                'name'             => 'Colosse d\'Acier',
                'description'      => 'Blindé lourdement, il absorbe les dégâts pour protéger le reste de l\'escouade.',
                'power_min'        => 40,
                'power_max'        => 80,
                'cost_credits_min' => 400,
                'cost_credits_max' => 800,
                'level_required'   => 5,
            ],
            // Saboteur
            [
                'specialization_id' => $specMap['Saboteur'] ?? $defaultSpecId,
                'name'             => 'Artificier Quantique',
                'description'      => 'Expert en charges explosives et en neutralisation des défenses automatisées.',
                'power_min'        => 25,
                'power_max'        => 55,
                'cost_credits_min' => 220,
                'cost_credits_max' => 450,
                'level_required'   => 3,
            ],
            // Commandant
            [
                'specialization_id' => $specMap['Commandant'] ?? $defaultSpecId,
                'name'             => 'Stratège Tactique',
                'description'      => 'Coordonne les assauts et augmente les performances globales de ses alliés.',
                'power_min'        => 35,
                'power_max'        => 75,
                'cost_credits_min' => 350,
                'cost_credits_max' => 700,
                'level_required'   => 4,
            ],
            // Traqueur
            [
                'specialization_id' => $specMap['Traqueur'] ?? $defaultSpecId,
                'name'             => 'Chasseur de Primes Céleste',
                'description'      => 'Spécialiste de la traque sans relâche des cibles hautement prioritaires.',
                'power_min'        => 30,
                'power_max'        => 60,
                'cost_credits_min' => 280,
                'cost_credits_max' => 550,
                'level_required'   => 3,
            ],
            // Cyber-Hacker
            [
                'specialization_id' => $specMap['Cyber-Hacker'] ?? $defaultSpecId,
                'name'             => 'Infiltrateur Virtuel',
                'description'      => 'Piratage à distance des drones et systèmes de contrôle ennemis.',
                'power_min'        => 20,
                'power_max'        => 50,
                'cost_credits_min' => 200,
                'cost_credits_max' => 420,
                'level_required'   => 2,
            ],
        ];

        // Ajout des timestamps
        foreach ($heroModels as &$model) {
            $model['created_at'] = $now;
            $model['updated_at'] = $now;
        }

        $this->db->table('hero_models')->insertBatch($heroModels);
    }
}
