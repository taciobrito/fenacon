<?php

namespace App\Controller;

use System\Controller;
use App\Model\Ferias;

class FeriasController extends Controller {

	private $ferias;

    function __construct() {
        parent::__construct();
        $this->ferias = new Ferias();
    }

    public function index($state, $funcionario_id = '')
    {
        // Listagem
        if ($this->method() == 'GET') 
        {
            if ($state == 'aTirar') {
                $ferias = $this->ferias->retornaFuncionarios();
                foreach ($ferias as $key => $value) {
                    $verifica = $this->ferias->retornaFeriasTiradasFuncionario($value->id, $value->periodo);
                    $ferias[$key]->ferias = $verifica;
                    if (isset($verifica->id)) {
                        unset($ferias[$key]);
                    }
                }
            } else {
                $ferias = $this->ferias->retornaFeriasTiradasFuncionario($funcionario_id);
            }
            $code = 200;
            $response = array(
                'result' => $ferias,
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

    public function show ($id) {
        if ($this->method() == 'GET' && !empty($id))
        {
            // $this->dd($this->ferias->retornaFeriasTirada($id), true);
            if (!empty($ferias = $this->ferias->retornaFeriasTirada($id))) {
                $ferias->dt_inicio = substr($ferias->dt_inicio, 8,2) . '/' . substr($ferias->dt_inicio, 5,2) .'/'. substr($ferias->dt_inicio, 0,4);
                $ferias->dt_fim = substr($ferias->dt_fim, 8,2) . '/' . substr($ferias->dt_fim, 5,2) .'/'. substr($ferias->dt_fim, 0,4);
                $code = 200;
                $response = array(
                    'result' => $ferias,
                    'message' => '',
                );
            } else {
                $code = 400;
                $response = array(
                    'result' => array(),
                    'message' => 'Registro não encontrado!',
                );
            }

        } else {
            $code = 400;
            $response = array(
                'result' => array(),
                'message' => 'Requisição inválida!',
            );
        }

        $this->response_json($response, $code);
    }

    public function store () {
        $request_body = file_get_contents('php://input');
        $post = json_decode($request_body);

        // $this->dd($post, true);

        // if ($this->method() == 'POST') {
            $data = $this->validate($post);
            if ($data['code'] == 200) {
                try {
                    if(!$ferias = $this->ferias->create(array(
                        'dt_inicio' => substr($post->dt_inicio, 6,4) . '-' . substr($post->dt_inicio, 3,2) .'-'. substr($post->dt_inicio, 0,2),
                        'dt_fim' => substr($post->dt_fim, 6,4) . '-' . substr($post->dt_fim, 3,2) .'-'. substr($post->dt_fim, 0,2),
                        'periodo' => $post->periodo,
                        'funcionario_id' => $post->funcionario_id,
                    ))) {
                        throw new \Exception("Error Processing Request", 1);
                    }

                    $code = 201;
                    $response = array(
                        'result' => $ferias,
                        'message' => 'Registro criado com sucesso!',
                    );
                } catch (\Exception $e) {
                    $code = 400;
                    $response = array(
                        'result' => array(),
                        'message' => 'Houve um erro ao criar novo registro! ' . $e->getMessage(),
                    );
                }
            } else {
                $code = $data['code'];
                $response = $data['response'];
            }
        // } else {
        //     $code = 400;
        //     $response = array(
        //         'result' => array(),
        //         'message' => 'Requisição inválida!',
        //     );
        // }

        $this->response_json($response, $code);
    }

    public function update ($id) {
        $request_body = file_get_contents('php://input');
        $post = json_decode($request_body);

        // if ($this->method() == 'POST' && !empty($id)) {
            try {
                $ferias = $this->ferias->update(array(
                    'dt_inicio' => substr($post->dt_inicio, 6,4) . '-' . substr($post->dt_inicio, 3,2) .'-'. substr($post->dt_inicio, 0,2),
                    'dt_fim' => substr($post->dt_fim, 6,4) . '-' . substr($post->dt_fim, 3,2) .'-'. substr($post->dt_fim, 0,2),
                    'periodo' => $post->periodo,
                    'funcionario_id' => $post->funcionario_id,
                ), 'id = '.$id); 

                $code = 200;
                $response = array(
                    'result' => array(),
                    'message' => 'Registro atualizado com sucesso!',
                );
            } catch (\Exception $e) {
                $code = 400;
                $response = array(
                    'result' => array(),
                    'message' => 'Houve um erro ao atualizar registro!',
                );
            }
        // } else {
        //     $code = 400;
        //     $response = array(
        //         'result' => array(),
        //         'message' => 'Requisição inválida!',
        //     );
        // }

        $this->response_json($response, $code);
    }

    public function destroy ($id) {
        // if ($this->method() == 'POST' && !empty($id)) {
            try {
                $this->ferias->delete('id = ' . $id); 

                $code = 200;
                $response = array(
                    'result' => array(),
                    'message' => 'Registro removido com sucesso!',
                );
            } catch (\Exception $e) {
                $code = 400;
                $response = array(
                    'result' => array(),
                    'message' => 'Houve um erro ao remover registro!',
                );
            } 
        // } else {
        //     $code = 400;
        //     $response = array(
        //         'result' => array(),
        //         'message' => 'Requisição inválida!',
        //     );
        // }

        $this->response_json($response, $code);
    }

    private function validate ($post) {
        // $this->dd($post,true);
        $errors = array();
        if (empty($post->dt_inicio))
            $errors[] = 'O campo data de início é obrigatório.';

        if (empty($post->dt_fim))
            $errors[] = 'O campo data de fim é obrigatório.';

        if (empty($post->periodo))
            $errors[] = 'O período aquisitivo é obrigatório.';

        if (empty($post->funcionario_id))
            $errors[] = 'O campo funcionário é obrigatório.';

        if (count($errors) > 0) {
            $code = 422;
            $response = array(
                'errors' => $errors,
                'message' => 'Há campos incorretos no preenchimento do formulário!',
            );
        } else {
            $code = 200;
            $response = array(
                'errors' => array(),
                'message' => 'Formulário válido!',
            );
        }

        return array('code' => $code, 'response' => $response);
    }


}
