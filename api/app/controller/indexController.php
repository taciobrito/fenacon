<?php

namespace App\Controller;

use System\Controller;

class IndexController extends Controller {

    public function index()
    {
        $this->view('index');
    }
}
