<?php

namespace Tests\Feature;

use CodeIgniter\Test\CIUnitTestCase;
use CodeIgniter\Test\DatabaseTestTrait;
use App\Services\MissionService;
use App\Models\MissionModel;
use App\Models\HeroModel;
use App\Models\PlayerModel;
use App\Models\MissionResolutionModel;
use App\Models\MissionHeroModel;

final class MissionServiceTest extends CIUnitTestCase
{
    use DatabaseTestTrait;

    protected $migrate   = true;
    protected $refresh   = true;
    protected $DBGroup   = 'tests';
    protected $seed      = 'Tests\Support\Database\Seeds\KaosmikTestSeeder';

    protected MissionService $missionService;


    public function testStartMissionCreatesResolutionAndUpdatesStamina()
    {

        $playerModel = model(PlayerModel::class);
        $heroModel = model(HeroModel::class);

    }
}
