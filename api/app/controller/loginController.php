<?php

namespace App\Controller;

use System\Controller;

class LoginController extends Controller {

	private $chave = 'fenacon456outro';
    
    public function login() {
    	$login = $this->post('login');
    	$senha = $this->post('senha');

    	
    }

    private function setTokenJWT($usuario) {
    	$header = [
		   'alg' => 'HS256',
		   'typ' => 'JWT'
		];
		$header = json_encode($header);
		$header = base64_encode($header);

		$payload = [
		   'iss' => 'localhost',
		   'sub' => $usuario->id,
		   'exp' => date('Y-m-d'),
		   'iat' => date('Y-m-d'),
		   'name' => $usuario->nome,
		   'email' => $usuario->login
		];
		$payload = json_encode($payload);
		$payload = base64_encode($payload);

		$signature = hash_hmac('sha256',$header.$payload,$this->chave,true);
		$signature = base64_encode($signature);

		return "$header.$payload.$signature";
    }

    private function getTokenJWT($token) {
		$part = explode(".",$token);
		$header = $part[0];
		$payload = $part[1];
		$signature = $part[2];

		$valid = hash_hmac('sha256',$header.$payload,$this->chave,true);
		$valid = base64_encode($valid);

		return ($signature == $valid) ? true : false;
    }

}
