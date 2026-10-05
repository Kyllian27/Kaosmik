<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Entities\Mission;
use App\Models\MissionModel;
use App\Models\MissionSpecializationModel;
use App\Models\SpecializationModel;
use CodeIgniter\HTTP\RedirectResponse;

/**
 * Administration des missions (CRUD).
 *
 * Une mission peut être associée à plusieurs spécialisations
 * via la table de liaison `mission_specializations`.
 */
class MissionController extends BaseController
{
    /** Layout utilisé pour le rendu des vues (back-office) */
    protected $layout = 'back';

    /** Clé de l'entrée à mettre en surbrillance dans le menu (cf. menu-back.json) */
    protected $current_menu = 'mission';

    /** @var MissionModel */
    private $missionModel = null;

    /** @var SpecializationModel */
    private $specializationModel = null;

    /** @var MissionSpecializationModel */
    private $missionSpecializationModel = null;

    public function __construct() {
        $this->missionModel = model('MissionModel');
        $this->specializationModel = model('SpecializationModel');
        $this->missionSpecializationModel = model('MissionSpecializationModel');
    }

    /**
     * Affiche la liste des missions.
     *
     * @return string
     */
    public function index()
    {
        $missions = $this->missionModel->findAll();
        return $this->render('admin/mission/index', ['missions' => $missions]);
    }

    /**
     * Affiche le formulaire de création d'une mission.
     *
     * @return string
     */
    public function new() {
        helper('form');
        $specializations = $this->specializationModel->findAll();
        return $this->render('admin/mission/form', [
            'specializations' => $specializations,
            'selectedSpecializations' => [],
        ]);
    }

    /**
     * Affiche le formulaire de modification d'une mission.
     * Redirige vers la liste si la mission n'existe pas.
     *
     * @param int|string|null $id Identifiant de la mission
     * @return string|RedirectResponse
     */
    public function edit($id = null) {
        if($id != null) {
            $mission = $this->missionModel->find($id);
            if($mission) {
                helper('form');
                $specializations = $this->specializationModel->findAll();
                // Identifiants des spécialisations déjà liées, pour pré-sélectionner le champ multiple
                $selectedSpecializations = array_column(
                    $this->missionSpecializationModel->where('mission_id', $id)->findAll(),
                    'specialization_id'
                );
                return $this->render('admin/mission/form', [
                    'mission' => $mission,
                    'specializations' => $specializations,
                    'selectedSpecializations' => $selectedSpecializations,
                ]);
            }
        }
        $this->error('Aucune mission trouvée');
        return $this->redirect('/admin/mission');
    }

    /**
     * Crée ou met à jour une mission à partir du formulaire.
     *
     * La présence du champ `id` dans le POST détermine s'il s'agit d'une
     * modification (id présent) ou d'une création (id absent).
     * Les spécialisations liées sont ensuite synchronisées.
     *
     * @return RedirectResponse
     */
    public function createUpdate() {
        $missiondata = $this->request->getPost();

        // Les spécialisations ne sont pas des champs de la table missions : on les extrait avant le fill()
        $specializationIds = $missiondata['specialization_ids'] ?? [];
        unset($missiondata['specialization_ids']);

        $mission = new Mission();
        $mission->fill($missiondata);
        $saveOk = $this->missionModel->save($mission);
        if($saveOk) {
            if (isset($missiondata['id'])) {
                $this->success('La mission : ' . $mission->title . '. A bien été modifiée.');
                $id = $missiondata['id'];
            } else {
                $this->success('La mission : ' . $mission->title . '. A bien été créée.');
                // Après un insert, l'id est celui généré par la base
                $id = $this->missionModel->getInsertID();
            }
            $this->syncSpecializations($id, $specializationIds);
            return $this->redirect('admin/mission/edit/' . $id);
        }
        $this->error('Une erreur est survenue');
        return $this->redirect('/admin/mission');
    }

    /**
     * Supprime une mission (soft delete, cf. MissionModel::$useSoftDeletes).
     *
     * @param int|string|null $id Identifiant de la mission
     * @return RedirectResponse
     */
    public function delete($id = null) {
        if($id != null) {
            $this->missionModel->delete($id);
            $this->success('La mission à été supprimée');
        } else {
            $this->error('Une erreur est survenue');
        }
        return $this->redirect('/admin/mission');
    }

    /**
     * Remplace les spécialisations liées à une mission par celles fournies.
     *
     * Les liaisons existantes sont supprimées puis recréées (les doublons sont ignorés).
     *
     * @param int|string $missionId Identifiant de la mission
     * @param array $specializationIds Identifiants des spécialisations à lier
     * @return void
     */
    private function syncSpecializations($missionId, array $specializationIds): void
    {
        $this->missionSpecializationModel->where('mission_id', $missionId)->delete();
        foreach (array_unique($specializationIds) as $specializationId) {
            $this->missionSpecializationModel->insert([
                'mission_id' => $missionId,
                'specialization_id' => $specializationId,
            ]);
        }
    }
}
