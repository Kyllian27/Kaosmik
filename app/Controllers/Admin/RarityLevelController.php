<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\RarityLevelModel;
use App\Entities\RarityLevel;

class RarityLevelController extends BaseController
{
    // Chargement du helper de formulaire pour l'utilisation de form_open(), form_close(), etc.
    protected $helpers = ['form'];

    protected $rarityLevelModel;

    public function __construct()
    {
        $this->rarityLevelModel = new RarityLevelModel();
    }

    public function index()
    {
        $data = [
            'rarityLevels' => $this->rarityLevelModel->findAll()
        ];

        return $this->render('admin/rarity-level/index', $data);
    }

    public function create()
    {
        $rarity = new RarityLevel($this->request->getPost());

        if ($this->rarityLevelModel->save($rarity)) {
            return redirect()->to('admin/rarity-level')->with('success', 'Rareté ajoutée avec succès.');
        }

        return redirect()->back()->withInput()->with('errors', $this->rarityLevelModel->errors());
    }

    public function update()
    {
        $id = $this->request->getPost('id');
        $rarity = $this->rarityLevelModel->find($id);

        if (!$rarity) {
            return redirect()->to('admin/rarity-level')->with('error', 'Rareté introuvable.');
        }

        $rarity->fill($this->request->getPost());

        if ($this->rarityLevelModel->save($rarity)) {
            return redirect()->to('admin/rarity-level')->with('success', 'Rareté mise à jour.');
        }

        return redirect()->back()->withInput()->with('errors', $this->rarityLevelModel->errors());
    }

    public function delete()
    {
        $id = $this->request->getPost('id');

        if ($this->rarityLevelModel->delete($id)) {
            return redirect()->to('admin/rarity-level')->with('success', 'Rareté supprimée.');
        }

        return redirect()->to('admin/rarity-level')->with('error', 'Impossible de supprimer cette rareté.');
    }
}