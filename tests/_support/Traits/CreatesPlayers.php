<?php
namespace Tests\Support\Traits;

use App\Entities\User;
use App\Entities\Hero;
use App\Entities\Player;
use App\Models\HeroModel;
use App\Models\PlayerModel;
use App\Models\UserModel;

/**
 * Fabrique les donnés de base dont presque tout les test ont besoin
 *
 * un utilisateur shield son profil player et si besoin des heros
 */
trait CreatesPlayers
{
    protected function createUser(string $username = 'joueur1', string $password = 'Kaosmik2026!'): User
    {
        $users = model(UserModel::class);
        $user = new User([
            'username' => $username,
            'password' => $password,
            'email' => $username.'@kaosmik.test',
        ]);
        $users->save($user);
        $userId = $users->getInsertId();
        $users->addToDefaultGroup($userId);

        return $users->findById($userId);
    }

    protected function createPlayer(string $username = 'joueur1', array $overrides = []): Player
    {
        $user = $this->createUser($username);
        $playerModel = model(PlayerModel::class);

        $playerId = $playerModel->insert(array_merge([
            'user_id' => $user->id,
        ], $overrides));

        return $playerModel->find($playerId);
    }

    protected function getUserof(Player $player): User
    {
        return model(UserModel::class)->findById($player->user_id);
    }

    protected function createHero(Player $player, array $overrides = []): Hero
    {
        $heroModel = model(HeroModel::class);

        $id = $heroModel->insert(new Hero(array_merge([
            'player_id' => $player->id,
            'hero_model_id' => 1,
            'rarity_id' => 1,
            'name' => 'test mercenaire',
            'power' => 20,
            'cost_credit' => 100,
        ], $overrides)));

        return $heroModel->find($id);
    }
}