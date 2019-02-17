<?php

namespace App\Controller;

use System\Controller;
use App\Model\Usuario;

class UsuariosController extends Controller {

	private $usuario;

    function __construct() {
        parent::__construct();
        $this->usuario = new Usuario();
	}

    public function index()
    {
        // Listagem
        if ($this->method() == 'GET') 
        {
            $code = 200;
            $response = array(
                'result' => $this->usuario->retornaTodos(),
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
            if (!empty($usuario = $this->usuario->retornaUm($id))) {
                $code = 200;
                $response = array(
                    'result' => $usuario,
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
        if ($this->method() == 'POST') {
            $data = $this->validate($this->post());
            if ($data['code'] == 200) {
                try {
                    if (count($this->usuario->retornaUsuario($this->post('login'))) > 0) {
                        throw new \Exception('O login informado já existe', 1);
                    }

                    if(!$usuario = $this->usuario->create(array(
                        'nome' => $this->post('nome'),
                        'login' => $this->post('login'), 
                        'senha' => password_hash($this->post('senha'), PASSWORD_DEFAULT), 
                    ))) {
                        throw new \Exception("Error Processing Request", 1);
                    }

                    $code = 201;
                    $response = array(
                        'result' => $usuario,
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
            try {
                $usuario = $this->usuario->update(array(
                    'nome' => $this->post('nome'),
                    'login' => $this->post('login')
                ), 'id = '.$id); 

                $code = 200;
                $response = array(
                    'result' => $usuario,
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
                $this->usuario->delete('id = ' . $id); 

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

        if (empty($post['login']))
            $errors[] = 'O campo login é obrigatório.';

        if (empty($post['senha']))
            $errors[] = 'O campo senha é obrigatório.';

        if (empty($post['confirmar_senha']))
            $errors[] = 'O campo confirmar senha é obrigatório.';

        if (!empty($post['senha']) && !empty($post['confirmar_senha']))
            if ($post['confirmar_senha'] != $post['senha'])
                $errors[] = 'O campo confirmar senha deve ser igual a senha.';

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

    public function response_json($response, $code = 200)
    {    
        http_response_code($code);
        echo json_encode($response);
    }

}
