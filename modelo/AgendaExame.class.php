<?php

/**
 * Description
 *
 * @author Igor de Lima Mendes
 */
class AgendaExame {
    private $agenda_id;
    private $exame_id;
    
    private $oAgenda;
    private $oExame;

    public function __construct() {
        
    }
    
    public function getAgenda_id() {
        return $this->agenda_id;
    }

    public function getExame_id() {
        return $this->exame_id;
    }

    public function getOAgenda() {
        return $this->oAgenda;
    }

    public function getOExame() {
        return $this->oExame;
    }

    public function setAgenda_id($agenda_id) {
        $this->agenda_id = $agenda_id;
    }

    public function setExame_id($exame_id) {
        $this->exame_id = $exame_id;
    }

    public function setOAgenda($oAgenda) {
        $this->oAgenda = $oAgenda;
    }

    public function setOExame($oExame) {
        $this->oExame = $oExame;
    }
    
}
?>