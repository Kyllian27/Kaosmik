<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\CantinaModel;
use CodeIgniter\HTTP\ResponseInterface;

class CantinaController extends BaseController
{
    protected $cantinaModel;

    public function __construct()
    {
        $this->cantinaModel = model(CantinaModel::class);
    }

    public function index()
    {
        $cantina = service('cantina');


        $cantinaHeroes = $cantina->generateOffers(auth()->user()->getPlayer()->id);

        return $this->render('front/cantina/index', ['cantinaHeroes' => $cantinaHeroes]);
    }
}