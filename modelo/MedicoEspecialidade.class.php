<?php

/**
 * Description
 *
 * @author Igor de Lima Mendes
 */
class MedicoEspecialidade {
    private $medico_id;
    private $especialidade_id;
    
    private $oMedico;
    private $oEspecialidade;

    public function __construct() {
        
    }
    
    public function getMedico_id() {
        return $this->medico_id;
    }

    public function getEspecialidade_id() {
        return $this->especialidade_id;
    }

    public function getOMedico() {
        return $this->oMedico;
    }

    public function getOEspecialidade() {
        return $this->oEspecialidade;
    }

    public function setMedico_id($medico_id) {
        $this->medico_id = $medico_id;
    }

    public function setEspecialidade_id($especialidade_id) {
        $this->especialidade_id = $especialidade_id;
    }

    public function setOMedico($oMedico) {
        $this->oMedico = $oMedico;
    }

    public function setOEspecialidade($oEspecialidade) {
        $this->oEspecialidade = $oEspecialidade;
    }

}
?>