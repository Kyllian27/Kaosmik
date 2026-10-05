<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\SpecializationModel;
use CodeIgniter\HTTP\ResponseInterface;

class SpecializationController extends BaseController
{
    private $specializationModel;
    protected $layout = 'back';
    protected $current_menu = 'specialization';

    public function __construct(){
        $this->specializationModel = model('SpecializationModel');
    }

    public function index()
    {
        helper('form');
        $specializations = $this->specializationModel->findAll();
        return $this->render('admin/specialization/index', ['specializations' => $specializations]);
    }

    public function create() {
        $data = $this->request->getPost();
        if ($this->specializationModel->insert($data)) {
            $this->success('Spécialisation ajoutée');
        } else {
            $this->error("Une erreur est survenue, la spécialisation n'est pas ajoutée.");
        }
        return $this->redirect('admin/specialization');
    }

    public function update() {
        $data = $this->request->getPost();
        $id = $data['id'];
        unset($data['id']);
        try {
            if ($this->specializationModel->update($id, $data)) {
                $this->success('Spécialisation modifiée');
            } else {
                $this->error("Une erreur est survenue, la spécialisation n'est pas modifiée.");
            }
        } catch (\Exception $e) {
            $this->error($e->getMessage());
        }
        return $this->redirect('admin/specialization');
    }

    public function delete() {
        try {
            $id = $this->request->getPost('id');
            if ($this->specializationModel->delete($id)) {
                $this->success('Spécialisation supprimée');
            } else {
                $this->error('Une erreur est survenue');
            }
        } catch (\Exception $e) {
            $this->error($e->getMessage());
        }
        return $this->redirect('admin/specialization');
    }
}
