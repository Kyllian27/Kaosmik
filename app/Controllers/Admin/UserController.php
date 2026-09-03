<?php

/**
 * NAMESPACE
 * Déclare l'espace de noms de cette classe.
 * Cela permet à PHP de retrouver et d'organiser les fichiers sans conflit de noms.
 * Ici, ce contrôleur appartient à la section "Admin" de l'application.
 */
namespace App\Controllers\Admin;

/**
 * USE - IMPORTATION DES CLASSES
 * On importe les classes dont on a besoin dans ce fichier.
 * Sans ces lignes, PHP ne saurait pas où trouver "BaseController", "Player", etc.
 */
use App\Controllers\BaseController;
use App\Entities\Player;
use App\Entities\User;
use CodeIgniter\HTTP\ResponseInterface;

/**
 * CONTRÔLEUR ADMIN - GESTION DES UTILISATEURS
 *
 * Un contrôleur reçoit les requêtes HTTP et orchestre la logique de l'application.
 * Il fait le lien entre :
 *   - les Models (accès à la base de données)
 *   - les Views (affichage HTML)
 *
 * Ce contrôleur hérite de BaseController, qui lui apporte des méthodes communes
 * comme render(), redirect(), success(), error(), etc.
 *
 * Convention CRUD : les actions typiques d'un contrôleur sont :
 *   index()  → lister les ressources
 *   new()    → afficher le formulaire de création
 *   create() → traiter la soumission du formulaire de création
 *   edit()   → afficher le formulaire de modification
 *   update() → traiter la soumission du formulaire de modification
 */
class UserController extends BaseController
{
    /**
     * PROPRIÉTÉS DE CLASSE
     *
     * $layout : indique quel template de mise en page utiliser pour les vues.
     *           "back" correspond au layout de l'interface d'administration.
     *
     * $userModel et $playerModel : on stocke les modèles dans des propriétés
     * pour pouvoir les réutiliser dans toutes les méthodes de la classe.
     * Le mot-clé "private" signifie qu'ils ne sont accessibles que depuis
     * l'intérieur de cette classe.
     */
    protected $layout = "back";
    private $userModel;
    private $playerModel;

    protected $current_menu = 'user';
    /**
     * CONSTRUCTEUR
     *
     * Le constructeur est appelé automatiquement à chaque instanciation de la classe.
     * C'est ici qu'on initialise les dépendances dont le contrôleur a besoin.
     *
     * model("UserModel") est un helper CodeIgniter qui charge et retourne
     * une instance du modèle correspondant (équivalent à new UserModel()).
     */
    public function __construct()
    {
        $this->userModel = model("UserModel");
        $this->playerModel = model("PlayerModel");
    }

    /**
     * INDEX - LISTE DES UTILISATEURS
     *
     * Cette méthode est appelée quand on accède à /admin/user.
     * Elle récupère tous les utilisateurs en base de données et les envoie à la vue.
     *
     * helper('form') charge les fonctions utilitaires pour générer des formulaires HTML.
     * findAll() exécute un SELECT * sur la table des utilisateurs.
     * render() appelle la vue en lui passant les données sous forme de tableau associatif.
     * La clé 'users' sera une variable $users dans la vue.
     */
    public function index()
    {
        helper('form');
        $this->title = "Liste des utilisateurs";

        // Récupère tous les utilisateurs depuis la base de données
        $users = $this->userModel->findAll();

        // Envoie les utilisateurs à la vue pour affichage
        return $this->render('admin/user/index', ['users' => $users]);
    }

    /**
     * EDIT - FORMULAIRE DE MODIFICATION
     *
     * Affiche le formulaire prérempli pour modifier un utilisateur existant.
     * L'argument $id correspond à l'identifiant de l'utilisateur dans l'URL
     * (ex : /admin/user/edit/5 → $id = 5).
     *
     * find($id) exécute un SELECT WHERE id = $id et retourne une entité User
     * ou null si aucun enregistrement n'est trouvé.
     */
    public function edit($id = null)
    {
        helper('form');

        // Recherche l'utilisateur par son ID
        $user = $this->userModel->find($id);

        // Passe l'utilisateur à la vue (null si non trouvé, la vue doit le gérer)
        return $this->render('admin/user/form', ['user' => $user]);
    }

    /**
     * NEW - FORMULAIRE DE CRÉATION
     *
     * Affiche un formulaire vide pour créer un nouvel utilisateur.
     * Aucune donnée n'est passée à la vue, car c'est une création (pas de $user existant).
     */
    public function new()
    {
        helper('form');
        return $this->render('admin/user/form');
    }

