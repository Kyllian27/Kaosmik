<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class MissionSeeder extends Seeder
{
    public function run()
    {
        $now = date('Y-m-d H:i:s');

        // Puissances et coûts calqués sur les fourchettes de hero_models par level_required,
        // multipliées par team_size_max pour estimer la puissance cumulée d'une escouade.
        $missions = [
            // Niveau 1 (héros dispo : power 10-25)
            [
                'title'                  => 'Patrouille de Routine',
                'description'            => 'Une ronde de surveillance sans histoire aux abords de la station.',
                'level_required'         => 1,
                'power_required_min'     => 15,
                'power_required_max'     => 30,
                'stamina_cost_min'       => 10,
                'stamina_cost_max'       => 20,
                'team_size_max'          => 1,
                'credits_reward_min'     => 30,
                'credits_reward_max'     => 60,
                'energy_reward_min'      => 5,
                'energy_reward_max'      => 10,
                'experience_reward_min'  => 15,
                'experience_reward_max'  => 25,
            ],
            [
                'title'                  => 'Nettoyage de Débris Spatiaux',
                'description'            => 'Dégager les couloirs de navigation encombrés par des débris en orbite.',
                'level_required'         => 1,
                'power_required_min'     => 20,
                'power_required_max'     => 40,
                'stamina_cost_min'       => 15,
                'stamina_cost_max'       => 25,
                'team_size_max'          => 2,
                'credits_reward_min'     => 50,
                'credits_reward_max'     => 90,
                'energy_reward_min'      => 8,
                'energy_reward_max'      => 15,
                'experience_reward_min'  => 20,
                'experience_reward_max'  => 35,
            ],

            // Niveau 2 (héros dispo : power 15-50)
            [
                'title'                  => "Infiltration de l'Avant-Poste",
                'description'            => "S'introduire dans un avant-poste ennemi pour en récupérer les plans.",
                'level_required'         => 2,
                'power_required_min'     => 40,
                'power_required_max'     => 70,
                'stamina_cost_min'       => 20,
                'stamina_cost_max'       => 30,
                'team_size_max'          => 2,
                'credits_reward_min'     => 100,
                'credits_reward_max'     => 180,
                'energy_reward_min'      => 15,
                'energy_reward_max'      => 25,
                'experience_reward_min'  => 40,
                'experience_reward_max'  => 60,
            ],
            [
                'title'                  => 'Escorte de Convoi',
                'description'            => 'Protéger un convoi de ravitaillement contre des pirates spatiaux.',
                'level_required'         => 2,
                'power_required_min'     => 50,
                'power_required_max'     => 90,
                'stamina_cost_min'       => 25,
                'stamina_cost_max'       => 35,
                'team_size_max'          => 3,
                'credits_reward_min'     => 130,
                'credits_reward_max'     => 220,
                'energy_reward_min'      => 18,
                'energy_reward_max'      => 30,
                'experience_reward_min'  => 50,
                'experience_reward_max'  => 75,
            ],

            // Niveau 3 (héros dispo : power 25-65)
            [
                'title'                  => 'Sabotage de la Base Ennemie',
                'description'            => 'Détruire les générateurs d\'une base ennemie retranchée sur un astéroïde.',
                'level_required'         => 3,
                'power_required_min'     => 90,
                'power_required_max'     => 150,
                'stamina_cost_min'       => 25,
                'stamina_cost_max'       => 40,
                'team_size_max'          => 3,
                'credits_reward_min'     => 200,
                'credits_reward_max'     => 350,
                'energy_reward_min'      => 30,
                'energy_reward_max'      => 45,
                'experience_reward_min'  => 80,
                'experience_reward_max'  => 120,
            ],
            [
                'title'                  => 'Chasse aux Primes Stellaire',
                'description'            => 'Traquer une cible à haute valeur dans un secteur hostile.',
                'level_required'         => 3,
                'power_required_min'     => 100,
                'power_required_max'     => 160,
                'stamina_cost_min'       => 30,
                'stamina_cost_max'       => 45,
                'team_size_max'          => 3,
                'credits_reward_min'     => 220,
                'credits_reward_max'     => 380,
                'energy_reward_min'      => 35,
                'energy_reward_max'      => 50,
                'experience_reward_min'  => 90,
                'experience_reward_max'  => 130,
            ],

            // Niveau 4 (héros dispo : power 35-80)
            [
                'title'                  => 'Assaut sur la Forteresse Orbitale',
                'description'            => "Prendre d'assaut une forteresse en orbite lourdement défendue.",
                'level_required'         => 4,
                'power_required_min'     => 160,
                'power_required_max'     => 260,
                'stamina_cost_min'       => 35,
                'stamina_cost_max'       => 50,
                'team_size_max'          => 4,
                'credits_reward_min'     => 350,
                'credits_reward_max'     => 550,
                'energy_reward_min'      => 50,
                'energy_reward_max'      => 75,
                'experience_reward_min'  => 150,
                'experience_reward_max'  => 220,
            ],
            [
                'title'                  => 'Piratage du Réseau Central',
                'description'            => 'Prendre le contrôle du réseau de défense central d\'une flotte ennemie.',
                'level_required'         => 4,
                'power_required_min'     => 150,
                'power_required_max'     => 240,
                'stamina_cost_min'       => 30,
                'stamina_cost_max'       => 45,
                'team_size_max'          => 4,
                'credits_reward_min'     => 320,
                'credits_reward_max'     => 500,
                'energy_reward_min'      => 45,
                'energy_reward_max'      => 70,
                'experience_reward_min'  => 140,
                'experience_reward_max'  => 200,
            ],

            // Niveau 5 (héros dispo : power 40-80)
            [
                'title'                  => 'Raid sur le Vaisseau-Mère',
                'description'            => "Infiltrer et neutraliser le vaisseau-mère d'une flotte d'invasion.",
                'level_required'         => 5,
                'power_required_min'     => 250,
                'power_required_max'     => 400,
                'stamina_cost_min'       => 45,
                'stamina_cost_max'       => 70,
                'team_size_max'          => 5,
                'credits_reward_min'     => 550,
                'credits_reward_max'     => 900,
                'energy_reward_min'      => 80,
                'energy_reward_max'      => 120,
                'experience_reward_min'  => 250,
                'experience_reward_max'  => 350,
            ],
            [
                'title'                  => 'Libération de la Colonie Assiégée',
                'description'            => 'Repousser les forces ennemies qui assiègent une colonie civile.',
                'level_required'         => 5,
                'power_required_min'     => 230,
                'power_required_max'     => 380,
                'stamina_cost_min'       => 40,
                'stamina_cost_max'       => 65,
                'team_size_max'          => 5,
                'credits_reward_min'     => 500,
                'credits_reward_max'     => 850,
                'energy_reward_min'      => 75,
                'energy_reward_max'      => 110,
                'experience_reward_min'  => 230,
                'experience_reward_max'  => 320,
            ],
        ];

        // Ajout des timestamps
        foreach ($missions as &$mission) {
            $mission['created_at'] = $now;
            $mission['updated_at'] = $now;
        }

        $this->db->table('missions')->insertBatch($missions);
    }
}
