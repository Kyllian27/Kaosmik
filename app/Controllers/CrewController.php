<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class CrewController extends BaseController
{
    protected $current_menu = 'crew';
    protected $heroModel = null;

    public function __construct() {
        $this->heroModel = model('HeroModel');
    }
    public function index()
    {
        helper('form');
        $this->title = "Mon équipage";
        return $this->render('front/crew/index');
    }

    public function sell($id_heroes = null) {
        //Si je n'ai pas d'ID hero
        if($id_heroes != null) {
            //Récupération du héro

            $hero = $this->heroModel->find($id_heroes);
            //Récupération du joueur de l'utilisateur connecté
            $player = auth()->user()->getPlayer();
            //Si l'ID joueur du héro correspond au joueur
            if($hero->player_id == $player->id) {
                //Calcul du montant à récupérer
                $argent = (int) ($hero->cost_credit / 2);
                //On supprime le héro pour éviter une double vente
                if($this->heroModel->delete($id_heroes)) {
                    //On ajoute l'argent au joueur'
                    $player->credits += $argent;
                    //On sauvegarde le joueur
                    if(model('PlayerModel')->save($player)) {
                        $this->success($hero->name . " à été licencié. Vous récuperez <i class='fa-solid fa-cent-sign'></i>" . $argent . ".");
                        return $this->redirect('/equipage');
                    }
                }
            }
        }
        $this->error('Une erreur est survenue. Veuillez contacter un administrateur.');
        return $this->redirect('/crew');
    }

    public function sellBulk()
    {
        $ids = $this->request->getPost('ids');
        if(!empty($ids) && is_array($ids)) {
            $player = auth()->user()->getPlayer();

            $heroes = $this->heroModel->whereIn('id', $ids)->where('player_id', $player->id)->findAll();

            $totalGain = 0;
            $deletedIds = array();
            foreach($heroes as $hero) {
                $totalGain += (int) ($hero->cost_credit / 2);
                $deletedIds[] = $hero->id;
            }
            if(!empty($deletedIds)) {
                $this->heroModel->delete($deletedIds);
                $player->credits += $totalGain;
                model('PlayerModel')->save($player);

                $this->success(count($deletedIds) . " mercenaires ont été licenciés. Vous avez récupéré <i class='fa-solid fa-cent-sign'></i>" . $totalGain );
                return $this->redirect('/equipage');
            }
        }
        $this->error('Une erreur est survenue. Veuillez contacter un administrateur.');
        return $this->redirect('/equipage');
    }
}