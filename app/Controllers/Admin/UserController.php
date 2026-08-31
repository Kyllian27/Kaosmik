<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class UserController extends BaseController
{
    protected $layout = "back";
    private $userModel;
    private $playerModel;

    public function __construct()
    {
        $this->userModel = model("UserModel");
        $this->playerModel = model("PlayerModel");
    }
    public function index()
    {
        helper('form');
        $this->title = "Liste des utilisateurs";
        $users = $this->userModel->findAll();
        return $this->render('admin/user/index', ['users' => $users]);
    }

    public function edit($id = null)
    {
        helper('form');
        $user = $this->userModel->find($id);
        return $this->render('admin/user/form', ['user' => $user]);
    }

    public function update() {
        $data = $this->request->getPost();
        //On vérifie qu'on à bien un ID
        if(!isset($data['id'])) {
            $this->error('Identifiant inconnu');
            $this->redirect('/admin/user');
        }
        $user_id = $data['id'];
        unset($data['id']);

        //Récupération des objets (entité)
        $user = $this->userModel->find($user_id);
        if($user === null) {
            $this->error('utilisateur introuvable');
            return $this->redirect('/admin/user');
        }

        //On vérifie si on à le champs active sinon on le met à 0
        if(isset($data['active']) && $data['active'] == 'on') {
            $data['active'] = 1;
        } else {
            $data['active'] = 0;
        }
        //On remplie nos objets
        $user->fill($data);
        $player->fill($data);
        //On sauvegarde en BDD
        $saveUserOK = $this->userModel->save($user);
        $savePlayerOK =$this->playerModel->save($player);
        if($savePlayerOK == false|| $saveUserOK == false) {
            $this->error('une erreur est survenue dans la sauvegarde');
            return $this->redirect('/admin/user/edit/'.$user_id);
        }


        //On affiche un message de réussite
        $this->success($user->username . " à bien été modifié.");
        //On redirige
        return $this->redirect('/admin/user/edit/'. $user_id);
    }
}