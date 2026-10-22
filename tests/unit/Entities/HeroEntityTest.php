<?php

namespace Tests\Unit\Entities;

use App\Entities\Hero;
use CodeIgniter\I18n\Time;
use CodeIgniter\Test\CIUnitTestCase;

final class HeroEntityTest extends CIUnitTestCase
{
    public function testDefaultValues()
    {
        $hero = new Hero();

        $this->assertSame(100, $hero->stamina_current);
        $this->assertSame(100, $hero->stamina_max);
        $this->assertSame(1, $hero->power);
    }

    public function testCastsConvertStringsToInt()
    {
        $hero = new Hero(['power' => '35', 'player_id' => '4']);

        $this->assertSame(35, $hero->power);
        $this->assertSame(4, $hero->player_id);
    }

    public function testUpdateStaminaDoesNothingWhenFull()
    {
        $hero = new Hero(['stamina_current' => 100, 'stamina_max' => 100]);

        $this->assertFalse($hero->updateStamina());
        $this->assertSame(100, $hero->stamina_current);
    }

    public function testUpdateStaminaInitializesLastUpdateWhenNull()
    {
        $hero = new Hero(['stamina_current' => 50, 'last_stamina_update' => null]);

        $this->assertFalse($hero->updateStamina());
        $this->assertNotNull($hero->last_stamina_update);
        $this->assertSame(50, $hero->stamina_current);
    }

    public function testUpdateStaminaDoesNothingBeforeTwoMinutes()
    {
        $hero = new Hero([
            'stamina_current'     => 50,
            'last_stamina_update' => Time::now()->subSeconds(90)->toDateTimeString(),
        ]);

        $this->assertFalse($hero->updateStamina());
        $this->assertSame(50, $hero->stamina_current);
    }

    public function testUpdateStaminaGainsOnePointEveryTwoMinutes()
    {
        $hero = new Hero([
            'stamina_current'     => 50,
            'last_stamina_update' => Time::now()->subMinutes(10)->subSeconds(5)->toDateTimeString(),
        ]);

        $this->assertTrue($hero->updateStamina());
        $this->assertSame(55, $hero->stamina_current);
    }

    public function testUpdateStaminaNeverExceedsMax()
    {
        $hero = new Hero([
            'stamina_current'     => 90,
            'stamina_max'         => 100,
            'last_stamina_update' => Time::now()->subHours(5)->toDateTimeString(),
        ]);

        $this->assertTrue($hero->updateStamina());
        $this->assertSame(100, $hero->stamina_current);
    }
}
