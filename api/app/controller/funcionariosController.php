<?php

namespace App\Controller;

use System\Controller;
use App\Model\Funcionario;

class FuncionariosController extends Controller {

	private $funcionario;

    function __construct() {
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

        $this->response_json($response, $code);
    }

    public function show ($id) {
        if ($this->method() == 'GET' && !empty($id))
        {
            if (!empty($funcionario = $this->funcionario->retornaUm($id))) {
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
        if ($this->method() == 'POST' && empty($id)) {
            $data = $this->validate($this->post());
            if ($data['code'] == 200) {
                try {
                    $dados = array(
                        'nome' => $this->post('nome'),
                        'cpf' => $this->post('cpf'),
                        'endereco' => json_encode($this->post('endereco')),
                        'carga_horaria' => $this->post('carga_horaria'),
                        'data_admissao' => $this->post('data_admissao'),
                        'situacao_id' => $this->post('situacao_id'),
                        'cargo_id' => $this->post('cargo_id'),
                    );
                    if ($this->has_post('supervisor_id')) $dados['supervisor_id'] = $this->post('supervisor_id');

                    if(!$funcionario = $this->funcionario->create($dados)) {
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
                        'message' => 'Houve um erro ao criar novo registro!',
                    );
                }
            } else {
                $code = $data['code'];
                $response = $data['response'];
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

    public function update ($id) {
        if ($this->method() == 'POST' && !empty($id)) {            
            $data = $this->validate($this->post());
            if ($data['code'] == 200) {
                try {
                    $dados = array(
                        'nome' => $this->post('nome'),
                        'cpf' => $this->post('cpf'),
                        'endereco' => json_encode($this->post('endereco')),
                        'carga_horaria' => $this->post('carga_horaria'),
                        'data_admissao' => $this->post('data_admissao'),
                        'situacao_id' => $this->post('situacao_id'),
                        'cargo_id' => $this->post('cargo_id'),
                    );
                    if ($this->has_post('supervisor_id')) $dados['supervisor_id'] = $this->post('supervisor_id');

                    $funcionario = $this->funcionario->update($dados, 'id = '.$id); 

                    $code = 200;
                    $response = array(
                        'result' => $funcionario,
                        'message' => 'Registro atualizado com sucesso!',
                    );
                } catch (\Exception $e) {
                    $code = 400;
                    $response = array(
                        'result' => array(),
                        'message' => 'Houve um erro ao atualizar registro!',
                    );
                }
            } else {
                $code = $data['code'];
                $response = $data['response'];
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

    public function destroy ($id) {
        if ($this->method() == 'POST' && !empty($id)) {
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
        } else {
            $code = 400;
            $response = array(
                'result' => array(),
                'message' => 'Requisição inválida!',
            );
        }

        $this->response_json($response, $code);
    }

    private function validate ($post) {
        $errors = array();
        if (empty($post['nome']))
            $errors[] = 'O campo nome é obrigatório.';

        if (empty($post['cpf']))
            $errors[] = 'O campo cpf é obrigatório.';

        if (empty($post['endereco']))
            $errors[] = 'O campo endereço é obrigatório.';

        if (empty($post['carga_horaria']))
            $errors[] = 'O campo carga horária é obrigatório.';

        if (empty($post['data_admissao']))
            $errors[] = 'O campo data de admissão é obrigatório.';

        if (empty($post['situacao_id']))
            $errors[] = 'O campo situação é obrigatório.';

        if (empty($post['cargo_id']))
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
