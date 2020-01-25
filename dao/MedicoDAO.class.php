<?php

if(file_exists('dao/GenericDAO.php')){
    require_once 'dao/GenericDAO.php';
}else{
    require_once '../dao/GenericDAO.php';
}

class MedicoDAO extends GenericDAO {
    
    public function salvar($oMedico, $oPessoa=null,$arrayEspecialidade){
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
            
            if(!$oMedico->getPessoa_id()){
               $sql = "INSERT INTO medico(pessoa_id,registro,ativo) values(:pessoa_id,:registro,:ativo)";
            }else{
               $sql = "UPDATE medico SET registro=:registro,ativo=:ativo,pessoa_id=:pessoa_id WHERE pessoa_id=:pessoa_id";
            }

            $query = $this->conexao->prepare($sql);
            $query->bindParam(':registro',$oMedico->getRegistro());
            $query->bindParam(':ativo',$oMedico->getAtivo());
            
            if(isset($oPessoa) && $oPessoa->getId()){
                $query->bindParam(':pessoa_id', $oPessoa->getId());
            }

            $query->execute();
            $oMedico->setPessoa_id($oPessoa->getId());
            
            if($oMedico->getPessoa_id()){
                $query = $this->conexao->prepare("DELETE FROM medico_especialidade WHERE medico_id=:medico_id");
                $query->bindParam(":medico_id", $oPessoa->getId());
                $query->execute();
                
                foreach($arrayEspecialidade as $array){
                    $query = $this->conexao->prepare("INSERT INTO medico_especialidade(medico_id,especialidade_id) VALUES(:medico_id,:especialidade_id)");
                    $query->bindParam(":medico_id", $oPessoa->getId());
                    $query->bindParam(":especialidade_id", $array);
                    $query->execute();
                }
                
            }else{
                foreach($arrayEspecialidade as $array){
                    $query = $this->conexao->prepare("INSERT INTO medico_especialidade(medico_id,especialidade_id) VALUES(:medico_id,:especialidade_id)");
                    $query->bindParam(":medico_id", $oPessoa->getId());
                    $query->bindParam(":especialidade_id", $array);
                    $query->execute();
                }
            }
            
            $this->conexao->commit();


        }catch(Exception $e){
            $this->conexao->rollback();
            echo $e->getMessage();
        }			
        return $oMedico;
    }

    public function deletar($id){

        $result = 1;
        
        //if para agenda
        $this->conexao->beginTransaction();
        try{
            $query = $this->conexao->prepare("DELETE FROM medico WHERE pessoa_id=:id");
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
        $vOMedicos = Array();
		
		$query = $this->conexao->prepare('SELECT count(*) AS cont FROM medico WHERE ativo = 1 LIMIT 0,200');
	    $query->execute();
	    $numero_resultados = $query->fetch(PDO::FETCH_OBJ);
	    $numero_resultados = $numero_resultados->cont;
		
		$sql = "SELECT registro,pessoa_id,ativo FROM medico WHERE ativo = 1";
		
        if ($limite > 0){
          $sql .= " LIMIT ".($pagina*$limite).",".$limite;
        }
		
        $query = $this->conexao->prepare($sql);
        $query->execute();
        $vOMedicos = $query->fetchALL(PDO::FETCH_CLASS,'Medico');
		
		if ($limite > 0){
		  
          $numero_paginas = ceil($numero_resultados / $limite);
		  $_SESSION['numero_pag'] = $numero_paginas;
          if ($pagina > 0) {
              $pagina += $limite - 1;
          }
        }
        
        foreach($vOMedicos as $oMedico){
            
            $query = $this->conexao->prepare("SELECT id,nome,cpf FROM pessoa WHERE id=:id");
            @$query->bindParam(":id",$oMedico->getPessoa_id());
            $query->execute();
            $vOPessoa = $query->fetchAll(PDO::FETCH_CLASS, "Pessoa");
            
            $oMedico->setOPessoa($vOPessoa[0]);
            
        }

        return $vOMedicos;
    }

    public function buscar($nome,$pagina,$limite){
        
        $nome = "%".$nome."%";

        $vOMedicos = Array();
		
		$query = $this->conexao->prepare('SELECT count(*) AS cont FROM medico');
	    $query->execute();
	    $numero_resultados = $query->fetch(PDO::FETCH_OBJ);
	    $numero_resultados = $numero_resultados->cont;
		
		$sql = "SELECT m.registro,m.ativo,m.pessoa_id FROM medico AS m INNER JOIN pessoa AS p ON m.pessoa_id=p.id WHERE p.nome LIKE :nome";
		
        if ($limite > 0){
          $sql .= " LIMIT ".($pagina*$limite).",".$limite;
        }
		
        $query = $this->conexao->prepare($sql);
        $query->bindParam(":nome", $nome);
        $query->execute();
        $vOMedicos = $query->fetchALL(PDO::FETCH_CLASS,'Medico');
		
		if ($limite > 0){
		  
          $numero_paginas = ceil($numero_resultados / $limite);
		  $_SESSION['numero_pag'] = $numero_paginas;
          if ($pagina > 0) {
              $pagina += $limite - 1;
          }
        }
        
        foreach($vOMedicos as $oMedico){
            
            $query = $this->conexao->prepare("SELECT id,nome,cpf,telefone,email FROM pessoa WHERE id=:id");
            @$query->bindParam(":id",$oMedico->getPessoa_id());
            $query->execute();
            $vOPessoa = $query->fetchAll(PDO::FETCH_CLASS, "Pessoa");
            $oMedico->setOPessoa($vOPessoa[0]);
            
        }
        
        return $vOMedicos;

    }

    public function buscarById($id){
        $vOMedicos = Array();
        $query = $this->conexao->prepare("SELECT registro,pessoa_id,ativo FROM medico WHERE pessoa_id=:id");
        $query->bindParam(":id", $id);
        $query->execute();
        $vOMedicos = $query->fetchALL(PDO::FETCH_CLASS,'Medico');
        
        if(count($vOMedicos) == 0){
            return 0;
        }
        
        $query = $this->conexao->prepare("SELECT id,nome,cpf,telefone,celular1,celular2,email,bloqueado,permissao_id FROM pessoa WHERE id=:id");
        @$query->bindParam(":id",$vOMedicos[0]->getPessoa_id());
        $query->execute();
        $vOPessoa = $query->fetchAll(PDO::FETCH_CLASS, "Pessoa");
            
        $vOMedicos[0]->setOPessoa($vOPessoa[0]);
        
        $query = $this->conexao->prepare("SELECT id, nome FROM permissao WHERE id=:id");
        @$query->bindParam(':id',$vOMedicos[0]->getOPessoa()->getPermissao_id());
        $query->execute();
        $vOPermissao = $query->fetchAll(PDO::FETCH_CLASS, 'Permissao');
        
        $vOMedicos[0]->getOPessoa()->setOPermissao($vOPermissao[0]);

        return $vOMedicos[0];

    }
    
    public function mudarStatusMedico($id,$status){
        
        $this->conexao->beginTransaction();
        
        try{
            $query = $this->conexao->prepare("UPDATE medico SET ativo=:ativo WHERE pessoa_id=:id");
            $query->bindParam(':ativo',$status);
            $query->bindParam(':id',$id);
            $query->execute();
			
			if($status == 0){
				$query = $this->conexao->prepare("SELECT agenda_id FROM agenda_medica WHERE medico_id = :medico_id");
				$query->bindParam(':medico_id',$id);
				$query->execute();
				$agendas = $query->fetchAll(PDO::FETCH_OBJ);
				
				foreach($agendas as $agenda){
					$query = $this->conexao->prepare('UPDATE agenda SET ativo = 0 WHERE id=:id');
					$query->bindParam(':id',$agenda->agenda_id);
					$query->execute();
				}
				
			}
            
            $this->conexao->commit();
        }catch(Exception $e){
            echo $e->getMessage();
            $this->conexao->rollBack();
            return 0;
        }
        
        return 1;
        
    }
    
    //Especialidades
    
    public function ListarEspecialidades($id=null){
        
        if(file_exists('dao/EspecialidadeDAO.class.php')){
           require_once 'dao/EspecialidadeDAO.class.php';
        }else{
           require_once '../dao/EspecialidadeDAO.class.php';
        }
        require_once 'modelo/MedicoEspecialidade.class.php';
        $especialidadeDAO = new EspecialidadeDAO();
        if($id == null){
            $query = $this->conexao->prepare("SELECT medico_id,especialidade_id FROM medico_especialidade");
        }else{
            $query = $this->conexao->prepare("SELECT medico_id,especialidade_id FROM medico_especialidade WHERE medico_id = :medico_id");
            $query->bindParam(":medico_id", $id);
        }
        
        
        $query->execute();
        $especialidadeId = $query->fetchALL(PDO::FETCH_CLASS,'MedicoEspecialidade');
        
        $arrayNomes = Array();
        foreach($especialidadeId as $medico){
            $setContinue = true;
            for($cont = 0; $cont < count($arrayNomes); ++$cont){
                if($arrayNomes[$cont]->getEspecialidade_id() == $medico->getEspecialidade_id()){
                    $arrayNomes[$cont] = $medico;
                    $setContinue = false;
                    break;
                }
            }
            if($setContinue){
                array_push($arrayNomes,$medico);
            }
        }
        
        foreach($arrayNomes as $especialidade){
            
            
            
            $especialidade->setOEspecialidade($especialidadeDAO->buscarById($especialidade->getEspecialidade_id()));
        }
        
        return $arrayNomes;
    }
    
    public function buscarMedico($id){
        $vOEspecialidades = Array();
        $query = $this->conexao->prepare("SELECT me.medico_id,me.especialidade_id FROM medico_especialidade AS me INNER JOIN medico AS m ON m.pessoa_id = me.medico_id WHERE m.ativo = 1 AND me.especialidade_id=:id");
        $query->bindParam(":id", $id);
        $query->execute();
        $vOEspecialidades = $query->fetchALL(PDO::FETCH_CLASS,'MedicoEspecialidade');
        
        $arrayNomes = Array();
        foreach($vOEspecialidades as $medico){
            $setContinue = true;
            for($cont = 0; $cont < count($arrayNomes); ++$cont){
                if($arrayNomes[$cont]->getMedico_id() == $medico->getMedico_id()){
                    $arrayNomes[$cont] = $medico;
                    $setContinue = false;
                    break;
                }
            }
            if($setContinue){
                array_push($arrayNomes,$medico);
            }
        }
        
        foreach($vOEspecialidades as $medico){
            $medico->setOMedico(new Medico());
            $query = $this->conexao->prepare('SELECT id,nome,cpf,telefone,email FROM pessoa WHERE id=:id');
            @$query->bindParam(':id',$medico->getMedico_id());
            $query->execute();
            $arrayPessoa = $query->fetchAll(PDO::FETCH_CLASS,'Pessoa');
            $medico->getOMedico()->setOPessoa($arrayPessoa[0]);
        }
        
        print_r($vOEspecialidades);

        return $vOEspecialidades;
    }
    
}
