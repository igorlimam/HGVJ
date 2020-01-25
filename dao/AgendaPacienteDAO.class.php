<?php

if(file_exists('dao/GenericDAO.php')){
    require_once 'dao/GenericDAO.php';
}else{
    require_once '../dao/GenericDAO.php';
}

class AgendaPacienteDAO extends GenericDAO {
    
    public function salvar($oAgendaPaciente, $oPessoa=null){
        $this->conexao->beginTransaction();
        try{ 
            
            //Cadastrar uma nova pessoa na mesma transação
            if(file_exists('dao/PessoaDAO.class.php')){
               require_once 'dao/PessoaDAO.class.php';
            }else{
               require_once '../dao/PessoaDAO.class.php';
            }

            $pessoaDAO = new PessoaDAO();
            $oPessoa = $pessoaDAO->AddPessoa($oPessoa,$this->conexao);
            
            if(!$oAgendaPaciente->getId()){
               $sql = "INSERT INTO agenda_paciente(data,data_pedido,data_status,agenda_horario_id,agenda_status_id,pessoa_id) values(:data,:data_pedido,:data_status,:agenda_horario_id,:agenda_status_id,:pessoa_id)";
            }else{
               $sql = "UPDATE agenda_paciente SET data=:data,data_pedido=:data_pedido,data_status=:data_status,agenda_horario_id=:agenda_horario_id,pessoa_id=:pessoa_id WHERE id=:id";
            }

            $query = $this->conexao->prepare($sql);
            $query->bindParam(':data',$oAgendaPaciente->getData());
            $query->bindParam(':data_pedido',$oAgendaPaciente->getData_pedido());
            $query->bindParam(':data_status',$oAgendaPaciente->getData_status());
            $query->bindParam(':agenda_horario_id',$oAgendaPaciente->getAgenda_horario_id());
            $query->bindParam(':agenda_status_id',$oAgendaPaciente->getAgenda_status_id());
            
            if(isset($oPessoa) && $oPessoa->getId()){
                $query->bindParam(':pessoa_id', $oPessoa->getId());
            }
            if($oAgendaPaciente->getId() != null){
                $query->bindParam(':id',$oAgendaPaciente->getId());
            }

            $query->execute();
            
            $oAgendaPaciente->setId($this->conexao->lastInsertId());
            
            $this->conexao->commit();

        }catch(Exception $e){
            $this->conexao->rollback();
            echo $e->getMessage();
        }			
        return $oAgendaPaciente;
    }

