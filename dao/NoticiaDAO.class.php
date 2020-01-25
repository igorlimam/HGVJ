<?php

if(file_exists('dao/GenericDAO.php')){
    require_once 'dao/GenericDAO.php';
}else{
    require_once '../dao/GenericDAO.php';
}

class NoticiaDAO extends GenericDAO {
    
    public function salvar($oNoticia){
        $this->conexao->beginTransaction();
        try{
            if(!$oNoticia->getId()){
               $sql = "INSERT INTO noticia(titulo,conteudo,data,fonte,ativo,usuario_id) values(:titulo,:conteudo,:data,:fonte,:ativo,:usuario_id)";
            }else{
               $sql = "UPDATE noticia SET titulo=:titulo,conteudo=:conteudo,data=:data,fonte=:fonte,ativo=:ativo,usuario_id=:usuario_id WHERE id=:id";
            }

            $query = $this->conexao->prepare($sql);
            $query->bindParam(':titulo',$oNoticia->getTitulo());
            $query->bindParam(':conteudo',$oNoticia->getConteudo());
            $query->bindParam(':data',$oNoticia->getData());
            $query->bindParam(':fonte',$oNoticia->getFonte());
            $query->bindParam(':ativo',$oNoticia->getAtivo());
            $query->bindParam(':usuario_id',$oNoticia->getUsuario_id());

            if($oNoticia->getId()){
                $query->bindParam(':id',$oNoticia->getId());
            }

            $query->execute();

            if(!$oNoticia->getId()){
                $oNoticia->setId($this->conexao->lastInsertId());					
            }

            $this->conexao->commit();


        }catch(Exception $e){
            $this->conexao->rollback();
            echo $e->getMessage();
        }			
        return $oNoticia;
    }

    public function deletar($id){

        $result = 1;

        $this->conexao->beginTransaction();
        try{
            $query = $this->conexao->prepare("DELETE FROM noticia WHERE id=:id");
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
        $vONoticias = Array();
		
		$query = $this->conexao->prepare('SELECT count(*) AS cont FROM noticia WHERE ativo = 1 ORDER BY data DESC LIMIT 0,200');
	    $query->execute();
	    $numero_resultados = $query->fetch(PDO::FETCH_OBJ);
	    $numero_resultados = $numero_resultados->cont;

		$sql = "SELECT id,titulo,conteudo,data,fonte,ativo,usuario_id FROM noticia WHERE ativo = 1 ORDER BY data DESC";
		
        if ($limite > 0){
          $sql .= " LIMIT ".($pagina*$limite).",".$limite;
        }
		
        $query = $this->conexao->prepare($sql);
        $query->execute();
        $vONoticias = $query->fetchALL(PDO::FETCH_CLASS,'Noticia');
        
		if ($limite > 0){
		  
          $numero_paginas = ceil($numero_resultados / $limite);
		  $_SESSION['numero_pag'] = $numero_paginas;
          if ($pagina > 0) {
              $pagina += $limite - 1;
          }
        }
		
        foreach($vONoticias as $oNoticia){
            
            $query = $this->conexao->prepare("SELECT id,nome,cpf,telefone,celular1,celular2,email,bloqueado FROM pessoa WHERE id=:id");
            @$query->bindParam(":id",$oNoticia->getUsuario_id());
            $query->execute();
            $vOPessoa = $query->fetchAll(PDO::FETCH_CLASS, "Pessoa");
            
            $oNoticia->setOUsuario($vOPessoa[0]);
        }
		
        return $vONoticias;
    }

    public function buscar($nome,$pagina,$limite){
        
        $nome = "%".$nome."%";
		
		$query = $this->conexao->prepare('SELECT count(*) AS cont FROM noticia ORDER BY data DESC LIMIT 0,200');
	    $query->execute();
	    $numero_resultados = $query->fetch(PDO::FETCH_OBJ);
	    $numero_resultados = $numero_resultados->cont;
		
		$sql = "SELECT id,titulo,conteudo,data,fonte,ativo,usuario_id FROM noticia WHERE titulo like :titulo ORDER BY data DESC";
		
        if ($limite > 0){
          $sql .= " LIMIT ".($pagina*$limite).",".$limite;
        }
		
        $vONoticias = Array();
        $query = $this->conexao->prepare($sql);
        $query->bindParam(":titulo", $nome);
        $query->execute();
        $vONoticias = $query->fetchALL(PDO::FETCH_CLASS,'Noticia');
		
		if ($limite > 0){
          $numero_paginas = ceil($numero_resultados / $limite);
		  $_SESSION['numero_pag'] = $numero_paginas;
          if ($pagina > 0) {
              $pagina += $limite - 1;
          }
        }
		
        foreach($vONoticias as $oNoticia){
            
            $query = $this->conexao->prepare("SELECT id,nome,cpf,telefone FROM pessoa WHERE id=:id");
            @$query->bindParam(":id",$oNoticia->getUsuario_id());
            $query->execute();
            $vOPessoa = $query->fetchAll(PDO::FETCH_CLASS, "Pessoa");
            
            $oNoticia->setOUsuario($vOPessoa[0]);
            
        }

        return $vONoticias;

    }

    public function buscarById($id){

        $vONoticias = Array();
        $query = $this->conexao->prepare("SELECT id,titulo,conteudo,data,fonte,ativo,usuario_id FROM noticia WHERE id=:id");
        $query->bindParam(':id',$id);
        $query->execute();
        $vONoticias = $query->fetchALL(PDO::FETCH_CLASS,'Noticia');
        $query = $this->conexao->prepare("SELECT id,nome,cpf,telefone,celular1,celular2,email,bloqueado FROM pessoa WHERE id=:id");
        @$query->bindParam(":id",$vONoticias[0]->getUsuario_id());
        $query->execute();
        $vOPessoa = $query->fetchAll(PDO::FETCH_CLASS, "Pessoa");

        $vONoticias[0]->setOUsuario($vOPessoa[0]);

        return $vONoticias[0];

    }
    
    public function mudarStatus($id,$status){
        $query = $this->conexao->prepare('UPDATE noticia SET ativo = :ativo WHERE id = :id');
        $query->bindParam(':id',$id);
        $query->bindParam(':ativo',$status);
        $query->execute();
    }
    
}