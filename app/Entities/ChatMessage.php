<?php

namespace App\Entities;

use CodeIgniter\Entity\Entity;

class ChatMessage extends Entity
{
    protected $attributes = [
        'id'=>null,
        'id_sender' => null,
        'id_receiver' => null,
        'message' => null,
    ];

    protected $dates   = ['created_at', 'updated_at', 'deleted_at'];

}
