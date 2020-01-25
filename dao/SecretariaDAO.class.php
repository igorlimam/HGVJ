<?php

if(file_exists('dao/GenericDAO.php')){
    require_once 'dao/GenericDAO.php';
}else{
    require_once '../dao/GenericDAO.php';
}

class SecretariaDAO extends GenericDAO {
    
    public function salvar($oPessoa,$arrayMedico){
        $this->conexao->beginTransaction();
        try{
            if(file_exists('dao/PessoaDAO.class.php')){
                require_once 'dao/PessoaDAO.class.php';
             }else{
                require_once '../dao/PessoaDAO.class.php';
             }
            //$sql = "INSERT INTO secretaria(ativo,medico_id,pessoa_id) values(:ativo,:medico_id,:pessoa_id)";
            //Cadastrar uma nova pessoa na mesma transação
                
            $pessoaDAO = new PessoaDAO();
            
            if($oPessoa->getId() != null){
                $update = true;
            }
            
            $returnPessoa = $pessoaDAO->AddPessoa($oPessoa,$this->conexao);
            
            if(isset($update)){
                $query = $this->conexao->prepare("DELETE FROM secretaria WHERE pessoa_id=:pessoa_id");
                $query->bindParam(":pessoa_id", $oPessoa->getId());
                $query->execute();
                
                foreach($arrayMedico as $array){
                    $query = $this->conexao->prepare("INSERT INTO secretaria(ativo,medico_id,pessoa_id) VALUES(1,:medico_id,:pessoa_id)");
                    $query->bindParam(":medico_id", $array);
                    $query->bindParam(":pessoa_id", $oPessoa->getId());
                    $query->execute();
                }
                
            }else{
                foreach($arrayMedico as $array){
                    $query = $this->conexao->prepare("INSERT INTO secretaria(ativo,medico_id,pessoa_id) VALUES(1,:medico_id,:pessoa_id)");
                    $query->bindParam(":medico_id", $array);
                    $query->bindParam(":pessoa_id", $oPessoa->getId());
                    $query->execute();
                }
            }

            $this->conexao->commit();


        }catch(Exception $e){
            $this->conexao->rollback();
            echo $e->getMessage();
        }			
        return $oPessoa;
    }

