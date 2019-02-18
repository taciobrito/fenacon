<?php

namespace App\Controller;

use System\Controller;
use App\Model\Cargo;

class CargosController extends Controller {

	private $cargo;

    function __construct() {
        parent::__construct();
        $this->cargo = new Cargo();
    }

    public function index()
    {
        // Listagem
        if ($this->method() == 'GET') 
        {
            $code = 200;
            $response = array(
                'result' => $this->cargo->retornaTodos(),
                'message' => '',
            );
        } 
        else 
        {
            $code = 400;
            $response = array(
                'result' => array(),
                'message' => 'Requisição inválida!',
            );
        }
        // $this->dd($response, true);

        $this->response_json($response, $code);
    }

}
