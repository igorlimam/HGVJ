<?php

if(file_exists('dao/GenericDAO.php')){
    require_once 'dao/GenericDAO.php';
}else{
    require_once '../dao/GenericDAO.php';
}

class GlossarioDAO extends GenericDAO {
    
    public function salvar($oGlossario){
        $this->conexao->beginTransaction();
        try{
            if(!$oGlossario->getId()){
               $sql = "INSERT INTO glossario(titulo,descricao,glossario_categoria_id) values(:titulo,:descricao,:glossario_categoria_id)";				
            }else{
               $sql = "UPDATE glossario SET titulo=:titulo,descricao=:descricao,glossario_categoria_id=:glossario_categoria_id WHERE id=:id";
            }

            $query = $this->conexao->prepare($sql);
            $query->bindParam(':titulo',$oGlossario->getTitulo());
            $query->bindParam(':descricao',$oGlossario->getDescricao());
            $query->bindParam(':glossario_categoria_id',$oGlossario->getGlossario_categoria_id());

            if($oGlossario->getId()){
                $query->bindParam(':id',$oGlossario->getId());
            }

            $query->execute();

            if(!$oGlossario->getId()){
                $oGlossario->setId($this->conexao->lastInsertId());					
            }

            $this->conexao->commit();


        }catch(Exception $e){
            $this->conexao->rollback();
            echo $e->getMessage();
        }			
        return $oGlossario;
    }

    public function deletar($id){

        $result = 1;

        $this->conexao->beginTransaction();
        try{
            $query = $this->conexao->prepare("DELETE FROM glossario WHERE id=:id");
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

    public function listar($categoria){
        $vOGlossarios = Array();
        $query = $this->conexao->prepare("SELECT id,titulo,descricao,glossario_categoria_id FROM glossario WHERE glossario_categoria_id = :glossario_categoria_id");
		$query->bindParam(':glossario_categoria_id',$categoria);
        $query->execute();
        $vOGlossarios = $query->fetchALL(PDO::FETCH_CLASS,'Glossario');
        
        foreach($vOGlossarios as $oGlossario){
            $query = $this->conexao->prepare("SELECT id,nome FROM glossario_categoria WHERE id=:glossario_categoria_id");
            @$query->bindParam(":glossario_categoria_id",$oGlossario->getGlossario_categoria_id());
            $query->execute();
            
            $oCategoria = $query->fetchAll(PDO::FETCH_CLASS,'GlossarioCategoria');
            $oGlossario->setOGlossario_categoria($oCategoria[0]);
        }
        
        return $vOGlossarios;
    }

    public function buscar($titulo){

        $vOGlossarios = Array();
        if($titulo == null){
            $titulo = "%a".$titulo."%";
        }else{
            $titulo = "%".$titulo."%";
        }
        $query = $this->conexao->prepare("SELECT id,titulo,descricao,glossario_categoria_id FROM glossario WHERE titulo LIKE :titulo");
        $query->bindParam(':titulo', $titulo);
        $query->execute();
        $vOGlossarios = $query->fetchALL(PDO::FETCH_CLASS,'Glossario');
        
        foreach($vOGlossarios as $oGlossario){
            $query = $this->conexao->prepare("SELECT id,nome FROM glossario_categoria WHERE id=:glossario_categoria_id");
            @$query->bindParam(":glossario_categoria_id",$oGlossario->getGlossario_categoria_id());
            $query->execute();
            
            $oCategoria = $query->fetchAll(PDO::FETCH_CLASS,'GlossarioCategoria');
            $oGlossario->setOGlossario_categoria($oCategoria[0]);
        }
        
        return $vOGlossarios;

    }

    public function buscarById($id){

        $vOGlossarios = Array();
        $query = $this->conexao->prepare("SELECT id,titulo,descricao,glossario_categoria_id FROM glossario WHERE id=:id");
        $query->bindParam(':id',$id);
        $query->execute();
        $vOGlossarios = $query->fetchALL(PDO::FETCH_CLASS,'Glossario');

        $query = $this->conexao->prepare("SELECT id,nome FROM glossario_categoria WHERE id=:id");
        @$query->bindParam(':id',$vOGlossarios[0]->getGlossario_categoria_id());
        $query->execute();
        $vGlossarioCategorias = $query->fetchALL(PDO::FETCH_CLASS,'GlossarioCategoria');
        $vOGlossarios[0]->setOGlossario_categoria($vGlossarioCategorias[0]);

        return $vOGlossarios[0];

    }
    
    public function listarCategoria(){
        $vOCategorias = Array();
		
		$query = $this->conexao->prepare("SELECT id,glossario_categoria_id FROM glossario");
        $query->execute();
        $vOGlossario = $query->fetchALL(PDO::FETCH_CLASS,'Glossario');
		
        foreach($vOGlossario as $glossario){
			$query = $this->conexao->prepare("SELECT id,nome FROM glossario_categoria WHERE id = :id");
			@$query->bindParam(':id',$glossario->getGlossario_categoria_id());
			$query->execute();
			$vResult = $query->fetchALL(PDO::FETCH_CLASS,'GlossarioCategoria');
			
			$setPush = true;
			for($cont = 0; $cont < count($vOCategorias);++$cont){
				
				if($vOCategorias[$cont] == $vResult[0]){
					$vOCategorias[$cont] == $vResult[0];
					$setPush = false;
					break;
				}
			}
			if($setPush == true){
				array_push($vOCategorias,$vResult[0]);
			}
			
		}
        
        return $vOCategorias;
    }
	
	public function listarTodasCategorias(){
        $vOCategorias = Array();
		$query = $this->conexao->prepare("SELECT id,nome FROM glossario_categoria");
		$query->execute();
		$vOCategorias = $query->fetchALL(PDO::FETCH_CLASS,'GlossarioCategoria');
        
        return $vOCategorias;
    }
    
}
