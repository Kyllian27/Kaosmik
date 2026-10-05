<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Entities\RarityLevel;
use App\Models\RarityLevelModel;
use CodeIgniter\HTTP\ResponseInterface;

class RarityLevelController extends BaseController
{
    protected $layout = 'back';
    private $rarityLevelModel;
    protected $current_menu = "rarity_level";

    public function __construct() {
        $this->rarityLevelModel = new RarityLevelModel();
    }
    public function index()
    {
        helper('form');
        $rarityLevels = $this->rarityLevelModel->findAll();
        return $this->render('admin/rarity-level/index', ['rarityLevels' => $rarityLevels]);
    }

    public function create() {
        $data = $this->request->getPost();
        $rarityLevel = new RarityLevel();
        $rarityLevel->fill($data);
        $saveOk = $this->rarityLevelModel->save($rarityLevel);
        if ($saveOk) {
            $this->success('Rareté ajouté');
        } else {
            $this->error('Une erreur est survenue, la rareté n\'est pas ajoutée.');
        }
        return $this->redirect('admin/rarity-level');
    }

    public function update() {
        $data = $this->request->getPost();
        $rarityLevel = new RarityLevel();
        $rarityLevel->fill($data);
        $saveOk = $this->rarityLevelModel->save($rarityLevel);
        if ($saveOk) {
            $this->success('Rareté modifié');
        } else {
            $this->error('Une erreur est survenue, la rareté n\'est pas modifié.');
        }
        return $this->redirect('admin/rarity-level');
    }

    public function delete() {
        try {
            $id = $this->request->getPost('id');
//            if ($id == 1) {
//                $this->error("Impossible de supprimer la rareté par défaut (commun)");
//                return $this->redirect('admin/rarity-level');
//            }
            $deleteOk = $this->rarityLevelModel->delete($id);
            if($deleteOk){
                $this->success('Rareté supprimée');
            } else {
                $this->error('Une erreur est survenue');
            }
        } catch (\Exception $e) {
            $this->error($e->getMessage());
        }
        return $this->redirect('admin/rarity-level');
    }
}
