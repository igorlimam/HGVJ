<?php

if(file_exists('dao/GenericDAO.php')){
    require_once 'dao/GenericDAO.php';
}else{
    require_once '../dao/GenericDAO.php';
}

class PermissaoDAO extends GenericDAO {
    
    public function salvar($oPermissao){
        $this->conexao->beginTransaction();
        try{
            if(!$oPermissao->getId()){
               $sql = "INSERT INTO permissao(nome) VALUES(:nome)";
            }else{
               $sql = "UPDATE permissao SET nome=:nome WHERE id=:id";
            }

            $query = $this->conexao->prepare($sql);
            $query->bindParam(':nome',$oPermissao->getNome());
            
            if($oPermissao->getId()){
                $query->bindParam(':id',$oPermissao->getId());
            }

            $query->execute();

            if(!$oPermissao->getId()){
                $oPermissao->setId($this->conexao->lastInsertId());					
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
            $query = $this->conexao->prepare("DELETE FROM permissao WHERE id=:id");
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
        $vOPermissoes = Array();
        $query = $this->conexao->prepare("SELECT id,nome FROM permissao");
        $query->execute();
        $vOPermissoes = $query->fetchALL(PDO::FETCH_CLASS,'Permissao');
        
        return $vOPermissoes;
    }

    public function buscar($nome){

        $vOPermissoes = Array();
        $query = $this->conexao->prepare("SELECT id,nome FROM permissao WHERE nome LIKE :nome");
        $query->bindParam(":nome", $nome);
        $query->execute();
        $vOPermissoes = $query->fetchALL(PDO::FETCH_CLASS,'Permissao');

        return $vOPermissoes;

    }

    public function buscarById($id){

        $vOPermissoes = Array();
        $query = $this->conexao->prepare("SELECT id,nome FROM permissao WHERE id=:id");
        $query->bindParam(":id", $id);
        $query->execute();
        $vOPermissoes = $query->fetchALL(PDO::FETCH_CLASS,'Permissao');

        return $vOPermissoes[0];

    }
    
}
