<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Entities\HeroModel;
use CodeIgniter\HTTP\ResponseInterface;

class HeroModelController extends BaseController
{
    protected $layout = 'back';
    protected $current_menu = 'hero_model';
    private $heroModel = null;
    private $specializationModel = null;
    public function __construct() {
        $this->heroModel = model('HeroModelModel');
        $this->specializationModel = model('SpecializationModel');
    }
    public function index()
    {
        $heromodels = $this->heroModel->findAll();
        return $this->render('admin/hero_model/index', ['heromodels' => $heromodels]);
    }

    public function new() {
        helper('form');
        $specializations = $this->specializationModel->findAll();
        return $this->render('admin/hero_model/form', ['specializations' => $specializations]);
    }
    public function edit($id = null) {
        if($id != null) {
            $heromodel = $this->heroModel->find($id);
            if($heromodel) {
                helper('form');
                $specializations = $this->specializationModel->findAll();
                return $this->render('admin/hero_model/form', ['hm' => $heromodel, 'specializations' => $specializations]);
            }
        }
        $this->error('Aucun modèle trouvé');
        return $this->redirect('/admin/hero_model');
    }

    public function createUpdate() {
        $heromodeldata = $this->request->getPost();
        $heromodel = new HeroModel();
        $heromodel->fill($heromodeldata);
        $saveOk = $this->heroModel->save($heromodel);
        if($saveOk) {
            if (isset($heromodeldata['id'])) {
                $img = $this->request->getFile('image');
                if ($img->isValid() && !$img->hasMoved()) {
                    helper('media');
                    $result = upload_single_image(
                        $img,
                        'hero_models',
                        $heromodeldata['name'],
                        [
                            'entity_type' => 'hero_models',
                            'entity_id' => $heromodeldata['id']
                        ]
                    );

                }
                $this->success('Le modèle : ' . $heromodel->name . '. A bien été modifié.');
                $id = $heromodeldata['id'];
            } else {
                $this->success('Le modèle : ' . $heromodel->name . '. A bien été créé.');
                $id = $this->heroModel->getInsertID();
            }
            return $this->redirect('admin/hero-model/edit/' . $id);
        }
        $this->error('Une erreur est survenue');
        return $this->redirect('/admin/hero-model');
    }

    public function delete($id = null) {
        if($id != null && $id != 1) {
            $this->heroModel->delete($id);
            $this->success('Le modèle à été supprimé');
        } else {
            $this->error('Une erreur est survenue');
        }
        return $this->redirect('/admin/hero-model');
    }
}