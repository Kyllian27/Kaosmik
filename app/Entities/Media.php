<?php

namespace App\Entities;

use CodeIgniter\Entity\Entity;

class Media extends Entity
{
    protected $attributes = [
        'id' => null,
        'entity_id' => null,
        'entity_type' => null,
        'name' => null,
        'url' => null,
        'title' => null,
        'alt' => null,
        'type' => null,
    ];
    protected $datamap = [];
    protected $dates   = ['created_at', 'updated_at'];
    protected $casts   = [
        'id' => 'integer',
        'entity_id' => 'integer',
        'entity_type' => 'string',
        'name' => 'string',
        'url' => 'string',
        'title' => 'string',
        'alt' => 'string',
        'type' => 'string',
    ];

    public function getUrl() {
        return base_url($this->attributes['url']);
    }

    public function getAbsolutePath() {
        return FCPATH . $this->attributes['url'];
    }

    public function fileExists() {
        return file_exists($this->getAbsolutePath());
    }
}