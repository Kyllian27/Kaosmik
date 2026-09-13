<?php

namespace App\Entities;

use App\Models\SpecializationLevelModel;
use CodeIgniter\Entity\Entity;

class HeroModel extends Entity
{
    protected $datamap = [];
    protected $dates   = ['created_at', 'updated_at', 'deleted_at'];
    protected $casts   = [
        'specialization_id' =>
            'int',
        'name'=> 'string',
        'description'=> 'string',
        'power_min'=>'int',
        'power_max'=>'int',
        'cost_credits_min'=> 'int',
        'cost_credits_max'=> 'int',
        'level_required'=>'int',
    ];
    protected $specialization = null;
    public function getSpecialization(){
        if($this->specialization === null&& ($this->specialization_id)){

        $sm = model(SpecializationLevelModel::class);
        $this->specializations = $sm->where('id',$this->specialization_id)->first();
        }
        return $this->specializations;
    }

}
