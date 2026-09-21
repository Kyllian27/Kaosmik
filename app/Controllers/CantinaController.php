<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\CantinaModel;
use CodeIgniter\HTTP\ResponseInterface;

class CantinaController extends BaseController
{
    protected $cantinaModel;
    protected $current_menu = 'cantina';
    public function __construct() {
        $this->cantinaModel = model('cantinaModel');
    }
    public function index()
    {
        $this->title = "La Cantina";
        helper('form');
        $cantina = service('cantina');
        $data = $cantina->getOrGenerateOffers(auth()->user()->getPlayer()->id);
        return $this->render('front/cantina/index', $data);
    }

    public function refresh() {
        $cantina = service('cantina');
        $id_player = auth()->user()->getPlayer()->id;
        //recuperation de la date de creation de la cantina en cours
        $created_at = $this->cantinaModel->where('id_player', $id_player)->first()->created_at;
        //calcul du nombre d'heur et du cout
        $remainingSeconds = $cantina->getRemainingSeconds($created_at);
        $hours = (int) floor($remainingSeconds / 3600);
        $refreshcost = ($hours + 1) * 10;
        //verification du sold
        if(auth()->getplayer()->credit<$refreshcost) {
            $this->error('pas de assez de flouse.');
            return $this->redirect('/cantina');
        }
        //sauvegarder le nouveaux solde
        auth()->user()->getPlayer()->credit = $refreshcost;
        $PlayerModel = model('PlayerModel');
        $PlayerModel->save(auth()->user()->getPlayer());

        $cantina->generateOffers(auth()->user()->getPlayer()->id);
        return $this->redirect('/cantina');
    }

    public function recruit($id_cantina_hero = null) {
        $cantina = service('cantina');
        $cantina->recruit($id_cantina_hero);
        return $this->redirect('/cantina');
    }
}