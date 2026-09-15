<?php

namespace App\Entities;

use CodeIgniter\Entity\Entity;
use App\Models\SpecializationLevelModel;
use App\Models\MediaModel;

class HeroModel extends Entity
{
    protected $dates   = ['created_at', 'updated_at', 'deleted_at'];
    protected $casts   = [
        'specialization_id' => 'int',
        'name'             => 'string',
        'description'      => 'string',
        'power_min'        => 'int',
        'power_max'        => 'int',
        'cost_credits_min' => 'int',
        'cost_credits_max' => 'int',
        'level_required'   => 'int'
    ];

    protected $specialization = null;

    public function getSpecialization()
    {
        if ($this->specialization === null && !empty($this->specialization_id)) {
            $sm = new SpecializationLevelModel();
            $this->specialization = $sm->find($this->specialization_id);
        }

        return $this->specialization;
    }

    public function getImage()
    {
        $mediaModel = new MediaModel();
        return $mediaModel->getOneMedia('hero_models', $this->id);
    }
}