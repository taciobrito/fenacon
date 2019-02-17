<?php 
    namespace App\Model;

    use System\Model;

    class Funcionario extends Model 
    {
        public $_table = 'funcionarios';
        public $_class = 'App\Model\Funcionario';

        public function retornaTodos() 
        {
            return $this->query('SELECT id, nome, login FROM funcionarios')->getAll();
        }

        public function retornaUm($id) 
        {
            return $this->query('SELECT id, nome, login FROM funcionarios WHERE id = '. $id)->get();
        }
        
    }
