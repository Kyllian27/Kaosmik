<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class RarityLevelSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'name' => "Peu commun",
                'color' => "#1EFF00",
                'power_multiplier' => "1.1",
                'cost_multiplier' => "1.1",
                'appearance_rate' => "12",
            ],
            [
                'name' => "Rare",
                'color' => "#0070DD",
                'power_multiplier' => "1.3",
                'cost_multiplier' => "1.3",
                'appearance_rate' => "8",
            ],
            [
                'name' => "Epique",
                'color' => "#A335EE",
                'power_multiplier' => "1.5",
                'cost_multiplier' => "1.5",
                'appearance_rate' => "4",
            ],
            [
                'name' => "Legendaire",
                'color' => "#FF8000",
                'power_multiplier' => "1.7",
                'cost_multiplier' => "1.7",
                'appearance_rate' => "2",
            ],
            [
                'name' => "MYTHIQUE",
                'color' => "#E60012",
                'power_multiplier' => "2",
                'cost_multiplier' => "2",
                'appearance_rate' => "1",
            ],
        ];

        $rarityModel = model('RarityLevelModel');
        foreach ($data as $row) {
            $rarityModel->insert($row);
        }
    }
}