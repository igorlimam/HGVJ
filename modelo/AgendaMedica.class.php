<?php

/**
 * Description
 *
 * @author Igor de Lima Mendes
 */
class AgendaMedica {
    private $agenda_id;
    private $medico_id;
    
    private $oAgenda;
    private $oMedico;

    public function __construct() {
        
    }
    
    public function getAgenda_id() {
        return $this->agenda_id;
    }

    public function getMedico_id() {
        return $this->medico_id;
    }

    public function getOAgenda() {
        return $this->oAgenda;
    }

    public function getOMedico() {
        return $this->oMedico;
    }

    public function setAgenda_id($agenda_id) {
        $this->agenda_id = $agenda_id;
    }

    public function setMedico_id($medico_id) {
        $this->medico_id = $medico_id;
    }

    public function setOAgenda($oAgenda) {
        $this->oAgenda = $oAgenda;
    }

    public function setOMedico($oMedico) {
        $this->oMedico = $oMedico;
    }

}
?>