<?php 
    namespace App\Model;

    use System\Model;

    class Cargo extends Model 
    {
        public $_table = 'cargos';
        public $_class = 'App\Model\Cargo';

        public function retornaTodos() 
        {
            return $this->query('SELECT * FROM cargos')->getAll();
        }
        
    }
