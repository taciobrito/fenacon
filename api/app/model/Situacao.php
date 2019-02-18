<?php 
    namespace App\Model;

    use System\Model;

    class Situacao extends Model 
    {
        public $_table = 'situacoes';
        public $_class = 'App\Model\Situacao';

        public function retornaTodos() 
        {
            return $this->query('SELECT * FROM situacoes')->getAll();
        }
        
    }
