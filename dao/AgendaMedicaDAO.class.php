<?php

if(file_exists('dao/GenericDAO.php')){
    require_once 'dao/GenericDAO.php';
}else{
    require_once '../dao/GenericDAO.php';
}

class AgendaMedicaDAO extends GenericDAO{
    
    public function salvar($oAgendaMedica){
        $this->conexao->beginTransaction();
        try{ 
            
            if($oAgendaMedica->getAgenda_id() == null){
                $sql = "INSERT INTO agenda(dia_semana,ativo,local_id) VALUES (:dia_semana,:ativo,:local_id)";
            }else{
                $sql = "UPDATE agenda SET dia_semana=:dia_semana,ativo=:ativo,local_id=:local_id WHERE id=:id";
            }
            //Cadastrar uma nova agenda
            $query = $this->conexao->prepare($sql);
            $query->bindParam(':dia_semana',$oAgendaMedica->getOAgenda()->getDia_semana());
            $query->bindParam(':ativo',$oAgendaMedica->getOAgenda()->getAtivo());
            $query->bindParam(':local_id',$oAgendaMedica->getOAgenda()->getLocal_id());
            
            if($oAgendaMedica->getAgenda_id() != null){
                $query->bindParam(':id',$oAgendaMedica->getAgenda_id());
            }
            
            $query->execute();
            
            if($oAgendaMedica->getAgenda_id() == null){
                $oAgendaMedica->getOAgenda()->setId($this->conexao->lastInsertId());
            }else{
                $oAgendaMedica->getOAgenda()->setId($oAgendaMedica->getAgenda_id());
            }

            //Cadastrando agenda médica
            
            if($oAgendaMedica->getAgenda_id() == null){
                $sql = "INSERT INTO agenda_medica(agenda_id,medico_id) VALUES (:agenda_id,:medico_id)";
            }else{
                $sql = "UPDATE agenda_medica SET agenda_id=:agenda_id,medico_id=:medico_id WHERE agenda_id=:agenda_id";
            }
            
            $query = $this->conexao->prepare($sql);
            $query->bindParam(':agenda_id',$oAgendaMedica->getOAgenda()->getId());
            $query->bindParam(':medico_id',$oAgendaMedica->getMedico_id());
            
            if($oAgendaMedica->getAgenda_id() != null){
                $query->bindParam(':agenda_id',$oAgendaMedica->getAgenda_id());
            }
            
            $query->execute();

            //Cadastrando os horários desta agenda
            
            if($oAgendaMedica->getAgenda_id() != null){
                $query = $this->conexao->prepare("DELETE FROM agenda_horario WHERE agenda_id=:agenda_id");
                $query->bindParam('agenda_id', $oAgendaMedica->getAgenda_id());
                $query->execute();
            }
            
            $arrayHorarios = file('visao/horarios.txt');
            foreach($arrayHorarios as $array){
                $arrayResult = explode(',', $array);
                $query = $this->conexao->prepare('INSERT INTO agenda_horario(horario,agenda_id,ativo) VALUES (:horario,:agenda_id,1)');
                $query->bindParam(':horario', $arrayResult[1]);
                $query->bindParam(':agenda_id',$oAgendaMedica->getOAgenda()->getId());
                $query->execute();

            }
            
            $this->conexao->commit();
            unlink('visao/horarios.txt');


        }catch(Exception $e){
            $this->conexao->rollback();
            echo $e->getMessage();
        }			
        return $oAgendaMedica;
    }

    public function deletar($id){

        $result = 1;
        
        $this->conexao->beginTransaction();
        try{
            $query = $this->conexao->prepare("DELETE FROM agenda_medica WHERE agenda_id=:id");
            $query->bindParam(':id',$id);
            $query->execute();
            
            $query = $this->conexao->prepare("DELETE FROM agenda_horario WHERE agenda_id=:id");
            $query->bindParam(':id',$id);
            $query->execute();
            
            $query = $this->conexao->prepare("DELETE FROM agenda WHERE id=:id");
            $query->bindParam(':id',$id);
            $query->execute();

            $this->conexao->commit();
        }catch(Exception $e){
            $this->conexao->rollback();
            echo $e->getMessage();
            $result = 0;
        }
        return $result;
    }

