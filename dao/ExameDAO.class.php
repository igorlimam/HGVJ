<?php

if(file_exists('dao/GenericDAO.php')){
    require_once 'dao/GenericDAO.php';
}else{
    require_once '../dao/GenericDAO.php';
}

class ExameDAO extends GenericDAO {
    
    public function salvar($oExame){
        $this->conexao->beginTransaction();
        try{
            if(!$oExame->getId()){
               $sql = "INSERT INTO exame(nome,ativo,exame_categoria_id) VALUES(:nome,:ativo,:exame_categoria_id)";
            }else{
               $sql = "UPDATE exame SET nome=:nome,ativo=:ativo,exame_categoria_id=:exame_categoria_id WHERE id=:id";
            }

            $query = $this->conexao->prepare($sql);
            $query->bindParam(':nome',$oExame->getNome());
            $query->bindParam(':ativo',$oExame->getAtivo());
            $query->bindParam(':exame_categoria_id',$oExame->getExame_categoria_id());

            if($oExame->getId()){
                $query->bindParam(':id',$oExame->getId());
            }

            $query->execute();

            if(!$oExame->getId()){
                $oExame->setId($this->conexao->lastInsertId());					
            }

            $this->conexao->commit();


        }catch(Exception $e){
            $this->conexao->rollback();
            echo $e->getMessage();
        }			
        return $oExame;
    }

    public function deletar($id){

        $result = 1;

        $this->conexao->beginTransaction();
        try{
            $query = $this->conexao->prepare("DELETE FROM exame WHERE id=:id");
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
        $vOExames = Array();
		
		$query = $this->conexao->prepare('SELECT count(*) AS cont FROM exame');
	    $query->execute();
	    $numero_resultados = $query->fetch(PDO::FETCH_OBJ);
	    $numero_resultados = $numero_resultados->cont;
		
		$sql = "SELECT id,nome,ativo,exame_categoria_id FROM exame WHERE ativo = 1 ORDER BY nome ASC";
		if ($limite > 0){
          $sql .= " LIMIT ".($pagina*$limite).",".$limite;
        }
        
		$query = $this->conexao->prepare($sql);
        $query->execute();
        $vOExames = $query->fetchALL(PDO::FETCH_CLASS,'Exame');
        
		if ($limite > 0){
		  
          $numero_paginas = ceil($numero_resultados / $limite);
		  $_SESSION['numero_pag'] = $numero_paginas;
          if ($pagina > 0) {
              $pagina += $limite - 1;
          }
        }
		
        foreach($vOExames as $oExame){
            
            $query = $this->conexao->prepare("SELECT id,nome FROM exame_categoria WHERE id=:id");
            @$query->bindParam(":id",$oExame->getExame_categoria_id());
            $query->execute();
            $vOExameCategoria = $query->fetchAll(PDO::FETCH_CLASS, "ExameCategoria");
            
            $oExame->setOExame_categoria($vOExameCategoria[0]);
            
        }

        return $vOExames;
    }

    public function buscar($nome,$pagina,$limite){
        $nome = "%".$nome."%";
        $vOExames = Array();
		
		$query = $this->conexao->prepare('SELECT count(*) AS cont FROM exame');
	    $query->execute();
	    $numero_resultados = $query->fetch(PDO::FETCH_OBJ);
	    $numero_resultados = $numero_resultados->cont;
		
		$sql = "SELECT id,nome,ativo,exame_categoria_id FROM exame WHERE nome LIKE :nome ORDER BY nome ASC";
		if ($limite > 0){
          $sql .= " LIMIT ".($pagina*$limite).",".$limite;
        }
		
        $query = $this->conexao->prepare($sql);
        $query->bindParam(":nome", $nome);
        $query->execute();
        $vOExames = $query->fetchALL(PDO::FETCH_CLASS,'Exame');
		
		if ($limite > 0){
          $numero_paginas = ceil($numero_resultados / $limite);
		  $_SESSION['numero_pag'] = $numero_paginas;
          if ($pagina > 0) {
              $pagina += $limite - 1;
          }
        }
        
        foreach($vOExames as $oExame){
            
            $query = $this->conexao->prepare("SELECT id,nome FROM exame_categoria WHERE id=:id");
            @$query->bindParam(":id",$oExame->getExame_categoria_id());
            $query->execute();
            $vOExameCategoria = $query->fetchAll(PDO::FETCH_CLASS, "ExameCategoria");
            
            $oExame->setOExame_categoria($vOExameCategoria[0]);
            
        }

        return $vOExames;

    }

    public function buscarById($id){

        $vOExames = Array();
        $query = $this->conexao->prepare("SELECT id,nome,ativo,exame_categoria_id FROM exame WHERE id=:id");
        $query->bindParam(":id", $id);
        $query->execute();
        $vOExames = $query->fetchALL(PDO::FETCH_CLASS,'Exame');
            
        $query = $this->conexao->prepare("SELECT id,nome FROM exame_categoria WHERE id=:id");
        @$query->bindParam(":id",$vOExames[0]->getExame_categoria_id());
        $query->execute();
        $vOExameCategoria = $query->fetchAll(PDO::FETCH_CLASS, "ExameCategoria");
            
        $vOExames[0]->setOExame_categoria($vOExameCategoria[0]);

        return $vOExames[0];

    }
    
    public function listarCategoria(){
        $vOCategorias = Array();
        $query = $this->conexao->prepare("SELECT id,nome FROM exame_categoria");
        $query->execute();
        $vOCategorias = $query->fetchALL(PDO::FETCH_CLASS,'ExameCategoria');
        
        return $vOCategorias;
    }
    
    public function buscarPorCategoria($idCategoria){
        
        $vOExames = Array();
        $query = $this->conexao->prepare("SELECT id,nome,exame_categoria_id FROM exame WHERE exame_categoria_id=:id");
        $query->bindParam(":id",$idCategoria);
        $query->execute();
        $vOExames = $query->fetchAll(PDO::FETCH_CLASS,'Exame');
        
        foreach($vOExames as $oExame){
            $query = $this->conexao->prepare("SELECT id,nome FROM exame_categoria WHERE id=:id");
            $query->bindParam(":id",$oExame->getExame_categoria_id());
            $query->execute();
            $arrayResult = $query->fetchAll(PDO::FETCH_CLASS,'ExameCategoria');
            $oExame->setOExame_categoria($arrayResult[0]);
        }
        
        return $vOExames;
        
    }
    
}
