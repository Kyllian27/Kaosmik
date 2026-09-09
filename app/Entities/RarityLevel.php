<?php

namespace App\Entities;

use CodeIgniter\Entity\Entity;

class RarityLevel extends Entity
{
    protected $dates   = ['created_at', 'updated_at'];
    protected $casts   = [
        'name' => 'string',
        'color' => 'string',
        'power_multiplier' => 'float',
        'cost_multiplier' => 'float',
        'appearance_rate' => 'float'
    ];
}