<?php

namespace App\Services;

use App\Models\CantinaModel;
use App\Models\HeroModelModel;
use App\Models\HeroNameModel;
use App\Models\PlayerModel;
use App\Models\RarityLevelModel;
use CodeIgniter\I18n\Time;

class CantinaService
{
    protected $cantinaModel;
    protected $playerModel;
    protected $heroModelModel;
    protected $rarityModel;
    protected $heroNameModel;

    public function __construct()
    {
        $this->cantinaModel   = model(CantinaModel::class);
        $this->playerModel    = model(PlayerModel::class);
        $this->heroModelModel = model(HeroModelModel::class);
        $this->rarityModel    = model(RarityLevelModel::class);
        $this->heroNameModel  = model(HeroNameModel::class);
    }

    public function getOnGeneratedOffers(int $playerId,int $number=3): array
    {
        $offers = $this->cantinaModel->where('player_id', $playerId)->findAll();

        if (!empty($offers)) {
            $hour = $offers[0]->created_at ?? null;

            if ($hour !== null) {
                $createdTime = Time::parse($hour);
                $now         = Time::now();
                $diff        = $createdTime->difference($now)->getHours();

                if ($diff < 12) {
                    return $offers;
                }
            }
        }

        return $this->generateOffers($playerId,$number=3);
    }

    public function generateOffers(int $playerId, int $number = 3): array
    {
        $this->cantinaModel->where('player_id', $playerId)->delete();

        $player      = $this->playerModel->find($playerId);
        $playerLevel = $player->level ?? 1;

        $now       = date('Y-m-d H:i:s');
        $batchData = [];

        for ($i = 0; $i < $number; $i++) {
            $heromodel = $this->heroModelModel->getRandom($playerLevel);

            if (!$heromodel) {
                continue;
            }

            $power = rand((int) $heromodel->power_min, (int) $heromodel->power_max);
            $cost  = rand((int) $heromodel->cost_credits_min, (int) $heromodel->cost_credits_max);

            $rarity = $this->rarityModel->getRandomRarity();

            $powermulti = $rarity ? (float) $rarity->power_multiplier : 1.0;
            $costmulti  = $rarity ? (float) $rarity->cost_multiplier : 1.0;

            $batchData[] = [
                'player_id'     => $playerId,
                'hero_model_id' => $heromodel->id,
                'rarity_id'     => $rarity ? $rarity->id : 1,
                'name'          => $this->heroNameModel->getRandom(),
                'power'         => (int) round($power * $powermulti),
                'cost_credit'   => (int) round($cost * $costmulti),
                'created_at'    => $now,
                'updated_at'    => $now,
            ];
        }

        if (!empty($batchData)) {
            $this->cantinaModel->insertBatch($batchData);
        }

        return $this->cantinaModel->where('player_id', $playerId)->findAll();
    }
}