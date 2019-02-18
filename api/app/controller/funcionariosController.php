<?php

namespace App\Controller;

use System\Controller;
use App\Model\Funcionario;

class FuncionariosController extends Controller {

	private $funcionario;

    function __construct() {
        parent::__construct();
        $this->funcionario = new Funcionario();
    }

    public function index()
    {
        // Listagem
        if ($this->method() == 'GET') 
        {
            $code = 200;
            $response = array(
                'result' => $this->funcionario->retornaTodos(),
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
            // $this->dd($this->funcionario->retornaFuncionario($id), true);
            if (!empty($funcionario = $this->funcionario->retornaFuncionario($id))) {
                $funcionario->endereco = json_decode($funcionario->endereco);
                $funcionario->data_admissao = substr($funcionario->data_admissao, 8,2) . '/' . substr($funcionario->data_admissao, 5,2) .'/'. substr($funcionario->data_admissao, 0,4);
                $code = 200;
                $response = array(
                    'result' => $funcionario,
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
                    if(!$funcionario = $this->funcionario->create(array(
                        'nome' => $post->nome,
                        'cpf' => $post->cpf,
                        'endereco' => json_encode($post->endereco),
                        'carga_horaria' => $post->carga_horaria,
                        'data_admissao' => substr($post->data_admissao, 6,4) . '-' . substr($post->data_admissao, 3,2) .'-'. substr($post->data_admissao, 0,2),
                        'situacao_id' => $post->situacao_id,
                        'cargo_id' => $post->cargo_id,
                        'supervisor_id' => $post->supervisor_id,
                    ))) {
                        throw new \Exception("Error Processing Request", 1);
                    }

                    $code = 201;
                    $response = array(
                        'result' => $funcionario,
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
                $funcionario = $this->funcionario->update(array(
                    'nome' => $post->nome,
                    'cpf' => $post->cpf,
                    'endereco' => json_encode($post->endereco),
                    'carga_horaria' => $post->carga_horaria,
                    'data_admissao' => substr($post->data_admissao, 6,4) . '-' . substr($post->data_admissao, 3,2) .'-'. substr($post->data_admissao, 0,2),
                    'situacao_id' => $post->situacao_id,
                    'cargo_id' => $post->cargo_id,
                    'supervisor_id' => $post->supervisor_id,
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
                $this->funcionario->delete('id = ' . $id); 

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
        if (empty($post->nome))
            $errors[] = 'O campo nome é obrigatório.';

        if (empty($post->cpf))
            $errors[] = 'O campo cpf é obrigatório.';

        if (empty($post->endereco))
            $errors[] = 'O endereço é obrigatório.';

        if (empty($post->carga_horaria))
            $errors[] = 'O campo carga horária é obrigatório.';

        if (empty($post->data_admissao))
            $errors[] = 'O campo data de admissão é obrigatório.';

        if (empty($post->situacao_id))
            $errors[] = 'O campo situação é obrigatório.';

        if (empty($post->cargo_id))
            $errors[] = 'O campo cargo é obrigatório.';

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
