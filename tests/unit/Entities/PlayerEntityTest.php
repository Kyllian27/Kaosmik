<?php
namespace Tests\Unit\Entities;

use App\Entities\Player;
use CodeIgniter\Test\CIUnitTestCase;

final class PlayerEntityTest extends CIUnitTestCase
{
    public function testNewPlayerStartsWithDefaultValues(){
    $player = new Player();

    $this->assertSame(1,$player->level);
    $this->assertSame(0,$player->experience);
    $this->assertSame(1000,$player->credits);
    $this->assertSame(10,$player->fleet_capacity);

    }

    public function testCastsConvetStringToInt(){
        $player = new Player(['credits' => '250']);

        $this->assertSame(250,$player->credits);
    }
}