    /**
     * UPDATE - TRAITEMENT DE LA MODIFICATION
     *
     * Reçoit et traite les données du formulaire de modification (méthode POST).
     * Cette méthode suit un schéma classique : validation → récupération → mise à jour.
     *
     * Étapes :
     *   1. Récupération des données POST
     *   2. Validation de l'identifiant
     *   3. Récupération des entités en base
     *   4. Normalisation des données
     *   5. Sauvegarde et retour utilisateur
     */
    public function update()
    {
        // getPost() récupère toutes les données envoyées via le formulaire (méthode HTTP POST)
        $data = $this->request->getPost();

        // VALIDATION : on vérifie que l'ID est bien présent dans les données du formulaire.
        // Sans ID, on ne sait pas quel utilisateur modifier → on redirige avec une erreur.
        if (!isset($data['id'])) {
            $this->error('Identifiant inconnu');
            return $this->redirect('/admin/user');
        }

        // On extrait l'ID et on le supprime du tableau $data
        // pour ne pas l'envoyer par erreur dans les champs à mettre à jour.
        $user_id = $data['id'];
        unset($data['id']);

        // RÉCUPÉRATION DES ENTITÉS
        // On charge l'utilisateur depuis la BDD. find() retourne null si introuvable.
        $user = $this->userModel->find($user_id);
        if ($user === null) {
            $this->error('Utilisateur introuvable dans la base de données.');
            return $this->redirect('/admin/user');
        }

        // getPlayer() est une méthode de l'entité User qui charge le Player associé
        // (relation one-to-one via la clé étrangère user_id dans la table players).
        $player = $user->getPlayer();
        if ($player === null) {
            $this->error('Aucun profil de joueur associé à cet utilisateur.');
            return $this->redirect('/admin/user');
        }

        // NORMALISATION DU CHAMP "active" (case à cocher HTML)
        // Une case à cocher HTML n'envoie rien lorsqu'elle est décochée.
        // Si elle est cochée, elle envoie la valeur "on".
        // On convertit ce comportement en 1 (actif) ou 0 (inactif) pour la BDD.
        if (isset($data['active']) && $data['active'] == 'on') {
            $data['active'] = 1;
        } else {
            $data['active'] = 0;
        }

        // REMPLISSAGE DES ENTITÉS
        // fill() applique les données du tableau sur les propriétés correspondantes de l'entité.
        // Les champs qui n'existent pas dans l'entité sont ignorés.
        $user->fill($data);
        $player->fill($data);

        // SAUVEGARDE EN BASE DE DONNÉES
        // save() fait un UPDATE si l'entité a un ID, ou un INSERT si elle n'en a pas.
        // Il retourne true en cas de succès, false en cas d'erreur.
        $saveUserOK = $this->userModel->save($user);
        $savePlayerOk = $this->playerModel->save($player);

        if ($saveUserOK == false || $savePlayerOk == false) {
            $this->error('Une erreur est survenue lors de la sauvegarde');
            return $this->redirect('/admin/user/edit/' . $user_id);
        }

        // RETOUR UTILISATEUR : message de succès + redirection
        $this->success($user->username . " a bien été modifié.");
        return $this->redirect('/admin/user/edit/' . $user_id);
    }

    /**
     * CREATE - TRAITEMENT DE LA CRÉATION
     *
     * Reçoit et traite les données du formulaire de création (méthode POST).
     * La création est plus complexe que la modification car elle implique
     * deux entités liées : User ET Player (relation one-to-one).
     *
     * Ordre des opérations important :
     *   1. Créer le User en premier pour obtenir son ID auto-généré
     *   2. Assigner cet ID comme clé étrangère du Player
     *   3. Créer le Player
     */
    public function create()
    {
        $data = $this->request->getPost();

        // NORMALISATION DU CHAMP "active" (même logique que dans update())
        // L'opérateur ternaire ? : est une façon condensée d'écrire un if/else.
        $data['active'] = (isset($data['active']) && $data['active'] == 'on') ? 1 : 0;

        // ÉTAPE 1 : CRÉATION DE L'UTILISATEUR
        // On instancie une nouvelle entité User (objet vide) et on la remplit avec le formulaire.
        $user = new User();
        $user->id = "";
        $user->fill($data);

        // Shield (le module d'authentification) gère l'email séparément via un système d'identités.
        // On lui assigne directement depuis le champ "mail" du formulaire.
        // ?? '' est l'opérateur "null coalescing" : retourne '' si $data['mail'] n'existe pas.
        $user->email = $data['mail'] ?? '';

        $saveUserOK = $this->userModel->save($user);

        if (!$saveUserOK) {
            $this->error('Une erreur est survenue lors de la création de l\'utilisateur.');
            return $this->redirect('/admin/user/new');
        }

        // getInsertID() retourne l'ID auto-incrémenté généré par le dernier INSERT.
        // On en a besoin pour lier le Player à cet User via la clé étrangère.
        $userId = $this->userModel->getInsertID();

        // Ajoute l'utilisateur au groupe par défaut (rôle de base défini dans la config Shield).
        $this->userModel->addToDefaultGroup($this->userModel->find($userId));

        // ÉTAPE 2 : CRÉATION DU PLAYER ASSOCIÉ
        // Un Player est le profil de jeu lié à un User (relation one-to-one).
        $player = new Player();
        $player->fill($data);

        // On associe le Player à l'User via la clé étrangère user_id.
        // C'est cette valeur qui crée le lien en base de données.
        $player->user_id = $userId;

        $savePlayerOk = $this->playerModel->save($player);

        if (!$savePlayerOk) {
            // L'utilisateur existe déjà en BDD, mais son profil joueur n'a pas pu être créé.
            // On redirige vers l'édition pour permettre de corriger manuellement.
            $this->error('Utilisateur créé, mais impossible de créer le profil joueur.');
            return $this->redirect('/admin/user/edit/' . $userId);
        }

        $this->success("L'utilisateur " . $user->username . " a été créé avec succès.");
        return $this->redirect('/admin/user');
    }
}