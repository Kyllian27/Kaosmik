<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class CrewController extends BaseController
{
    protected $current_menu = 'crew';

    public function index()
    {
        $this->title = "Mon équipage";
        return $this->render('front/crew/index');
    }

    public function sell($id_heroes = null){
        if ($id_heroes != null) {
            $heroModel = model('HeroModel');
            $hero = $heroModel->find($id_heroes);
            //Récupération du joueur de l'utilisateur connecté
            $player = auth()->user()->getPlayer();

            //Si l'ID joueur du héro correspond au joueur
            if($hero && $hero->player_id == $player->id){
                //Calcul du montant a récuperer
                $argent = (int)($hero->cost_credit / 2);

                //on supprime le hero pour eviter une double vente
                if($heroModel->delete($id_heroes)){
                    // on ajoute l'argent au joueur
                    $player->credits += $argent;

                    //on sauvegarde le joueur
                    if(model('PlayerModel')->save($player)){
                        $this->success($hero->name . " a été licencié. Vous récupérez <i class='fa-solid fa-cent-sign'></i> " . $argent . ".");
                        return redirect()->to('/equipage');
                    }
                }
            }
        }

        $this->error('Une erreur est survenue, veuillez contacter un administrateur.');
        return redirect()->to('/equipage');
    }
}