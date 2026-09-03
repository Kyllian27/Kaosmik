<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use CodeIgniter\Shield\Entities\User;

class UserController extends BaseController
{
    protected $layout = "back";
    private $userModel;
    private $playerModel;

    public function __construct()
    {
        $this->userModel = auth()->getProvider();
        $this->playerModel = model("PlayerModel");
    }

    public function index()
    {
        helper('form');
        $this->title = "Liste des utilisateurs";

        $users = $this->userModel->findAll();

        foreach ($users as $user) {
            $groups = $user->getGroups();
            $user->role = !empty($groups) ? implode(', ', $groups) : 'player';

            $player = $this->playerModel->where('user_id', $user->id)->first();
            $user->level = $player ? $player->level : 1;
        }

        return $this->render('admin/user/index', ['users' => $users]);
    }

    public function edit($id = null)
    {
        helper('form');
        $user = $this->userModel->find($id);

        if ($user === null) {
            $this->error('Utilisateur introuvable');
            return $this->redirect('admin/user');
        }

        $groups = $user->getGroups();
        $userRole = !empty($groups) ? $groups[0] : 'player';

        // Récupération des données Player pour les réinjecter dans le formulaire
        $player = $this->playerModel->where('user_id', $user->id)->first();

        return $this->render('admin/user/form', [
            'user'     => $user,
            'userRole' => $userRole,
            'player'   => $player
        ]);
    }

    public function new()
    {
        helper('form');
        $this->title = "Création d'un utilisateur";
        return $this->render('admin/user/form');
    }

    public function create()
    {
        $data = $this->request->getPost();

        $rules = [
            'username' => 'required|min_length[3]|is_unique[users.username]',
            'email'    => 'required|valid_email',
            'password' => 'required|min_length[8]',
        ];

        if (! $this->validate($rules)) {
            $this->error(implode('<br>', $this->validator->getErrors()));
            return $this->redirect("admin/user/new");
        }

        $user = new User([
            'username' => $data['username'],
            'email'    => $data['email'],
            'password' => $data['password'],
            'active'   => (isset($data['active']) && $data['active'] === 'on') ? 1 : 0,
        ]);

        try {
            if (! $this->userModel->save($user)) {
                $errors = implode('<br>', $this->userModel->errors());
                $this->error("Erreur Shield : " . $errors);
                return $this->redirect("admin/user/new");
            }

            $userId = $this->userModel->getInsertID();
            $createdUser = $this->userModel->find($userId);

            if ($createdUser) {
                $role = !empty($data['role']) ? $data['role'] : 'player';
                $createdUser->syncGroups($role);

                $playerData = [
                    'user_id'       => $userId,
                    'level'         => 1,
                    'experience'    => $data['experience'] ?? 0,
                    'credits'       => $data['credits'] ?? 0,
                    'fusion_energy' => $data['fusion_energy'] ?? 0,
                ];
                $this->playerModel->save($playerData);
            }

            $this->success("L'utilisateur " . esc($data['username']) . " a bien été créé.");
            return $this->redirect("admin/user");

        } catch (\Throwable $e) {
            $this->error("Erreur de création : " . $e->getMessage());
            return $this->redirect("admin/user/new");
        }
    }

    public function update()
    {
        $data = $this->request->getPost();

        if (empty($data['id'])) {
            $this->error('Identifiant inconnu');
            return $this->redirect('admin/user');
        }

        $user_id = $data['id'];

        $rules = [
            'username' => "required|min_length[3]|is_unique[users.username,id,{$user_id}]",
            'email'    => "required|valid_email",
        ];

        if (! $this->validate($rules)) {
            $this->error(implode('<br>', $this->validator->getErrors()));
            return $this->redirect('admin/user/edit/' . $user_id);
        }

        $user = $this->userModel->find($user_id);

        if ($user === null) {
            $this->error('Utilisateur introuvable');
            return $this->redirect('admin/user');
        }

        // Modification du mot de passe uniquement s'il est renseigné
        if (!empty($data['password'])) {
            $user->setPassword($data['password']);
        }

        $user->active   = (isset($data['active']) && $data['active'] === 'on') ? 1 : 0;
        $user->username = $data['username'];

        // Mise à jour explicite de l'email pour Shield
        if (method_exists($user, 'setEmail')) {
            $user->setEmail($data['email']);
        } else {
            $user->email = $data['email'];
        }

        try {
            if (! $this->userModel->save($user)) {
                $this->error(implode('<br>', $this->userModel->errors()));
                return $this->redirect('admin/user/edit/' . $user_id);
            }

            // Mise à jour du rôle
            if (!empty($data['role'])) {
                $user->syncGroups($data['role']);
            }

            // Mise à jour du profil Player
            $player = $this->playerModel->where('user_id', $user_id)->first();
            if ($player) {
                $playerData = [
                    'id'            => $player->id,
                    'experience'    => $data['experience'] ?? $player->experience,
                    'credits'       => $data['credits'] ?? $player->credits,
                    'fusion_energy' => $data['fusion_energy'] ?? $player->fusion_energy,
                ];
                $this->playerModel->save($playerData);
            }

            $this->success(esc($user->username) . " a bien été modifié.");
            return $this->redirect('admin/user');

        } catch (\Throwable $e) {
            $this->error("Erreur lors de la mise à jour : " . $e->getMessage());
            return $this->redirect('admin/user/edit/' . $user_id);
        }
    }

    public function delete($id = null)
    {
        if ($id === null) {
            $this->error("Utilisateur non spécifié.");
            return $this->redirect('admin/user');
        }

        $user = $this->userModel->find($id);

        if ($user === null) {
            $this->error("Utilisateur introuvable.");
            return $this->redirect('admin/user');
        }

        try {
            // Suppression de la fiche Player associée
            $this->playerModel->where('user_id', $id)->delete();

            // Suppression du compte Shield
            $this->userModel->delete($id, true); // true = purge définitive

            $this->success("L'utilisateur a été supprimé avec succès.");
        } catch (\Throwable $e) {
            $this->error("Erreur de suppression : " . $e->getMessage());
        }

        return $this->redirect('admin/user');
    }
}