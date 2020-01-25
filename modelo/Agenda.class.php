<?php

/**
 * Description
 *
 * @author Igor de Lima Mendes
 */
class Agenda {
    private $id;
    private $dia_semana;
    private $ativo;
    private $local_id;
    
    private $oLocal;

    public function __construct() {
        
    }
    
    public function getId() {
        return $this->id;
    }

    public function getDia_semana() {
        return $this->dia_semana;
    }

    public function getAtivo() {
        return $this->ativo;
    }

    public function getLocal_id() {
        return $this->local_id;
    }

    public function getOLocal() {
        return $this->oLocal;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function setDia_semana($dia_semana) {
        $this->dia_semana = $dia_semana;
    }

    public function setAtivo($ativo) {
        $this->ativo = $ativo;
    }

    public function setLocal_id($local_id) {
        $this->local_id = $local_id;
    }

    public function setOLocal($oLocal) {
        $this->oLocal = $oLocal;
    }

}
?>