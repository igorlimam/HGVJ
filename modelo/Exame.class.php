<?php

/**
 * Description
 *
 * @author Igor de Lima Mendes
 */
class Exame {
    private $id;
    private $nome;
    private $ativo;
    private $exame_categoria_id;
    
    private $oExame_categoria;

    public function __construct() {
        
    }
    
    public function getId() {
        return $this->id;
    }

    public function getNome() {
        return $this->nome;
    }

    public function getAtivo() {
        return $this->ativo;
    }

    public function getExame_categoria_id() {
        return $this->exame_categoria_id;
    }

    public function getOExame_categoria() {
        return $this->oExame_categoria;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function setNome($nome) {
        $this->nome = $nome;
    }

    public function setAtivo($ativo) {
        $this->ativo = $ativo;
    }

    public function setExame_categoria_id($exame_categoria_id) {
        $this->exame_categoria_id = $exame_categoria_id;
    }

    public function setOExame_categoria($oExame_categoria) {
        $this->oExame_categoria = $oExame_categoria;
    }

}
?>