    public function listar($pagina=null,$limite=null){
        $vOAgendasMedica = Array();
		
		$query = $this->conexao->prepare('SELECT count(*) AS cont FROM agenda_medica');
	    $query->execute();
	    $numero_resultados = $query->fetch(PDO::FETCH_OBJ);
	    $numero_resultados = $numero_resultados->cont;
		
		$sql = "SELECT agenda_id,medico_id FROM agenda_medica";
		if ($limite > 0){
          $sql .= " LIMIT ".($pagina*$limite).",".$limite;
        }
		
        $query = $this->conexao->prepare($sql);
        $query->execute();
        $vOAgendasMedica = $query->fetchAll(PDO::FETCH_CLASS,'AgendaMedica');
		
		if ($limite > 0){
		  
          $numero_paginas = ceil($numero_resultados / $limite);
		  $_SESSION['numero_pag'] = $numero_paginas;
          if ($pagina > 0) {
              $pagina += $limite - 1;
          }
        }
        
        foreach($vOAgendasMedica as $oAgendaMedica){
            
            //obj agenda
            $query = $this->conexao->prepare('SELECT id,dia_semana,ativo,local_id FROM agenda WHERE id=:agenda_id');
            @$query->bindParam(':agenda_id', $oAgendaMedica->getAgenda_id());
            $query->execute();
            $arrayResult = $query->fetchAll(PDO::FETCH_CLASS,'Agenda');
            $oAgendaMedica->setOAgenda($arrayResult[0]);
            
            //obj local
            $query = $this->conexao->prepare('SELECT id, nome from local WHERE id = :id');
            @$query->bindParam(':id',$oAgendaMedica->getOAgenda()->getLocal_id());
            $query->execute();
            $arrayResult = $query->fetchAll(PDO::FETCH_CLASS,'Local');
            $oAgendaMedica->getOAgenda()->setOLocal($arrayResult[0]);
            
            //obj Medico
            $query = $this->conexao->prepare('SELECT pessoa_id,registro,ativo FROM medico WHERE pessoa_id = :pessoa_id');
            @$query->bindParam(':pessoa_id',$oAgendaMedica->getMedico_id());
            $query->execute();
            $arrayResult = $query->fetchAll(PDO::FETCH_CLASS,'Medico');
            $oAgendaMedica->setOMedico($arrayResult[0]);
            
            //obj pessoa
            $query = $this->conexao->prepare('SELECT id,nome,cpf,telefone,email,bloqueado FROM pessoa WHERE id=:pessoa_id');
            @$query->bindParam(':pessoa_id',$oAgendaMedica->getMedico_id());
            $query->execute();
            $arrayResult = $query->fetchAll(PDO::FETCH_CLASS,'Pessoa');
            $oAgendaMedica->getOMedico()->setOPessoa($arrayResult[0]);
            
        }

        return $vOAgendasMedica;
    }

