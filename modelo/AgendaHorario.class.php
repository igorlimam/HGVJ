<?php

/**
 * Description
 *
 * @author Igor de Lima Mendes
 */
class AgendaHorario {
    private $id;
    private $horario;
    private $ativo;
    private $agenda_id;
    
    private $oAgenda;

    public function __construct() {
        
    }
    
    public function getId() {
        return $this->id;
    }

    public function getHorario() {
        return $this->horario;
    }

    public function getAtivo() {
        return $this->ativo;
    }

    public function getAgenda_id() {
        return $this->agenda_id;
    }

    public function getOAgenda() {
        return $this->oAgenda;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function setHorario($horario) {
        $this->horario = $horario;
    }

    public function setAtivo($ativo) {
        $this->ativo = $ativo;
    }

    public function setAgenda_id($agenda_id) {
        $this->agenda_id = $agenda_id;
    }

    public function setOAgenda($oAgenda) {
        $this->oAgenda = $oAgenda;
    }

}
?>