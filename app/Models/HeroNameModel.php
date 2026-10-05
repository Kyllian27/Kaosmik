<?php

namespace App\Models;

use CodeIgniter\Model;

class HeroNameModel extends Model
{
    protected $table            = 'hero_names';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $allowedFields    = ['name'];

    public function getRandom() {
        return $this->orderBy('RAND()')->first()['name'];
    }
}
