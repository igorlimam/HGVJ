<?php

if(file_exists('dao/GenericDAO.php')){
    require_once 'dao/GenericDAO.php';
}else{
    require_once '../dao/GenericDAO.php';
}

class AgendaExameDAO extends GenericDAO{
    
    public function salvar($oAgendaExame){
        $this->conexao->beginTransaction();
        try{ 
            
            if($oAgendaExame->getAgenda_id() == null){
                $sql = "INSERT INTO agenda(dia_semana,ativo,local_id) VALUES (:dia_semana,:ativo,:local_id)";
            }else{
                $sql = "UPDATE agenda SET dia_semana=:dia_semana,ativo=:ativo,local_id=:local_id WHERE id=:id";
            }
            //Cadastrar uma nova agenda
            $query = $this->conexao->prepare($sql);
            $query->bindParam(':dia_semana',$oAgendaExame->getOAgenda()->getDia_semana());
            $query->bindParam(':ativo',$oAgendaExame->getOAgenda()->getAtivo());
            $query->bindParam(':local_id',$oAgendaExame->getOAgenda()->getLocal_id());
            
            if($oAgendaExame->getAgenda_id() != null){
                $query->bindParam(':id',$oAgendaExame->getAgenda_id());
            }
            
            $query->execute();
            
            if($oAgendaExame->getAgenda_id() == null){
                $oAgendaExame->getOAgenda()->setId($this->conexao->lastInsertId());
            }else{
                $oAgendaExame->getOAgenda()->setId($oAgendaExame->getAgenda_id());
            }

            //Cadastrando agenda médica
            
            if($oAgendaExame->getAgenda_id() == null){
                $sql = "INSERT INTO agenda_exame(agenda_id,exame_id) VALUES (:agenda_id,:exame_id)";
            }else{
                $sql = "UPDATE agenda_exame SET agenda_id=:agenda_id,exame_id=:exame_id WHERE agenda_id=:agenda_id";
            }
            
            $query = $this->conexao->prepare($sql);
            $query->bindParam(':agenda_id',$oAgendaExame->getOAgenda()->getId());
            $query->bindParam(':exame_id',$oAgendaExame->getExame_id());
            
            if($oAgendaExame->getAgenda_id() != null){
                $query->bindParam(':agenda_id',$oAgendaExame->getAgenda_id());
            }
            
            $query->execute();

            //Cadastrando os horários desta agenda
            
            if($oAgendaExame->getAgenda_id() != null){
                $query = $this->conexao->prepare("DELETE FROM agenda_horario WHERE agenda_id=:agenda_id");
                $query->bindParam('agenda_id', $oAgendaExame->getAgenda_id());
                $query->execute();
            }
            
            $arrayHorarios = file('visao/horariosE.txt');
            foreach($arrayHorarios as $array){
                $arrayResult = explode(',', $array);
                $query = $this->conexao->prepare('INSERT INTO agenda_horario(horario,agenda_id,ativo) VALUES (:horario,:agenda_id,1)');
                $query->bindParam(':horario', $arrayResult[1]);
                $query->bindParam(':agenda_id',$oAgendaExame->getOAgenda()->getId());
                $query->execute();

            }
            
            $this->conexao->commit();
            unlink('visao/horariosE.txt');


        }catch(Exception $e){
            $this->conexao->rollback();
            echo $e->getMessage();
        }			
        return $oAgendaExame;
    }

