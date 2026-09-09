<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class SpecializationSeeder extends Seeder
{
    public function run()
    {
        $now = date('Y-m-d H:i:s');
        $specializations = [
            [
                'name'        => 'Infiltrateur',
                'description' => 'Spécialiste de la discrétion et du piratage, idéal pour contourner les défenses ennemies.',
                'created_at'  => $now,
                'updated_at'  => $now,
            ],
            [
                'name'        => 'Techno-Mage',
                'description' => 'Manipule l\'énergie et les systèmes informatiques à distance pour altérer le terrain de combat.',
                'created_at'  => $now,
                'updated_at'  => $now,
            ],
            [
                'name'        => 'Artilleur',
                'description' => 'Expert des armes lourdes et du tir de couverture, axé sur les dégâts de zone.',
                'created_at'  => $now,
                'updated_at'  => $now,
            ],
            [
                'name'        => 'Bio-Soigneur',
                'description' => 'Spécialisé dans le soutien, la régénération de santé et le renforcement des aliés.',
                'created_at'  => $now,
                'updated_at'  => $now,
            ],
            [
                'name'        => 'Éclaireur',
                'description' => 'Rapide et agile, parfait pour la reconnaissance et l\'élimination de cibles prioritaires à distance.',
                'created_at'  => $now,
                'updated_at'  => $now,
            ],
            [
                'name'        => 'Avant-Garde',
                'description' => 'Combattant de première ligne en armure lourde, conçu pour encaisser les coups.',
                'created_at'  => $now,
                'updated_at'  => $now,
            ],
            [
                'name'        => 'Saboteur',
                'description' => 'Maître des pièges, des explosifs et de la perturbation des équipements ennemis.',
                'created_at'  => $now,
                'updated_at'  => $now,
            ],
            [
                'name'        => 'Commandant',
                'description' => 'Oriente le jeu d\'équipe en appliquant des bonus tactiques à toute l\'escouade.',
                'created_at'  => $now,
                'updated_at'  => $now,
            ],
            [
                'name'        => 'Traqueur',
                'description' => 'Spécialiste de la traque d\'individus et du combat rapproché en milieu hostile.',
                'created_at'  => $now,
                'updated_at'  => $now,
            ],
            [
                'name'        => 'Cyber-Hacker',
                'description' => 'Neutralise la technologie adverse, prend le contrôle des drones et dresse des pare-feux tactiques.',
                'created_at'  => $now,
                'updated_at'  => $now,
            ],
        ];
        $this->db->table('specializations')->insertBatch($specializations);
    }
}