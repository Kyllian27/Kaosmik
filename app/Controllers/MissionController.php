<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class MissionController extends BaseController
{
    protected $current_menu = 'mission';
    protected $title = 'Mission';
    protected $missionModel;

    public function __construct() {
        $this->missionModel = model('MissionModel');
    }
    public function index()
    {
        $this->title = "Choix de la mission";
        helper('form');
        $player = auth()->user()->getPlayer();

        foreach(service('mission')->resolveFinishedMission($player) as $r) {
            $this->success(sprintf('Mission "%s" terminée : +%d crédits, +%d énergie, +%d XP.',$r['mission']->title, $r['credits'], $r['energy'], $r['xp']
            ));
        }

        $missions = $this->missionModel->findAll();
        $inProgress = model('MissionResolutionModel')->getMissionInProgress($player->id);
        return $this->render('front/mission/index', ['missions' => $missions, 'inProgress' => $inProgress]);
    }

    public function details($id = null) {
        if($id == null) return $this->response->setStatusCode(400)->setBody('ID manquant');

        return view_cell('MissionCell', ['mission' => $this->missionModel->find($id)]);
    }

    public function sendCrew() {
        helper('form');
        $player = auth()->user()->getPlayer();
        $id = $this->request->getVar('mission_id');
        $mission = $this->missionModel->find($id);
        return $this->render('front/mission/send-crew', [
            'mission' => $mission,
            'busyHeroIds' => model('MissionHeroModel')->getBusyHeroIds($player->id),
        ]);
    }

    public function validateMission() {
        $data = $this->request->getPost();
        $player = auth()->user()->getPlayer();
        $heroes = $data['heroes_ids'];
        $missionId = (int) $data['mission_id'];
        try{
            $missionService = service('mission');
            $missionService->startMission($player, $missionId, $heroes);
        } catch (\Exception $e) {
            $this->error($e->getMessage());
            return $this->redirect('mission');
        }

        $mission = $this->missionModel->find($missionId);
        $this->success("Escouade envoyée ! Retour dans " . $mission->getDurationLabel() .".");
        return $this->redirect('mission');
    }

    public function results() {
        return $this->render('front/mission/results');
    }
}