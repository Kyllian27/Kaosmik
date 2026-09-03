<?php

namespace App\Entities;

use CodeIgniter\Entity\Entity;

class RarityLevel extends Entity
{
    protected $datamap = [];
    protected $dates   = ['created_at', 'updated_at', 'deleted_at'];
    protected $casts   = [
        'id'    => 'integer',
        'name'  => 'string',
        'color' => 'string',
    ];
}