<?php

if(file_exists('dao/GenericDAO.php')){
    require_once 'dao/GenericDAO.php';
}else{
    require_once '../dao/GenericDAO.php';
}

class PerguntaDAO extends GenericDAO {
   
     public function salvar($oPergunta){
        $this->conexao->beginTransaction();
        try{
            if(!$oPergunta->getId()){
               $sql = "INSERT INTO pergunta(descricao,resposta,pergunta_categoria_id) values(:descricao,:resposta,:pergunta_categoria_id)";				;
            }else{
               $sql = "UPDATE pergunta SET descricao=:descricao,resposta=:resposta,pergunta_categoria_id=:pergunta_categoria_id WHERE id=:id";
            }

            $query = $this->conexao->prepare($sql);
            $query->bindParam(':descricao',$oPergunta->getDescricao());
            $query->bindParam(':resposta',$oPergunta->getResposta());
            $query->bindParam(':pergunta_categoria_id',$oPergunta->getPergunta_categoria_id());

            if($oPergunta->getId()){
                $query->bindParam(':id',$oPergunta->getId());
            }

            $query->execute();

            if(!$oPergunta->getId()){
                $oPergunta->setId($this->conexao->lastInsertId());					
            }

            $this->conexao->commit();


        }catch(Exception $e){
            $this->conexao->rollback();
            echo $e->getMessage();
        }			
        return $oPergunta;
    }

    public function deletar($id){

        $result = 1;

        $this->conexao->beginTransaction();
        try{
            $query = $this->conexao->prepare("DELETE FROM pergunta WHERE id=:id");
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
        $vOPerguntas = Array();
		
		$query = $this->conexao->prepare('SELECT count(*) AS cont FROM pergunta');
	    $query->execute();
	    $numero_resultados = $query->fetch(PDO::FETCH_OBJ);
	    $numero_resultados = $numero_resultados->cont;
		
		$sql = "SELECT id,descricao,resposta,pergunta_categoria_id FROM pergunta ORDER BY descricao ASC";
		if ($limite > 0){
          $sql .= " LIMIT ".($pagina*$limite).",".$limite;
        }
		
        $query = $this->conexao->prepare($sql);
        $query->execute();
        $vOPerguntas = $query->fetchALL(PDO::FETCH_CLASS,'Pergunta');
		
		if ($limite > 0){
		  
          $numero_paginas = ceil($numero_resultados / $limite);
		  $_SESSION['numero_pag'] = $numero_paginas;
          if ($pagina > 0) {
              $pagina += $limite - 1;
          }
        }
        
        foreach($vOPerguntas as $oPergunta){
            
            $query = $this->conexao->prepare("SELECT id,nome FROM pergunta_categoria WHERE id=:id");
            @$query->bindParam(":id",$oPergunta->getPergunta_categoria_id());
            $query->execute();
            $vOPerguntaCategoria = $query->fetchAll(PDO::FETCH_CLASS, "PerguntaCategoria");
            
            $oPergunta->setOPergunta_categoria($vOPerguntaCategoria[0]);
            
        }

        return $vOPerguntas;
    }

    public function buscar($descricao,$pagina,$limite){
        $descricao = "%".$descricao."%";
		
		$query = $this->conexao->prepare('SELECT count(*) AS cont FROM pergunta');
	    $query->execute();
	    $numero_resultados = $query->fetch(PDO::FETCH_OBJ);
	    $numero_resultados = $numero_resultados->cont;
		
		$sql = "SELECT id,descricao,resposta,pergunta_categoria_id FROM pergunta WHERE descricao LIKE :descricao ORDER BY descricao ASC";
		if ($limite > 0){
          $sql .= " LIMIT ".($pagina*$limite).",".$limite;
        }
		
		$vOPerguntas = Array();
        $query = $this->conexao->prepare($sql);
        $query->bindParam(":descricao", $descricao);
        $query->execute();
        $vOPerguntas = $query->fetchALL(PDO::FETCH_CLASS,'Pergunta');
        
		if ($limite > 0){
		  
          $numero_paginas = ceil($numero_resultados / $limite);
		  $_SESSION['numero_pag'] = $numero_paginas;
          if ($pagina > 0) {
              $pagina += $limite - 1;
          }
        }
		
        foreach($vOPerguntas as $oPergunta){
            
            $query = $this->conexao->prepare("SELECT id,nome FROM pergunta_categoria WHERE id=:id");
            @$query->bindParam(":id",$oPergunta->getPergunta_categoria_id());
            $query->execute();
            $vOPerguntaCategoria = $query->fetchAll(PDO::FETCH_CLASS, "PerguntaCategoria");
            
            $oPergunta->setOPergunta_categoria($vOPerguntaCategoria[0]);
            
        }

        return $vOPerguntas;

    }

    public function buscarById($id){

        $vOPerguntas = Array();
        $query = $this->conexao->prepare("SELECT id,descricao,resposta,pergunta_categoria_id FROM pergunta WHERE id=:id");
        $query->bindParam(":id", $id);
        $query->execute();
        $vOPerguntas = $query->fetchALL(PDO::FETCH_CLASS,'Pergunta');
            
        $query = $this->conexao->prepare("SELECT id,nome FROM pergunta_categoria WHERE id=:id");
        @$query->bindParam(":id",$vOPerguntas[0]->getPergunta_categoria_id());
        $query->execute();
        $vOPerguntaCategoria = $query->fetchAll(PDO::FETCH_CLASS, "PerguntaCategoria");
            
        $vOPerguntas[0]->setOPergunta_categoria($vOPerguntaCategoria[0]);

        return $vOPerguntas[0];

    }
    
    public function listarCategoria(){
        $vOCategorias = Array();
        $query = $this->conexao->prepare("SELECT id,nome FROM pergunta_categoria");
        $query->execute();
        $vOCategorias = $query->fetchALL(PDO::FETCH_CLASS,'PerguntaCategoria');
        
        return $vOCategorias;
    }
    
}
