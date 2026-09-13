<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\SpecializationLevelModel;

class SpecializationLevelController extends BaseController
{
    protected $helpers = ['form', 'url'];
    protected $layout  = 'back';

    private $specializationLevelModel = null;

    public function __construct()
    {
        // Utiliser la syntaxe ::class sécurise l'instanciation du modèle
        $this->specializationLevelModel = model(SpecializationLevelModel::class);
    }

    public function index()
    {
        $specializationLevels = $this->specializationLevelModel->findAll();

        return $this->render('admin/specialization-level/index', [
            'specializationLevels' => $specializationLevels
        ]);
    }

    public function create()
    {
        $data = [
            'level'               => $this->request->getPost('level'),
            'experience_required' => $this->request->getPost('experience_required')
        ];

        if ($this->specializationLevelModel->save($data)) {
            $this->success('Niveau ajouté avec succès.');
        } else {
            $this->error('Erreur lors de l\'ajout du niveau.');
        }

        return redirect()->to('/admin/specialization-level');
    }

    public function update()
    {
        $id = $this->request->getPost('id');

        $data = [
            'id'                  => $id,
            'level'               => $this->request->getPost('level'),
            'experience_required' => $this->request->getPost('experience_required')
        ];

        if ($id && $this->specializationLevelModel->save($data)) {
            $this->success('Niveau mis à jour avec succès.');
        } else {
            $this->error('Erreur lors de la mise à jour.');
        }

        return redirect()->to('/admin/specialization-level');
    }

    public function delete()
    {
        $id = $this->request->getPost('id');

        if ($id !== null && $this->specializationLevelModel->delete($id)) {
            $this->success('Niveau supprimé avec succès.');
        } else {
            $this->error('Impossible de supprimer ce niveau.');
        }

        return redirect()->to('/admin/specialization-level');
    }
}