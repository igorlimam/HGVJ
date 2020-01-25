<?php

/**
 * Description
 *
 * @author Igor de Lima Mendes
 */
class Glossario {
    private $id;
    private $titulo;
    private $descricao;
    private $glossario_categoria_id;
    
    private $oGlossario_categoria;

    public function __construct() {
        
    }
    
    public function getId() {
        return $this->id;
    }

    public function getTitulo() {
        return $this->titulo;
    }

    public function getDescricao() {
        return $this->descricao;
    }

    public function getGlossario_categoria_id() {
        return $this->glossario_categoria_id;
    }

    public function getOGlossario_categoria() {
        return $this->oGlossario_categoria;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function setTitulo($titulo) {
        $this->titulo = $titulo;
    }

    public function setDescricao($descricao) {
        $this->descricao = $descricao;
    }

    public function setGlossario_categoria_id($glossario_categoria_id) {
        $this->glossario_categoria_id = $glossario_categoria_id;
    }

    public function setOGlossario_categoria($oGlossario_categoria) {
        $this->oGlossario_categoria = $oGlossario_categoria;
    }

}
?>