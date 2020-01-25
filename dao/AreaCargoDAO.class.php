<?php

if(file_exists('dao/GenericDAO.php')){
    require_once 'dao/GenericDAO.php';
}else{
    require_once '../dao/GenericDAO.php';
}

class AreaCargoDAO extends GenericDAO {
    
    public function salvar($oAreaCargo){
        $this->conexao->beginTransaction();
        try{
            if(!$oAreaCargo->getId()){
               $sql = "INSERT INTO area_cargo(nome) VALUES(:nome)";				;
            }else{
               $sql = "UPDATE area_cargo SET nome=:nome WHERE id=:id";
            }

            $query = $this->conexao->prepare($sql);
            $query->bindParam(':nome',$oAreaCargo->getNome());
            
            if($oAreaCargo->getId()){
                $query->bindParam(':id',$oAreaCargo->getId());
            }

            $query->execute();

            if(!$oAreaCargo->getId()){
                $oAreaCargo->setId($this->conexao->lastInsertId());					
            }

            $this->conexao->commit();


        }catch(Exception $e){
            $this->conexao->rollback();
            echo $e->getMessage();
        }			
        return $oAreaCargo;
    }

    public function deletar($id){

        $result = 1;

        $this->conexao->beginTransaction();
        try{
            $query = $this->conexao->prepare("DELETE FROM area_cargo WHERE id=:id");
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
        $vOAreaCargo = Array();
        $query = $this->conexao->prepare("SELECT id,nome FROM area_cargo order by nome ASC");
        $query->execute();
        $vOAreaCargo = $query->fetchALL(PDO::FETCH_CLASS,'AreaCargo');
        
        return $vOAreaCargo;
    }

    public function buscar($nome){

        $vOAreasCargos = Array();
        $query = $this->conexao->prepare("SELECT id,nome FROM area_cargo WHERE nome LIKE :nome");
        $query->bindParam(":nome", $nome);
        $query->execute();
        $vOAreasCargos = $query->fetchALL(PDO::FETCH_CLASS,'AreaCargo');

        return $vOAreasCargos;

    }

    public function buscarById($id){

        $vOAreaGargos = Array();
        $query = $this->conexao->prepare("SELECT id,nome FROM area_cargo WHERE id=:id");
        $query->bindParam(":id", $id);
        $query->execute();
        $vOAreaGargos = $query->fetchALL(PDO::FETCH_CLASS,'AreaCargo');

        return $vOAreaGargos[0];

    }
    
}
