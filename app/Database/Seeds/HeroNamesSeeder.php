<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use Faker\Factory;

class HeroNamesSeeder extends Seeder
{
    public function run()
    {
        $faker = Factory::create('fr_FR');
        $data = [];
        $usedNames = [];
        $totalNames = 300;
        for ($i = 0; $i < $totalNames; $i++) {
            $name = ucfirst($faker->word()) . ' ' . ucfirst($faker->word());

            if(!in_array($name, $usedNames)) {
                $usedNames[] = $name;
                $data[] = [
                    'name' => $name,
                ];
            }

        }
        $this->db->table('hero_names')->insertBatch($data);
    }
}
