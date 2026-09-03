<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\LevelThresholdModel;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

class LevelThresholdController extends BaseController
{
    protected $layout = "back";
    private $thresholdModel;

    public function __construct()
    {

        // Instanciation directe avec new
        $this->thresholdModel = new LevelThresholdModel();
    }

    public function index()
    {
        helper('form');
        $this->title = "Gestion de la courbe de niveaux";

        $ltc = $this->thresholdModel->findAll();

        return $this->render('admin/level-threshold/index', ['levelThresholds' => $ltc]);
    }

    public function create()
    {
        $ltc = $this->request->getpost();
        if (isset($ltc)) {
            $this->thresholdModel->save($ltc);
            $this->sucess('Success');
            return $this->redirect('/admin/level-threshold');


        }
    }

    public function update()
    {
        $data = $this->request->getpost();
        if ($this->thresholdModel->update($data['id'], $data)) {
            $this->success('niveaux modifier');
        } else {
            $this->error('Erreur lors de la modification du niveaux');
        }
        return $this->redirect('/admin/level-threshold');

    }


    public function delete()
    {
        $id = $this->request->getvar('id');
        if ($this->levelthresholdModel->delete($id)) {
            $this->success('niveaux supprimer');

        } else {
            $this->error('Erreur lors de la suppression du niveaux');
        }
        return $this->redirect('/admin/level-threshold');
    }


}



