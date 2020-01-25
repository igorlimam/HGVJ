<?php

if(file_exists('dao/GenericDAO.php')){
    require_once 'dao/GenericDAO.php';
}else{
    require_once '../dao/GenericDAO.php';
}

class EspecialidadeDAO extends GenericDAO {
    
    public function salvar($oEspecialidade){
        $this->conexao->beginTransaction();
        try{
            if(!$oEspecialidade->getId()){
               $sql = "INSERT INTO especialidade(nome) VALUES(:nome)";				;
            }else{
               $sql = "UPDATE especialidade SET nome=:nome WHERE id=:id";
            }

            $query = $this->conexao->prepare($sql);
            $query->bindParam(':nome',$oEspecialidade->getNome());
            
            if($oEspecialidade->getId()){
                $query->bindParam(':id',$oEspecialidade->getId());
            }

            $query->execute();

            if(!$oEspecialidade->getId()){
                $oEspecialidade->setId($this->conexao->lastInsertId());					
            }

            $this->conexao->commit();


        }catch(Exception $e){
            $this->conexao->rollback();
            echo $e->getMessage();
        }			
        return $oEspecialidade;
    }

    public function deletar($id){

        $result = 1;

        $this->conexao->beginTransaction();
        try{
            $query = $this->conexao->prepare("DELETE FROM especialidade WHERE id=:id");
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

    public function listar(){
        $vOEspecialidades = Array();
        $query = $this->conexao->prepare("SELECT id,nome FROM especialidade");
        $query->execute();
        $vOEspecialidades = $query->fetchALL(PDO::FETCH_CLASS,'Especialidade');
        
        return $vOEspecialidades;
    }

    public function buscar($nome){

        $vOEspecialidades = Array();
        $query = $this->conexao->prepare("SELECT id,nome FROM especialidade WHERE nome LIKE :nome");
        $query->bindParam(":nome", $nome);
        $query->execute();
        $vOEspecialidades = $query->fetchALL(PDO::FETCH_CLASS,'Especialidade');

        return $vOEspecialidades;

    }

    public function buscarById($id){

        $vOEspecialidades = Array();
        $query = $this->conexao->prepare("SELECT id,nome FROM especialidade WHERE id=:id");
        $query->bindParam(":id", $id);
        $query->execute();
        $vOEspecialidades = $query->fetchALL(PDO::FETCH_CLASS,'Especialidade');

        return $vOEspecialidades[0];

    }
    
    
}
