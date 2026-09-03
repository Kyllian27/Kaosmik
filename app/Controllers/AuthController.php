<?php

/**
 * NAMESPACE
 * Ce contrôleur est dans le namespace racine "App\Controllers" (pas dans Admin),
 * car l'authentification est accessible à tous les utilisateurs, pas seulement aux admins.
 */
namespace App\Controllers;

/**
 * USE - IMPORTATION DES CLASSES
 *
 * On importe ici les contrôleurs natifs de Shield (la bibliothèque d'authentification de CodeIgniter).
 * Le mot-clé "as" crée un alias local pour éviter les conflits de noms :
 *   - ShieldLogin   → représente le contrôleur de connexion de Shield
 *   - ShieldRegister → représente le contrôleur d'inscription de Shield
 *
 * Cette approche est un pattern de "délégation" : plutôt que de réécrire toute la logique
 * d'authentification, on délègue à Shield tout en gardant la main pour personnaliser le comportement.
 */
use CodeIgniter\Shield\Controllers\LoginController as ShieldLogin;
use CodeIgniter\Shield\Controllers\RegisterController as ShieldRegister;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\PlayerModel;
use App\Entities\Player;

/**
 * CONTRÔLEUR D'AUTHENTIFICATION
 *
 * Ce contrôleur gère tout ce qui concerne l'identité de l'utilisateur :
 *   - Connexion (login)
 *   - Déconnexion (logout)
 *   - Inscription (register)
 *
 * Il hérite de BaseController (nos méthodes communes : render, redirect, success, error…)
 * mais délègue la logique de sécurité à Shield, la bibliothèque officielle d'auth de CodeIgniter 4.
 *
 * Pourquoi ne pas étendre directement ShieldLogin ou ShieldRegister ?
 * Parce qu'on a besoin des deux à la fois, et PHP ne supporte pas l'héritage multiple.
 * La délégation (composition) est la solution : on instancie Shield à la demande.
 */
class AuthController extends BaseController
{
    /**
     * LOGIN VIEW - AFFICHAGE DU FORMULAIRE DE CONNEXION
     *
     * Avant d'afficher la page de connexion, on vérifie si l'utilisateur
     * est déjà connecté. Si oui, le renvoyer vers la page de login n'a pas de sens,
     * on le redirige directement vers l'accueil.
     *
     * auth() est un helper global de Shield qui donne accès au service d'authentification.
     * loggedIn() retourne true si une session utilisateur active est détectée.
     */
    public function loginView()
    {
        // Redirection si déjà connecté : évite une page de login inutile
        if (auth()->loggedIn()) {
            return redirect()->to('/');
        }

        $this->title = "Connexion";
        return $this->render('shield/login');
    }

    /**
     * LOGIN ACTION - TRAITEMENT DU FORMULAIRE DE CONNEXION
     *
     * Cette méthode reçoit les données POST du formulaire (email + mot de passe)
     * et délègue entièrement le traitement au contrôleur natif de Shield.
     *
     * Pourquoi initController() ?
     * Shield's LoginController a besoin d'accéder à $request, $response et $logger,
     * mais comme il est instancié manuellement (new ShieldLogin()), CodeIgniter
     * ne les injecte pas automatiquement. initController() fait cette injection manuellement.
     *
     * Shield gère pour nous :
     *   - La validation des champs (email valide, mot de passe non vide)
     *   - La vérification en base de données
     *   - La création de la session utilisateur
     *   - La gestion des tentatives échouées (brute-force protection)
     *   - La redirection après connexion réussie
     */
    public function loginAction()
    {
        // Instanciation manuelle du contrôleur Shield
        $shieldLogin = new ShieldLogin();

        // Injection des dépendances HTTP (request, response, logger)
        $shieldLogin->initController($this->request, $this->response, $this->logger);

        // Délégation complète : Shield traite le login et retourne la réponse HTTP
        return $shieldLogin->loginAction();
    }

    /**
     * REGISTER VIEW - AFFICHAGE DU FORMULAIRE D'INSCRIPTION
     *
     * Même logique que loginView() : si l'utilisateur est déjà connecté,
     * l'affichage du formulaire d'inscription n'a pas de sens.
     */
    public function registerView()
    {
        // Redirection si déjà connecté
        if (auth()->loggedIn()) {
            return redirect()->to('/');
        }

        $this->title = "Inscription";
        return $this->render('Shield/register');
    }

    /**
     * REGISTER ACTION - TRAITEMENT DE L'INSCRIPTION
     *
     * C'est la méthode la plus complexe du contrôleur car elle étend le comportement
     * par défaut de Shield : en plus de créer l'utilisateur, elle crée automatiquement
     * un profil Player associé.
     *
     * Pourquoi cette approche "post-traitement" ?
     * Shield crée le User, mais ne connaît pas notre entité Player (spécifique à notre app).
     * On laisse Shield faire son travail, puis on ajoute notre logique métier après.
     *
     * Flux d'exécution :
     *   1. Shield valide les données et crée le User en base
     *   2. Shield connecte automatiquement le nouvel utilisateur
     *   3. On détecte que l'utilisateur est connecté → on crée le Player
     *   4. On retourne la réponse HTTP de Shield (qui gère la redirection)
     */
    public function registerAction()
    {
        // ÉTAPE 1 : Délégation à Shield pour la création du User
        $shieldRegister = new ShieldRegister();
        $shieldRegister->initController($this->request, $this->response, $this->logger);

        // registerAction() crée l'utilisateur, le connecte, et retourne une réponse HTTP.
        // On stocke cette réponse pour la retourner à la fin (Shield gère la redirection).
        $response = $shieldRegister->registerAction();

        // ÉTAPE 2 : Post-traitement — création du Player
        // auth()->loggedIn() est le moyen le plus fiable de savoir si Shield
        // a bien créé et connecté l'utilisateur (indépendamment du code de réponse HTTP).
        if (auth()->loggedIn()) {
            // auth()->user() retourne l'entité User actuellement connectée
            $user = auth()->user();

            $playerModel = model(PlayerModel::class);

            // PROTECTION ANTI-DOUBLON
            // Dans certains cas (ex: événements CI4, hooks), un Player pourrait avoir
            // déjà été créé automatiquement. On vérifie avant d'en créer un second
            // pour éviter une violation de contrainte d'unicité en base.
            if (!$playerModel->findByUserId($user->id)) {
                // On crée un Player minimal avec juste la clé étrangère user_id.
                // Les autres champs (pseudo, avatar…) pourront être remplis plus tard par l'utilisateur.
                $player = new Player([
                    'user_id' => $user->id,
                ]);
                $playerModel->save($player);
            }

            $this->success("Votre compte et votre profil de jeu ont été créés avec succès !");
        }

        // On retourne la réponse de Shield (redirection vers la page d'accueil ou d'erreur)
        return $response;
    }

    /**
     * LOGOUT ACTION - DÉCONNEXION
     *
     * Délègue entièrement la déconnexion à Shield.
     * Shield s'occupe de :
     *   - Invalider la session en cours
     *   - Supprimer le cookie "remember me" si présent
     *   - Rediriger vers la page configurée dans la config Shield
     */
    public function logoutAction()
    {
        $shieldLogin = new ShieldLogin();
        $shieldLogin->initController($this->request, $this->response, $this->logger);

        return $shieldLogin->logoutAction();
    }
}