    public function deletar($id){

        $result = 1;
        
        $this->conexao->beginTransaction();
        try{
            $query = $this->conexao->prepare("DELETE FROM agenda_paciente WHERE id=:id");
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

    public function listar($pagina=null,$limite=null,$agenda=null){
        $vOAgendaPacientes = Array();
		
		if($agenda == 'C'){
			$query = $this->conexao->prepare('SELECT count(*) AS cont FROM agenda_paciente AS ap INNER JOIN agenda_horario AS ah ON ap.agenda_horario_id=ah.id INNER JOIN agenda_medica AS am ON am.agenda_id=ah.agenda_id');
			$query->execute();
			$numero_resultados = $query->fetch(PDO::FETCH_OBJ);
			$numero_resultados = $numero_resultados->cont;
		}else if($agenda == 'E'){
			$query = $this->conexao->prepare('SELECT count(*) AS cont FROM agenda_paciente AS ap INNER JOIN agenda_horario AS ah ON ap.agenda_horario_id=ah.id INNER JOIN agenda_exame AS ae ON ae.agenda_id=ah.agenda_id');
			$query->execute();
			$numero_resultados = $query->fetch(PDO::FETCH_OBJ);
			$numero_resultados = $numero_resultados->cont;
		}
		
		$sql = "SELECT id,data,data_pedido,data_status,"
                . "agenda_horario_id,agenda_status_id,pessoa_id FROM agenda_paciente";
		if ($limite > 0){
          $sql .= " LIMIT ".($pagina*$limite).",".$limite;
        }
		
        $query = $this->conexao->prepare($sql);
        $query->execute();
        $vOAgendaPacientes = $query->fetchALL(PDO::FETCH_CLASS,'AgendaPaciente');
		
		if ($limite > 0){
		  
          $numero_paginas = ceil($numero_resultados / $limite);
		  $_SESSION['numero_pag'] = $numero_paginas;
          if ($pagina > 0) {
              $pagina += $limite - 1;
          }
        }
        
        foreach($vOAgendaPacientes as $oAgendaPaciente){
            //obj pessoa
            $query = $this->conexao->prepare("SELECT id,nome,cpf,email,telefone FROM pessoa WHERE id=:id");
            @$query->bindParam(":id",$oAgendaPaciente->getPessoa_id());
            $query->execute();
            $vOPessoa = $query->fetchAll(PDO::FETCH_CLASS, "Pessoa");
            
            $oAgendaPaciente->setOPessoa($vOPessoa[0]);
            
            //obj agenda_horario
            $query = $this->conexao->prepare('SELECT id,horario,agenda_id,ativo FROM agenda_horario WHERE id=:id');
            @$query->bindParam(':id',$oAgendaPaciente->getAgenda_horario_id());
            $query->execute();
            $vOAgendaHorario = $query->fetchAll(PDO::FETCH_CLASS,'AgendaHorario');
            $oAgendaPaciente->setOAgenda_horario($vOAgendaHorario[0]);
            
            //obj agenda status
            $query = $this->conexao->prepare('SELECT id,nome FROM agenda_status WHERE id=:id');
            @$query->bindParam(':id',$oAgendaPaciente->getAgenda_status_id());
            $query->execute();
            $vOAgendaStatus = $query->fetchAll(PDO::FETCH_CLASS,'AgendaStatus');
            $oAgendaPaciente->setOAgenda_status($vOAgendaStatus[0]);
            
            //obj pessoa
            $query = $this->conexao->prepare("SELECT id,nome,cpf,telefone,email FROM pessoa WHERE id=:id");
            @$query->bindParam(":id",$oAgendaPaciente->getPessoa_id());
            $query->execute();
            $vOPessoa = $query->fetchAll(PDO::FETCH_CLASS, "Pessoa");
            $oAgendaPaciente->setOPessoa($vOPessoa[0]);
            
        }

        return $vOAgendaPacientes;
    }

    public function buscar($nome,$pagina,$limite,$agenda){
        
        $nome = "%".$nome."%";
        $vOAgendaPacientes = Array();
		
		if($agenda == 'C'){
			$query = $this->conexao->prepare('SELECT count(*) AS cont FROM agenda_paciente AS ap INNER JOIN agenda_horario AS ah ON ap.agenda_horario_id=ah.id INNER JOIN agenda_medica AS am ON am.agenda_id=ah.agenda_id');
			$query->execute();
			$numero_resultados = $query->fetch(PDO::FETCH_OBJ);
			$numero_resultados = $numero_resultados->cont;
		}else if($agenda == 'E'){
			$query = $this->conexao->prepare('SELECT count(*) AS cont FROM agenda_paciente AS ap INNER JOIN agenda_horario AS ah ON ap.agenda_horario_id=ah.id INNER JOIN agenda_exame AS ae ON ae.agenda_id=ah.agenda_id');
			$query->execute();
			$numero_resultados = $query->fetch(PDO::FETCH_OBJ);
			$numero_resultados = $numero_resultados->cont;
		}
		
		$sql = "SELECT ap.id,ap.data,ap.data_pedido,ap.data_status,ap.data_pedido,ap.data_status,ap.agenda_horario_id,ap.agenda_status_id,ap.pessoa_id FROM agenda_paciente AS ap INNER JOIN pessoa AS p ON ap.pessoa_id=p.id WHERE p.nome LIKE :nome";
		if ($limite > 0){
          $sql .= " LIMIT ".($pagina*$limite).",".$limite;
        }
		
        $query = $this->conexao->prepare($sql);
        $query->bindParam(":nome", $nome);
        $query->execute();
        $vOAgendaPacientes = $query->fetchALL(PDO::FETCH_CLASS,'AgendaPaciente');
		
		if ($limite > 0){
		  
          $numero_paginas = ceil($numero_resultados / $limite);
		  $_SESSION['numero_pag'] = $numero_paginas;
          if ($pagina > 0) {
              $pagina += $limite - 1;
          }
        }
        
        foreach($vOAgendaPacientes as $oAgendaPaciente){
            //obj pessoa
            $query = $this->conexao->prepare("SELECT id,nome,cpf,email,telefone FROM pessoa WHERE id=:id");
            @$query->bindParam(":id",$oAgendaPaciente->getPessoa_id());
            $query->execute();
            $vOPessoa = $query->fetchAll(PDO::FETCH_CLASS, "Pessoa");
            
            $oAgendaPaciente->setOPessoa($vOPessoa[0]);
            
            //obj agenda_horario
            $query = $this->conexao->prepare('SELECT id,horario,agenda_id,ativo FROM agenda_horario WHERE id=:id');
            @$query->bindParam(':id',$oAgendaPaciente->getAgenda_horario_id());
            $query->execute();
            $vOAgendaHorario = $query->fetchAll(PDO::FETCH_CLASS,'AgendaHorario');
            $oAgendaPaciente->setOAgenda_horario($vOAgendaHorario[0]);
            
            //obj agenda status
            $query = $this->conexao->prepare('SELECT id,nome FROM agenda_status WHERE id=:id');
            @$query->bindParam(':id',$oAgendaPaciente->getAgenda_status_id());
            $query->execute();
            $vOAgendaStatus = $query->fetchAll(PDO::FETCH_CLASS,'AgendaStatus');
            $oAgendaPaciente->setOAgenda_status($vOAgendaStatus[0]);
            
            //obj pessoa
            $query = $this->conexao->prepare("SELECT id,nome,cpf,telefone,email FROM pessoa WHERE id=:id");
            @$query->bindParam(":id",$oAgendaPaciente->getPessoa_id());
            $query->execute();
            $vOPessoa = $query->fetchAll(PDO::FETCH_CLASS, "Pessoa");
            $oAgendaPaciente->setOPessoa($vOPessoa[0]);
            
        }

        return $vOAgendaPacientes;

    }

    public function buscarById($id){
        $vOAgendaPacientes = Array();
        $query = $this->conexao->prepare("SELECT id,data,data_pedido,data_status,"
                . "agenda_horario_id,agenda_status_id,pessoa_id FROM agenda_paciente"
                . " WHERE id=:id");
        $query->bindParam(':id',$id);
        $query->execute();
        $vOAgendaPacientes = $query->fetchALL(PDO::FETCH_CLASS,'AgendaPaciente');
        
        foreach($vOAgendaPacientes as $oAgendaPaciente){
            //obj pessoa
            $query = $this->conexao->prepare("SELECT id,nome,cpf,email,telefone FROM pessoa WHERE id=:id");
            @$query->bindParam(":id",$oAgendaPaciente->getPessoa_id());
            $query->execute();
            $vOPessoa = $query->fetchAll(PDO::FETCH_CLASS, "Pessoa");
            
            $oAgendaPaciente->setOPessoa($vOPessoa[0]);
            
            //obj agenda_horario
            $query = $this->conexao->prepare('SELECT id,horario,agenda_id,ativo FROM agenda_horario WHERE id=:id');
            @$query->bindParam(':id',$oAgendaPaciente->getAgenda_horario_id());
            $query->execute();
            $vOAgendaHorario = $query->fetchAll(PDO::FETCH_CLASS,'AgendaHorario');
            $oAgendaPaciente->setOAgenda_horario($vOAgendaHorario[0]);
            
            //obj agenda status
            $query = $this->conexao->prepare('SELECT id,nome FROM agenda_status WHERE id=:id');
            @$query->bindParam(':id',$oAgendaPaciente->getAgenda_status_id());
            $query->execute();
            $vOAgendaStatus = $query->fetchAll(PDO::FETCH_CLASS,'AgendaStatus');
            $oAgendaPaciente->setOAgenda_status($vOAgendaStatus[0]);
            
            //obj pessoa
            $query = $this->conexao->prepare("SELECT id,nome,cpf,telefone,email FROM pessoa WHERE id=:id");
            @$query->bindParam(":id",$oAgendaPaciente->getPessoa_id());
            $query->execute();
            $vOPessoa = $query->fetchAll(PDO::FETCH_CLASS, "Pessoa");
            $oAgendaPaciente->setOPessoa($vOPessoa[0]);
            
        }

        return $vOAgendaPacientes[0];

    }
    
    public function mudarStatus($id,$statusId) {
        $this->conexao->BeginTransaction();
        try{
            date_default_timezone_set('Brazil/East');
            $dataStatus = date('Y-m-d H-i-s',time());
            $query = $this->conexao->prepare('UPDATE agenda_paciente SET agenda_status_id=:agenda_status_id,data_status=:data_status WHERE id=:id');
            $query->bindParam(":agenda_status_id",$statusId);
            $query->bindParam(":data_status",$dataStatus);
            $query->bindParam(":id",$id);
            $query->execute();
            $this->conexao->commit();
        }catch(Exception $e){
            echo $e->getMessage();
            $this->conexao->rollBack();
        }


    }
    
    public function listarStatus(){
        $query = $this->conexao->prepare('SELECT id,nome FROM agenda_status');
        $query->execute();
        $vAgendaStatus = $query->fetchAll(PDO::FETCH_CLASS, 'AgendaStatus');
        
        return $vAgendaStatus;
    }
	
	public function listarAgenda($pagina,$limite,$idMedico){

        $vOAgendaPacientes = Array();
		
		$query = $this->conexao->prepare('SELECT count(*) AS cont FROM agenda_paciente AS ap INNER JOIN agenda_horario AS ah ON ap.agenda_horario_id=ah.id INNER JOIN agenda_medica AS am ON am.agenda_id=ah.agenda_id');
		$query->execute();
		$numero_resultados = $query->fetch(PDO::FETCH_OBJ);
		$numero_resultados = $numero_resultados->cont;
		
		$sql = "SELECT ap.id,ap.data,ap.data_pedido,ap.data_status,ap.data_pedido,ap.data_status,ap.agenda_horario_id,ap.agenda_status_id,ap.pessoa_id FROM agenda_paciente AS ap INNER JOIN agenda_horario AS ah ON ah.id=ap.agenda_horario_id INNER JOIN agenda_medica AS am ON am.agenda_id=ah.agenda_id WHERE am.medico_id = :medico_id";
		if ($limite > 0){
          $sql .= " LIMIT ".($pagina*$limite).",".$limite;
        }
		
        $query = $this->conexao->prepare($sql);
        $query->bindParam(":medico_id", $idMedico);
        $query->execute();
        $vOAgendaPacientes = $query->fetchALL(PDO::FETCH_CLASS,'AgendaPaciente');
		
		if ($limite > 0){
		  
          $numero_paginas = ceil($numero_resultados / $limite);
		  $_SESSION['numero_pag'] = $numero_paginas;
          if ($pagina > 0) {
              $pagina += $limite - 1;
          }
        }
        
        foreach($vOAgendaPacientes as $oAgendaPaciente){
            //obj pessoa
            $query = $this->conexao->prepare("SELECT id,nome,cpf,email,telefone FROM pessoa WHERE id=:id");
            @$query->bindParam(":id",$oAgendaPaciente->getPessoa_id());
            $query->execute();
            $vOPessoa = $query->fetchAll(PDO::FETCH_CLASS, "Pessoa");
            
            $oAgendaPaciente->setOPessoa($vOPessoa[0]);
            
            //obj agenda_horario
            $query = $this->conexao->prepare('SELECT id,horario,agenda_id,ativo FROM agenda_horario WHERE id=:id');
            @$query->bindParam(':id',$oAgendaPaciente->getAgenda_horario_id());
            $query->execute();
            $vOAgendaHorario = $query->fetchAll(PDO::FETCH_CLASS,'AgendaHorario');
            $oAgendaPaciente->setOAgenda_horario($vOAgendaHorario[0]);
            
            //obj agenda status
            $query = $this->conexao->prepare('SELECT id,nome FROM agenda_status WHERE id=:id');
            @$query->bindParam(':id',$oAgendaPaciente->getAgenda_status_id());
            $query->execute();
            $vOAgendaStatus = $query->fetchAll(PDO::FETCH_CLASS,'AgendaStatus');
            $oAgendaPaciente->setOAgenda_status($vOAgendaStatus[0]);
            
            //obj pessoa
            $query = $this->conexao->prepare("SELECT id,nome,cpf,telefone,email FROM pessoa WHERE id=:id");
            @$query->bindParam(":id",$oAgendaPaciente->getPessoa_id());
            $query->execute();
            $vOPessoa = $query->fetchAll(PDO::FETCH_CLASS, "Pessoa");
            $oAgendaPaciente->setOPessoa($vOPessoa[0]);
            
        }

        return $vOAgendaPacientes;

    }

}
