<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\CantinaModel;
use CodeIgniter\HTTP\ResponseInterface;

class CantinaController extends BaseController
{
    // Charge automatiquement le helper 'form' pour toutes les méthodes de ce contrôleur
    protected $helpers = ['form'];

    protected $cantinaModel;

    public function __construct()
    {
        $this->cantinaModel = new CantinaModel();
    }

    public function index()
    {
        $cantina = service('cantina');

        $cantinaHeroes = $cantina->getOnGeneratedOffers(auth()->user()->getPlayer()->id);

        return $this->render('front/cantina/index', ['cantinaHeroes' => $cantinaHeroes]);
    }

    public function refresh()
    {
        $cantina = service('cantina');
        $cantinaHeroes = $cantina->getOnGeneratedOffers(auth()->user()->getPlayer()->id);

        return redirect()->to('/cantina');
    }
}