    public function deletar($id){

        $result = 1;

        $this->conexao->beginTransaction();
        try{
            $query = $this->conexao->prepare("DELETE FROM secretaria WHERE pessoa_id=:id");
            $query->bindParam(':id',$id);
            $query->execute();
            
            $query = $this->conexao->prepare("DELETE FROM pessoa WHERE id=:id");
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

    public function listar($pagina,$limite){
        $vOSecretarias = Array();
		
		$query = $this->conexao->prepare('SELECT count(distinct pessoa_id) AS cont FROM secretaria');
	    $query->execute();
	    $numero_resultados = $query->fetch(PDO::FETCH_OBJ);
	    $numero_resultados = $numero_resultados->cont;
		$sql = "SELECT id,ativo,pessoa_id,medico_id FROM secretaria";
		if ($limite > 0){
          $sql .= " LIMIT ".($pagina*$limite).",".$limite;
        }
		
        $query = $this->conexao->prepare($sql);
        $query->execute();
        $vOSecretarias = $query->fetchALL(PDO::FETCH_CLASS,'Secretaria');
		
		if ($limite > 0){
		  
          $numero_paginas = ceil($numero_resultados / $limite);
		  $_SESSION['numero_pag'] = $numero_paginas;
          if ($pagina > 0) {
              $pagina += $limite - 1;
          }
        }
        
        foreach($vOSecretarias as $oSecretaria){
            
            $query = $this->conexao->prepare("SELECT id,nome,cpf,telefone,celular1,celular2,email,bloqueado FROM pessoa WHERE id=:id");
            $query->bindParam(":id",$oSecretaria->getPessoa_id());
            $query->execute();
            $vOPessoa = $query->fetchAll(PDO::FETCH_CLASS, "Pessoa");
            
            $oSecretaria->setOPessoa($vOPessoa[0]);
            
            $query = $this->conexao->prepare("SELECT registro,pessoa_id,ativo FROM medico WHERE pessoa_id=:id");
            $query->bindParam(":id",$oSecretaria->getMedico_id());
            $query->execute();
            $vOMedico = $query->fetchAll(PDO::FETCH_CLASS, "Medico");
            
            $oSecretaria->setOMedico($vOMedico[0]);
            
            $query = $this->conexao->prepare("SELECT id,nome,cpf,telefone,celular1,celular2,email,bloqueado FROM pessoa WHERE id=:id");
            $query->bindParam(":id",$oSecretaria->getOMedico()->getPessoa_id());
            $query->execute();
            $vOPessoa = $query->fetchAll(PDO::FETCH_CLASS, "Pessoa");
            
            $oSecretaria->getOMedico()->setOPessoa($vOPessoa[0]);
            
        }

        return $vOSecretarias;
    }

    public function buscar($nome,$pagina,$limite){
        
        $nome = "%".$nome."%";

        $vOSecretarias = Array();
		$query = $this->conexao->prepare('SELECT count(distinct pessoa_id) AS cont FROM secretaria');
	    $query->execute();
	    $numero_resultados = $query->fetch(PDO::FETCH_OBJ);
	    $numero_resultados = $numero_resultados->cont;
		$sql = "SELECT s.id,s.pessoa_id,s.medico_id,s.ativo FROM secretaria AS s INNER JOIN pessoa AS p ON p.id=s.pessoa_id WHERE p.nome LIKE :nome";
		if ($limite > 0){
          $sql .= " LIMIT ".($pagina*$limite).",".$limite;
        }
		
        $query = $this->conexao->prepare($sql);
        $query->bindParam(":nome", $nome);
        $query->execute();
        $vOSecretarias = $query->fetchALL(PDO::FETCH_CLASS,'Secretaria');
		
		if ($limite > 0){
		  
          $numero_paginas = ceil($numero_resultados / $limite);
		  $_SESSION['numero_pag'] = $numero_paginas;
          if ($pagina > 0) {
              $pagina += $limite - 1;
          }
        }
        
        $arrayNomes = Array();
        foreach($vOSecretarias as $secretaria){
            $setContinue = true;
            for($cont = 0; $cont < count($arrayNomes); ++$cont){
                if($arrayNomes[$cont]->getPessoa_id() == $secretaria->getPessoa_id()){
                    $arrayNomes[$cont] = $secretaria;
                    $setContinue = false;
                    break;
                }
            }
            if($setContinue){
                array_push($arrayNomes,$secretaria);
            }
        }
        
        foreach($arrayNomes as $oSrecretaria){
            
            $query = $this->conexao->prepare("SELECT id,nome,cpf,telefone FROM pessoa WHERE id=:id");
           @$query->bindParam(":id",$oSrecretaria->getPessoa_id());
            $query->execute();
            $vOPessoa = $query->fetchAll(PDO::FETCH_CLASS, "Pessoa");
            
            $oSrecretaria->setOPessoa($vOPessoa[0]);
            
        }

        return $arrayNomes;

    }

    public function buscarById($id){

        $vOSecretarias = Array();
        $query = $this->conexao->prepare("SELECT id,ativo,pessoa_id,medico_id FROM secretaria WHERE pessoa_id=:id");
        $query->bindParam(":id", $id);
        $query->execute();
        $vOSecretarias = $query->fetchALL(PDO::FETCH_CLASS,'Secretaria');
        foreach($vOSecretarias as $secretaria){
            
            $query = $this->conexao->prepare("SELECT id,nome,cpf,telefone,celular1,celular2,email,bloqueado FROM pessoa WHERE id=:id");
            @$query->bindParam(":id",$secretaria->getPessoa_id());
            $query->execute();
            $vOPessoa = $query->fetchAll(PDO::FETCH_CLASS, "Pessoa");

            $secretaria->setOPessoa($vOPessoa[0]);

            $query = $this->conexao->prepare("SELECT registro,pessoa_id,ativo FROM medico WHERE ativo = 1 AND pessoa_id=:id");
            @$query->bindParam(":id",$secretaria->getMedico_id());
            $query->execute();
            $vOMedico = $query->fetchAll(PDO::FETCH_CLASS, "Medico");

            $secretaria->setOMedico($vOMedico[0]);

            $query = $this->conexao->prepare("SELECT id,nome,cpf,telefone,celular1,celular2,email,bloqueado FROM pessoa WHERE id=:id");
            @$query->bindParam(":id",$secretaria->getOMedico()->getPessoa_id());
            $query->execute();
            $vOPessoa = $query->fetchAll(PDO::FETCH_CLASS, "Pessoa");

            $secretaria->getOMedico()->setOPessoa($vOPessoa[0]);
            
        }
        
        return $vOSecretarias;

    }
	
	public function mudarStatusSecretaria($id,$status){
        
        $this->conexao->beginTransaction();
        
        try{
            $query = $this->conexao->prepare("UPDATE secretaria SET ativo=:ativo WHERE pessoa_id=:id");
            $query->bindParam(':ativo',$status);
            $query->bindParam(':id',$id);
            $query->execute();
            
            $this->conexao->commit();
        }catch(Exception $e){
            echo $e->getMessage();
            $this->conexao->rollBack();
            return 0;
        }
        
        return 1;
        
    }
    
}
