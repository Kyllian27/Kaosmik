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
        //Récupération de la date de création de la cantina en cours
        $created_at = $this->cantinaModel->where('player_id', $id_player)->first()->created_at;
        //Récupération du nombre de secondes restantes
        $remainingSeconds = $cantina->getRemainingSeconds($created_at);
        //Calcul du nombre d'heures et du cout
        $hours = (int) floor($remainingSeconds / 3600);
        $refreshCost = ($hours +1) * 10;
        //Vérification du solde
        if(auth()->user()->getPlayer()->credits < $refreshCost) {
            $this->error('Pas assez de crédits.');
            return $this->redirect('/cantina');
        }
        //Sauvegarder le nouveau solde
        auth()->user()->getPlayer()->credits -= $refreshCost;
        $playerModel = model('PlayerModel');
        $playerModel->save(auth()->user()->getPlayer());

        $cantina->generateOffers(auth()->user()->getPlayer()->id);
        return $this->redirect('/cantina');
    }

    public function recruit($id_cantina_hero = null) {
        $cantina = service('cantina');
        $cantina->recruit($id_cantina_hero);
        return $this->redirect('/cantina');
    }
}
