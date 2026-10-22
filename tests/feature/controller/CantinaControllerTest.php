<?php

namespace Tests\Feature\Controllers;

use App\Services\CantinaService;
use CodeIgniter\Shield\Test\AuthenticationTesting;
use CodeIgniter\Test\CIUnitTestCase;
use CodeIgniter\Test\DatabaseTestTrait;
use CodeIgniter\Test\FeatureTestTrait;
use Config\Services;
use Tests\Support\Traits\CreatesPlayers;

final class CantinaControllerTest extends CIUnitTestCase
{
    use DatabaseTestTrait;
    use FeatureTestTrait;
    use AuthenticationTesting;
    use CreatesPlayers;

    protected $migrate   = true;
    protected $refresh   = true;
    protected $DBGroup   = 'tests';
    protected $namespace = null;
    protected $seed      = 'Tests\Support\Database\Seeds\KaosmikTestSeeder';

    protected function setUp(): void
    {
        parent::setUp();

        $this->resetServices();
        $this->mockSession();
    }

    public function testCantinaGeneratesThreeOffers()
    {
        $player = $this->createPlayer('joueur1');
        $this->actingAs($this->getUserOf($player));

        $result = $this->get('/cantina');

        $result->assertStatus(200);
        $this->seeNumRecords(3, 'cantinas', ['player_id' => $player->id]);
    }
    public function testCantinaDisplaysRemainingTimeFromService()
    {
        $player = $this->createPlayer('joueur1');
        $this->actingAs($this->getUserOf($player));

        // Le service est remplacé par un faux : aucune offre en base, temps imposé
        $mock = $this->createMock(CantinaService::class);
        $mock->method('getOrGenerateOffers')->willReturn([
            'cantinaHeroes'     => [],
            'remaining_time'    => '04:20:00',
            'remaining_seconds' => 15600,
        ]);
        Services::injectMock('cantina', $mock);

        $result = $this->get('/cantina');

        $result->assertStatus(200);
        $result->assertSee('04:20:00');
    }
    public function testRecruitCreatesAHeroAndSpendsCredits()
    {
        $player = $this->createPlayer('joueur1');
        $this->actingAs($this->getUserOf($player));

        $this->get('/cantina');
        $offer = model('CantinaModel')->where('player_id', $player->id)->first();

        $result = $this->post('/cantina/recruit/' . $offer->id);

        $result->assertRedirectTo(site_url('/cantina'));
        $this->seeInDatabase('heroes', ['player_id' => $player->id, 'name' => $offer->name]);
        $this->seeInDatabase('players', ['id' => $player->id, 'credits' => 1000 - $offer->cost_credit]);
    }


}
