<?php 
    namespace App\Model;

    use System\Model;

    class Usuario extends Model 
    {
        public $_table = 'usuarios';
        public $_class = 'App\Model\Usuario';

        public function retornaTodos() 
        {
            return $this->query('SELECT id, nome, login FROM usuarios')->getAll();
        }

        public function retornaUm($id) 
        {
            return $this->query('SELECT id, nome, login FROM usuarios WHERE id = '. $id)->get();
        }

        public function retornaUsuarioESenha($login, $senha)
        {
            return $this->query('SELECT id, nome, login FROM usuarios WHERE login = `'.$login.'` AND senha = `'.$senha.'`')->get();
        }

        public function retornaUsuario($login)
        {
            return $this->query('SELECT id, nome, login FROM usuarios WHERE login = `'.$login.'`')->get();
        }
        
    }
