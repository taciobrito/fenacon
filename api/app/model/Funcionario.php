<?php 
    namespace App\Model;

    use System\Model;

    class Funcionario extends Model 
    {
        public $_table = 'funcionarios';
        public $_class = 'App\Model\Funcionario';

        public function retornaTodos() 
        {
            return $this->query(
                'SELECT f.*, s.descricao AS situacao, c.descricao AS cargo, sup.nome AS supervisor
                    FROM funcionarios f
                    INNER JOIN situacoes s ON f.situacao_id = s.id
                    INNER JOIN cargos c ON f.cargo_id = c.id
                    LEFT JOIN funcionarios sup ON f.supervisor_id = sup.id')->getAll();
        }

        public function retornaFuncionario($id) 
        {
            return $this->query(
                'SELECT f.*, s.descricao AS situacao, c.descricao AS cargo, sup.nome AS supervisor
                    FROM funcionarios f
                    INNER JOIN situacoes s ON f.situacao_id = s.id
                    INNER JOIN cargos c ON f.cargo_id = c.id
                    LEFT JOIN funcionarios sup ON f.supervisor_id = sup.id
                    WHERE f.id = '. $id)->get();
        }
        
    }
