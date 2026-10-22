<?php

namespace Tests\Unit\Entities;

use App\Entities\Mission;
use CodeIgniter\Test\CIUnitTestCase;

final class MissionEntityTest extends CIUnitTestCase
{
public function testStaminaREquiredUsesTheMaximunCost(){
    $mission = new Mission(['stamina_cost' => 10,'stamina_cost_max' => 20]);

    $this->assertEquals(20,$mission->getStaminaRequired());
}
public function testPowerREquiredUsesTheMaximunValue(){
    $mission = new Mission(['pwer_required_min' => 15,'power_required_max' => 30]);
    $this->assertEquals(30,$mission->getPowerRequired());
}
}
