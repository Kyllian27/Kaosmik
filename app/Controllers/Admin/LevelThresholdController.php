<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\LevelThresholdModel;
use CodeIgniter\HTTP\ResponseInterface;

class LevelThresholdController extends BaseController
{
    private $levelThresholdModel;
    protected $layout = 'back';
    protected $current_menu = 'level-threshold';

    public function __construct(){
        $this->levelThresholdModel = model('LevelThresholdModel');
    }
    public function index()
    {
        helper('form');
        $levelThresholds = $this->levelThresholdModel->orderBy('level', 'ASC')->findAll();
        return $this->render('admin/level-threshold/index', ['levelThresholds' => $levelThresholds]);
    }

    public function create() {
        $data = $this->request->getPost();
        if ($this->levelThresholdModel->insert($data)) {
            $this->success("Niveau ajouté !");
        } else {
            $this->error("Erreur lors de l'ajout du niveau");
        }
        return $this->redirect('/admin/level-threshold');
    }

    public function delete() {
        $id = $this->request->getVar('id');
        if ($this->levelThresholdModel->delete($id)) {
            $this->success('Niveau supprimé');
        } else {
            $this->error("Erreur lors de la suppression du niveau");
        }
        return $this->redirect('/admin/level-threshold');
    }

    public function update() {
        $data = $this->request->getPost();
        $id = $data['id'];
        unset($data['id']);
        if ($this->levelThresholdModel->update($id, $data)) {
            $this->success('Niveau modifié');
        } else {
            $this->error("Erreur lors de la modification du niveau");
        }
        return $this->redirect('/admin/level-threshold');
    }
}
