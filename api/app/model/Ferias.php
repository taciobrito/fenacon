<?php 
    namespace App\Model;

    use System\Model;

    class Ferias extends Model 
    {
        public $_table = 'ferias';
        public $_class = 'App\Model\Ferias';

        public function retornaFuncionarios() 
        {
            return $this->query('SELECT f.*, s.descricao AS situacao, c.descricao AS cargo, sup.nome AS supervisor, ADDDATE(f.data_admissao, INTERVAL 365 DAY) as tirar_em, YEAR(ADDDATE(f.data_admissao, INTERVAL 365 DAY)) as periodo
                FROM funcionarios f
                INNER JOIN situacoes s ON f.situacao_id = s.id 
                INNER JOIN cargos c ON f.cargo_id = c.id
                LEFT JOIN funcionarios sup ON f.supervisor_id = sup.id
                WHERE ADDDATE(f.data_admissao, INTERVAL 365 DAY) <= CURDATE()')->getAll();
        }

        public function retornaFeriasTirada($id)
        {
            $sql = 'SELECT fe.*, fu.nome, fu.cpf, fu.endereco, fu.carga_horaria, fu.data_admissao, fu.situacao_id, fu.cargo_id, fu.supervisor_id FROM ferias fe INNER JOIN funcionarios fu ON fe.funcionario_id = fu.id WHERE id = '. $id;
            // if (!empty($funcionario_id)) $sql .= ' WHERE fe.funcionario_id = '. $funcionario_id;
            return $this->query($sql)->get();
        }

        public function retornaFeriasTiradasFuncionario($funcionario_id, $periodo = null)
        {
            $sql = 'SELECT fe.*, fu.nome, fu.cpf, fu.endereco, fu.carga_horaria, fu.data_admissao, fu.situacao_id, fu.cargo_id, fu.supervisor_id FROM ferias fe INNER JOIN funcionarios fu ON fe.funcionario_id = fu.id WHERE fe.funcionario_id = '. $funcionario_id;
            if (!empty($periodo)) {
                $sql .= ' AND fe.periodo = "'. $periodo .'"';
                return $this->query($sql)->get();
            } else {
                return $this->query($sql)->getAll();
            }
        }
        
    }
