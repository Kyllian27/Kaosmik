<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class AdminController extends BaseController
{
    protected $layout= "back";
    public function index()
    {

        return $this->render("admin/dashboard");
    }
}
