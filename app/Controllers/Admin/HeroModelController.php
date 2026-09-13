<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Entities\HeroModel;
use App\Models\HeroModelModel;
use App\Models\SpecializationLevelModel;
use CodeIgniter\HTTP\ResponseInterface;

class HeroModelController extends BaseController
{
    protected $helpers = ['form', 'url'];
    protected $layout  = 'back';

    private $heroModelModel=null;
    private $specializationModel = null;



    public function __construct()
    {
        $this->heroModelModel      = model('HeroModelModel');
        $this->specializationModel = model( 'SpecializationLevelModel');
    }

    public function index()
    {
        $hero_models = $this->heroModelModel->findAll();
        return $this->render('/admin/hero-model/index', [
            'hero_models' => $hero_models
        ]);
    }

    public function new()
    {
        $specializations = $this->specializationModel->findAll();

        return $this->render('/admin/hero-model/form', [
            'specializations' => $specializations
        ]);
    }

    public function edit($id = null)
    {
        if ($id !== null) {
            $heromodel = $this->heroModelModel->find($id);
            helper('form');
            if ($heromodel) {
                $specializations = $this->specializationModel->findAll();

                return $this->render('/admin/hero-model/form', [
                    'hm'              => $heromodel,
                    'specializations' => $specializations
                ]);
            }
        }

        $this->error('Aucun modèle trouvé');
        return redirect()->to('/admin/hero-model');
    }





    public function createUpdate(){
        $heromodeldata = $this->request->getPost();
        $heromodel = new HeroModel();
        $heromodel->fill($heromodeldata);
        $saveOK = $this->heroModelModel->save($heromodel);
        if ($saveOK) {
            if(isset($heromodeldata['id'])){
                $this->success('le modelé:'.$heromodel->name . '. A bien eté modifié.');
                $id =$heromodeldata['id'];
            }else{
                $this->success('le modéle : ' .$heromodel->name .'.A bien eté crée.');
                $id=$this->heroModelModel->getInsertID();
            }
            return $this->redirect('/admin/hero-model/edit/'.$id);
        }
        $this->error('Une erreur est survenue.');
        return $this->redirect('/admin/hero-model');
    }
    public function delete($id = null)
    {   $id = $this->request->getPost('id');
        if ($id !== null && $this->heroModelModel->delete($id)) {
            $this->success('Modèle supprimé avec succès.');
        } else {
            $this->error('Impossible de supprimer ce modèle.');
        }
        return $this->redirect('/admin/hero-model');
    }
}
