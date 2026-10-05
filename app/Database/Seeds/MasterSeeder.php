<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class MasterSeeder extends Seeder
{
    public function run()
    {
        $this->call('LevelThresholdSeeder');
        $this->call('SpecializationSeeder');
        $this->call('RarityLevelSeeder');
        $this->call('HeroModelsSeeder');
        $this->call('HeroNamesSeeder');
        $this->call('MissionSeeder');
    }
}
