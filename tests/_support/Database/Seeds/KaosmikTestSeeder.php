<?php
namespace Tests\Support\Database\Seeds;
use CodeIgniter\Database\Seeder;
class KaosmikTestSeeder extends Seeder{
    public function run(): void{
        //L'ordre compte : les spécialisation avant les modéles de héros (clef étrangere)
        $this->call('App\Database\Seeds\LevelThresholdSeeder');
        $this->call('App\Database\Seeds\SpecializationSeeder');;
        $this->call('App\Database\Seeds\RarityLevelSeeder');;
        $this->call('App\Database\Seeds\HeroModelsSeeder');;
        $this->call('App\Database\Seeds\HeroNamesSeeder');;
        $this->call('App\Database\Seeds\MissionsSeeder');;
    }
}