    public function buscar($nome,$pagina,$limite){
        
        
		$nome = "%".$nome."%";
		
		$query = $this->conexao->prepare('SELECT count(*) AS cont FROM agenda_medica');
	    $query->execute();
	    $numero_resultados = $query->fetch(PDO::FETCH_OBJ);
	    $numero_resultados = $numero_resultados->cont;
		
		$sql = "SELECT am.agenda_id,am.medico_id FROM agenda_medica AS am INNER JOIN Pessoa AS p ON p.id=am.medico_id WHERE p.nome LIKE :nome";
		if ($limite > 0){
          $sql .= " LIMIT ".($pagina*$limite).",".$limite;
        }
		
        $vOAgendasMedica = Array();
        $query = $this->conexao->prepare($sql);
        $query->bindParam(":nome",$nome);
        $query->execute();
        $vOAgendasMedica = $query->fetchAll(PDO::FETCH_CLASS,'AgendaMedica');
		
		if ($limite > 0){
		  
          $numero_paginas = ceil($numero_resultados / $limite);
		  $_SESSION['numero_pag'] = $numero_paginas;
          if ($pagina > 0) {
              $pagina += $limite - 1;
          }
        }
        
        foreach($vOAgendasMedica as $oAgendaMedica){
            
            //obj agenda
            $query = $this->conexao->prepare('SELECT id,dia_semana,ativo,local_id FROM agenda WHERE id=:agenda_id');
            @$query->bindParam(':agenda_id', $oAgendaMedica->getAgenda_id());
            $query->execute();
            $arrayResult = $query->fetchAll(PDO::FETCH_CLASS,'Agenda');
            $oAgendaMedica->setOAgenda($arrayResult[0]);
            
            //obj local
            $query = $this->conexao->prepare('SELECT id, nome from local WHERE id = :id');
            @$query->bindParam(':id',$oAgendaMedica->getOAgenda()->getLocal_id());
            $query->execute();
            $arrayResult = $query->fetchAll(PDO::FETCH_CLASS,'Local');
            $oAgendaMedica->getOAgenda()->setOLocal($arrayResult[0]);
            
            //obj Medico
            $query = $this->conexao->prepare('SELECT pessoa_id,registro,ativo FROM medico WHERE pessoa_id = :pessoa_id');
            @$query->bindParam(':pessoa_id',$oAgendaMedica->getMedico_id());
            $query->execute();
            $arrayResult = $query->fetchAll(PDO::FETCH_CLASS,'Medico');
            $oAgendaMedica->setOMedico($arrayResult[0]);
            
            //obj pessoa
            $query = $this->conexao->prepare('SELECT id,nome,cpf,telefone,email,bloqueado FROM pessoa WHERE id=:pessoa_id');
            @$query->bindParam(':pessoa_id',$oAgendaMedica->getMedico_id());
            $query->execute();
            $arrayResult = $query->fetchAll(PDO::FETCH_CLASS,'Pessoa');
            $oAgendaMedica->getOMedico()->setOPessoa($arrayResult[0]);
            
        }

        return $vOAgendasMedica;

    }
    
    
    
     public function exibirAgendaPaciente($idMedico,$idEspecialidade){
        
        $sql = "SELECT am.agenda_id,am.medico_id FROM agenda_medica AS am "
                . "INNER JOIN medico_especialidade AS me "
                . "ON am.medico_id = me.medico_id INNER JOIN "
                . "agenda AS a ON a.id=am.agenda_id "
                . "WHERE am.medico_id=:medico_id "
                . "AND me.especialidade_id=:especialidade_id AND a.ativo = 1";
        
        $vOAgendasMedica = Array();
        $query = $this->conexao->prepare($sql);
        
        $query->bindParam(":especialidade_id",$idEspecialidade);
        $query->bindParam(":medico_id",$idMedico);
        
        
        $query->execute();
        $vOAgendasMedica = $query->fetchAll(PDO::FETCH_CLASS,'AgendaMedica');
        
        foreach($vOAgendasMedica as $oAgendaMedica){
            //obj agenda
            $query = $this->conexao->prepare('SELECT a.dia_semana,a.ativo, '
                    . 'a.local_id, ah.id, ah.horario, ah.agenda_id, ah.ativo '
                    . 'FROM agenda a INNER JOIN agenda_horario ah '
                    . 'ON(a.id=ah.agenda_id) '
                    . 'WHERE a.id=:agenda_id');
            @$query->bindParam(':agenda_id', $oAgendaMedica->getAgenda_id());
            $query->execute();
            $arrayResult = $query->fetchAll(PDO::FETCH_ASSOC);
            
            $oAgendaMedica->setOAgenda($arrayResult[0]);
            
            
            
        }

        return $vOAgendasMedica;

    }

