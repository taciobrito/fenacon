<?php

namespace App\Controller;

use System\Controller;
use App\Model\Situacao;

class SituacoesController extends Controller {

	private $situacao;

    function __construct() {
        parent::__construct();
        $this->situacao = new Situacao();
    }

    public function index()
    {
        // Listagem
        if ($this->method() == 'GET') 
        {
            $code = 200;
            $response = array(
                'result' => $this->situacao->retornaTodos(),
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
