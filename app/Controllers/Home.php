<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function index(): string
    {
        $heromodel = model('App\Models\HeroModelModel')->getRandom(3);
        return $this->render('home', ['heromodel' => $heromodel]);
    }
}