    public function buscarById($id){
        
        $vOAgendasMedica = Array();
        $query = $this->conexao->prepare("SELECT agenda_id,medico_id FROM agenda_medica WHERE agenda_id=:agenda_id");
        $query->bindParam(':agenda_id',$id);
        $query->execute();
        $vOAgendasMedica = $query->fetchAll(PDO::FETCH_CLASS,'AgendaMedica');
        
        foreach($vOAgendasMedica as $oAgendaMedica){
            
            //obj agenda
            $query = $this->conexao->prepare('SELECT id,dia_semana,ativo,local_id FROM agenda WHERE id=:agenda_id');
            @$query->bindParam(':agenda_id', $oAgendaMedica->getAgenda_id());
            $query->execute();
            $arrayResult = $query->fetchAll(PDO::FETCH_CLASS,'Agenda');
            $oAgendaMedica->setOAgenda($arrayResult[0]);
            
            //obj local
            $query = $this->conexao->prepare('SELECT id, nome from local WHERE id = :id');
            @$query->bindParam(':id',$oAgendaMedica->getOAgenda()->getLocal_id());
            $query->execute();
            $arrayResult = $query->fetchAll(PDO::FETCH_CLASS,'Local');
            $oAgendaMedica->getOAgenda()->setOLocal($arrayResult[0]);
            
            //obj Medico
            $query = $this->conexao->prepare('SELECT pessoa_id,registro,ativo FROM medico WHERE pessoa_id = :pessoa_id');
            @$query->bindParam(':pessoa_id',$oAgendaMedica->getMedico_id());
            $query->execute();
            $arrayResult = $query->fetchAll(PDO::FETCH_CLASS,'Medico');
            $oAgendaMedica->setOMedico($arrayResult[0]);
            
            //obj pessoa
            $query = $this->conexao->prepare('SELECT id,nome,cpf,telefone,email,bloqueado FROM pessoa WHERE id=:pessoa_id');
            @$query->bindParam(':pessoa_id',$oAgendaMedica->getMedico_id());
            $query->execute();
            $arrayResult = $query->fetchAll(PDO::FETCH_CLASS,'Pessoa');
            $oAgendaMedica->getOMedico()->setOPessoa($arrayResult[0]);
            
        }
        
        return $vOAgendasMedica[0];

    }
    
    //Locais
    
    public function ListarLocais(){
        
        $query = $this->conexao->prepare("SELECT id,nome,ativo FROM local WHERE ativo = 1");
        $query->execute();
        $vOLocais = $query->fetchALL(PDO::FETCH_CLASS,'Local');
        return $vOLocais;
        
    }
    
    //status
    
    public function mudarStatus($id,$status){
        
        $query = $this->conexao->prepare("UPDATE agenda SET ativo=:ativo WHERE id=:id");
        $query->bindParam(':ativo',$status);
        $query->bindParam(':id',$id);
        $query->execute();
        
    }
    
    public function mudarStatusHorario($id,$status){
        
        $query = $this->conexao->prepare("UPDATE agenda_horario SET ativo=:ativo WHERE id=:id");
        $query->bindParam(':ativo',$status);
        $query->bindParam(':id',$id);
        $query->execute();
        
    }
    
    //horarios
    
    public function listarHorarios($id) {
        
        $query = $this->conexao->prepare("SELECT id,horario,agenda_id,ativo FROM agenda_horario WHERE agenda_id=:id ORDER BY horario ASC");
        $query->bindParam(':id',$id);
        $query->execute();
        $vOHorarios = $query->fetchAll(PDO::FETCH_CLASS,'AgendaHorario');
        
        return $vOHorarios;
        
    }
    public function buscarHorarioPaciente($explodeMesAgenda){
        $arrayResult = explode(",",$explodeMesAgenda);
        $query = $this->conexao->prepare("SELECT id,horario,agenda_id,ativo FROM agenda_horario WHERE agenda_id=:agenda_id AND ativo=1");
        
        $query->bindParam(":agenda_id",$arrayResult[1]);
        $query->execute();
        
        $vOAgendaHorario = $query->fetchAll(PDO::FETCH_CLASS,'AgendaHorario');
        
        return $vOAgendaHorario;
        
    }
    
}

