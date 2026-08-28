<?php

namespace App\Controllers;

use CodeIgniter\Shield\Controllers\LoginController as ShieldLogin;
use CodeIgniter\Shield\Controllers\RegisterController as ShieldRegister;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\PlayerModel;
use App\Entities\Player;

class AuthController extends BaseController
{
    /**
     * Affiche la vue de connexion
     */
    public function loginView()
    {
        if (auth()->loggedIn()) {
            return redirect()->to('/');
        }

        $this->title = "Connexion";
        return $this->render('shield/login');
    }

    /**
     * Traite la tentative de connexion
     */
    public function loginAction()
    {
        // Utilise la logique native de Shield pour traiter le login
        $shieldLogin = new ShieldLogin();
        $shieldLogin->initController($this->request, $this->response, $this->logger);
        return $shieldLogin->loginAction();
    }

    /**
     * Affiche la vue d'inscription
     */
    public function registerView()
    {
        if (auth()->loggedIn()) {
            return redirect()->to('/');
        }

        $this->title = "Inscription";
        return $this->render('Shield/register');
    }

    /**
     * Traite l'inscription et crée le profil Player
     */
    public function registerAction()
    {
        // 1. Traitement standard de l'inscription via Shield
        $shieldRegister = new ShieldRegister();

        $shieldRegister->initController($this->request, $this->response, $this->logger);

        $response = $shieldRegister->registerAction();

        // 2. Si l'utilisateur vient d'être créé et connecté
        if (auth()->loggedIn()) {
            $user = auth()->user();

            // Création du Player associé
            $playerModel = model(PlayerModel::class);

            // Vérification anti-doublon au cas où l'événement CI4 aurait déjà fonctionné
            if (!$playerModel->findByUserId($user->id)) {
                $player = new Player([
                    'user_id' => $user->id,
                ]);
                $playerModel->save($player);
            }

            $this->success("Votre compte et votre profil de jeu ont été créés avec succès !");
        }

        return $response;
    }

    /**
     * Déconnexion
     */
    public function logoutAction()
    {
        $shieldLogin = new ShieldLogin();

        $shieldLogin->initController($this->request, $this->response, $this->logger);

        return $shieldLogin->logoutAction();
    }
}