    public function deletar($id){

        $result = 1;
        
        $this->conexao->beginTransaction();
        try{
            $query = $this->conexao->prepare("DELETE FROM agenda_exame WHERE agenda_id=:id");
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
        $vOAgendasEmaxe = Array();
		
		$query = $this->conexao->prepare('SELECT count(*) AS cont FROM agenda_exame');
	    $query->execute();
	    $numero_resultados = $query->fetch(PDO::FETCH_OBJ);
	    $numero_resultados = $numero_resultados->cont;
		
		$sql = "SELECT agenda_id,exame_id FROM agenda_exame";
		if ($limite > 0){
          $sql .= " LIMIT ".($pagina*$limite).",".$limite;
        }
		
        $query = $this->conexao->prepare($sql);
        $query->execute();
        $vOAgendasExame = $query->fetchAll(PDO::FETCH_CLASS,'AgendaExame');
        
		if ($limite > 0){
		  
          $numero_paginas = ceil($numero_resultados / $limite);
		  $_SESSION['numero_pag'] = $numero_paginas;
          if ($pagina > 0) {
              $pagina += $limite - 1;
          }
        }
		
        foreach($vOAgendasExame as $oAgendaExame){
            
            //obj agenda
            $query = $this->conexao->prepare('SELECT id,dia_semana,ativo,local_id FROM agenda WHERE id=:agenda_id');
            @$query->bindParam(':agenda_id', $oAgendaExame->getAgenda_id());
            $query->execute();
            $arrayResult = $query->fetchAll(PDO::FETCH_CLASS,'Agenda');
            $oAgendaExame->setOAgenda($arrayResult[0]);
            
            //obj local
            $query = $this->conexao->prepare('SELECT id, nome from local WHERE id = :id');
            @$query->bindParam(':id',$oAgendaExame->getOAgenda()->getLocal_id());
            $query->execute();
            $arrayResult = $query->fetchAll(PDO::FETCH_CLASS,'Local');
            $oAgendaExame->getOAgenda()->setOLocal($arrayResult[0]);
            
            //obj Exame
            $query = $this->conexao->prepare('SELECT id,nome,ativo,exame_categoria_id FROM exame WHERE id = :id');
            @$query->bindParam(':id',$oAgendaExame->getExame_id());
            $query->execute();
            $arrayResult = $query->fetchAll(PDO::FETCH_CLASS,'Exame');
            $oAgendaExame->setOExame($arrayResult[0]);
            
            //obj categoria
            $query = $this->conexao->prepare('SELECT id,nome FROM exame_categoria WHERE id=:exame_categoria_id');
            @$query->bindParam(':exame_categoria_id',$oAgendaExame->getOExame()->getExame_categoria_id());
            $query->execute();
            $arrayResult = $query->fetchAll(PDO::FETCH_CLASS,'ExameCategoria');
            $oAgendaExame->getOExame()->setOExame_categoria($arrayResult[0]);
            
        }

        return $vOAgendasExame;
    }

    public function buscar($nome,$pagina,$limite){
        
        $nome = "%".$nome."%";
		
		$query = $this->conexao->prepare('SELECT count(*) AS cont FROM agenda_exame');
	    $query->execute();
	    $numero_resultados = $query->fetch(PDO::FETCH_OBJ);
	    $numero_resultados = $numero_resultados->cont;

        $vOAgendasExame = Array();
		
		$sql = "SELECT ae.agenda_id,ae.exame_id FROM agenda_exame AS ae INNER JOIN exame AS e ON e.id=ae.exame_id WHERE e.nome LIKE :nome";
		if ($limite > 0){
          $sql .= " LIMIT ".($pagina*$limite).",".$limite;
        }
		
        $query = $this->conexao->prepare($sql);
        $query->bindParam(":nome",$nome);
        $query->execute();
        $vOAgendasExame = $query->fetchAll(PDO::FETCH_CLASS,'AgendaExame');
		
		if ($limite > 0){
          $numero_paginas = ceil($numero_resultados / $limite);
		  $_SESSION['numero_pag'] = $numero_paginas;
          if ($pagina > 0) {
              $pagina += $limite - 1;
          }
        }
        
        foreach($vOAgendasExame as $oAgendaExame){
            
            //obj agenda
            $query = $this->conexao->prepare('SELECT id,dia_semana,ativo,local_id FROM agenda WHERE id=:agenda_id');
            @$query->bindParam(':agenda_id', $oAgendaExame->getAgenda_id());
            $query->execute();
            $arrayResult = $query->fetchAll(PDO::FETCH_CLASS,'Agenda');
            $oAgendaExame->setOAgenda($arrayResult[0]);
            
            //obj local
            $query = $this->conexao->prepare('SELECT id, nome from local WHERE id = :id');
            @$query->bindParam(':id',$oAgendaExame->getOAgenda()->getLocal_id());
            $query->execute();
            $arrayResult = $query->fetchAll(PDO::FETCH_CLASS,'Local');
            $oAgendaExame->getOAgenda()->setOLocal($arrayResult[0]);
            
            //obj exame
            $query = $this->conexao->prepare('SELECT id,nome,ativo,exame_categoria_id FROM exame WHERE id = :id');
            @$query->bindParam(':id',$oAgendaExame->getExame_id());
            $query->execute();
            $arrayResult = $query->fetchAll(PDO::FETCH_CLASS,'Exame');
            $oAgendaExame->setOExame($arrayResult[0]);
            
            //obj exame categoria
            $query = $this->conexao->prepare('SELECT id,nome FROM exame_categoria WHERE id=:exame_categoria_id');
            @$query->bindParam(':exame_categoria_id',$oAgendaExame->getOExame()->getExame_categoria_id());
            $query->execute();
            $arrayResult = $query->fetchAll(PDO::FETCH_CLASS,'ExameCategoria');
            $oAgendaExame->getOExame()->setOExame_categoria($arrayResult[0]);
            
        }

        return $vOAgendasExame;

    }

    public function buscarById($id){
        
        $vOAgendasExame = Array();
        $query = $this->conexao->prepare("SELECT agenda_id,exame_id FROM agenda_exame WHERE agenda_id=:agenda_id");
        $query->bindParam(':agenda_id',$id);
        $query->execute();
        $vOAgendasExame = $query->fetchAll(PDO::FETCH_CLASS,'AgendaExame');
        
        foreach($vOAgendasExame as $oAgendaExame){
            
            //obj agenda
            $query = $this->conexao->prepare('SELECT id,dia_semana,ativo,local_id FROM agenda WHERE id=:agenda_id');
            @$query->bindParam(':agenda_id', $oAgendaExame->getAgenda_id());
            $query->execute();
            $arrayResult = $query->fetchAll(PDO::FETCH_CLASS,'Agenda');
            $oAgendaExame->setOAgenda($arrayResult[0]);
            
            //obj local
            $query = $this->conexao->prepare('SELECT id, nome FROM local WHERE id = :id');
            @$query->bindParam(':id',$oAgendaExame->getOAgenda()->getLocal_id());
            $query->execute();
            $arrayResult = $query->fetchAll(PDO::FETCH_CLASS,'Local');
            $oAgendaExame->getOAgenda()->setOLocal($arrayResult[0]);
            
            //obj Exame
            $query = $this->conexao->prepare('SELECT id,nome,ativo,exame_categoria_id FROM exame WHERE id = :id');
            @$query->bindParam(':id',$oAgendaExame->getExame_id());
            $query->execute();
            $arrayResult = $query->fetchAll(PDO::FETCH_CLASS,'Exame');
            $oAgendaExame->setOExame($arrayResult[0]);
            
            //obj exame categoria
            $query = $this->conexao->prepare('SELECT id,nome FROM exame_categoria WHERE id=:exame_categoria_id');
            @$query->bindParam(':exame_categoria_id',$oAgendaExame->getOExame()->getExame_categoria_id());
            $query->execute();
            $arrayResult = $query->fetchAll(PDO::FETCH_CLASS,'ExameCategoria');
            $oAgendaExame->getOExame()->setOExame_categoria($arrayResult[0]);
            
        }
        
        return $vOAgendasExame[0];

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
        
        $query = $this->conexao->prepare("SELECT id,horario,agenda_id,ativo FROM agenda_horario WHERE agenda_id=:id");
        $query->bindParam(':id',$id);
        $query->execute();
        $vOHorarios = $query->fetchAll(PDO::FETCH_CLASS,'AgendaHorario');
        
        return $vOHorarios;
        
    }
    
    public function listarExames(){
        
        $query = $this->conexao->prepare('SELECT agenda_id,exame_id FROM agenda_exame');
        $query->execute();
        $vOExames = $query->fetchAll(PDO::FETCH_CLASS,'AgendaExame');
        
        $arrayNomes = Array();
        foreach($vOExames as $exame){
            $setContinue = true;
            for($cont = 0; $cont < count($arrayNomes); ++$cont){
                if($arrayNomes[$cont]->getExame_id() == $exame->getExame_id()){
                    $arrayNomes[$cont] = $exame;
                    $setContinue = false;
                    break;
                }
            }
            if($setContinue){
                array_push($arrayNomes,$exame);
            }
        }
        $vOExames = $arrayNomes;
        foreach($vOExames as $exame){
            $query = $this->conexao->prepare('SELECT id,nome,ativo,exame_categoria_id FROM exame WHERE id=:id AND ativo=1');
            @$query->bindParam(':id',$exame->getExame_id());
            $query->execute();
            $vExames = $query->fetchAll(PDO::FETCH_CLASS,'Exame');
            
            $exame->setOExame($vExames[0]);
        }
        
        return $vOExames;
        
    }
    
    public function exibirAgendaPaciente($idExame){
        
        $sql = "SELECT ae.agenda_id,ae.exame_id FROM agenda_exame AS ae "
                . "INNER JOIN exame AS e "
                . "ON ae.exame_id = e.id INNER JOIN "
                . "agenda AS a ON a.id=ae.agenda_id "
                . "WHERE ae.exame_id=:exame_id "
                . "AND a.ativo = 1 AND e.ativo = 1";
        
        $vOAgendasExame = Array();
        $query = $this->conexao->prepare($sql);
        
        $query->bindParam(":exame_id",$idExame);
        
        
        $query->execute();
        $vOAgendasExame = $query->fetchAll(PDO::FETCH_CLASS,'AgendaExame');
        
        foreach($vOAgendasExame as $oAgendaExame){
            //obj agenda
            $query = $this->conexao->prepare('SELECT a.dia_semana,a.ativo, '
                    . 'a.local_id, ah.id, ah.horario, ah.agenda_id, ah.ativo '
                    . 'FROM agenda a INNER JOIN agenda_horario ah '
                    . 'ON(a.id=ah.agenda_id) '
                    . 'WHERE a.id=:agenda_id');
            @$query->bindParam(':agenda_id', $oAgendaExame->getAgenda_id());
            $query->execute();
            $arrayResult = $query->fetchAll(PDO::FETCH_ASSOC);
            
            $oAgendaExame->setOAgenda($arrayResult[0]);
            
            
            
        }

        return $vOAgendasExame;

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

