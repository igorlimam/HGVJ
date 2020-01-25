<?php

/**
 * Description
 *
 * @author Igor de Lima Mendes
 */
class Secretaria {
    private $id;
    private $ativo;
    private $medico_id;
    private $pessoa_id;
    
    private $oMedico;
    private $oPessoa;

    public function __construct() {
        
    }
    
    public function getId() {
        return $this->id;
    }

    public function getAtivo() {
        return $this->ativo;
    }

    public function getMedico_id() {
        return $this->medico_id;
    }

    public function getPessoa_id() {
        return $this->pessoa_id;
    }

    public function getOMedico() {
        return $this->oMedico;
    }

    public function getOPessoa() {
        return $this->oPessoa;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function setAtivo($ativo) {
        $this->ativo = $ativo;
    }

    public function setMedico_id($medico_id) {
        $this->medico_id = $medico_id;
    }

    public function setPessoa_id($pessoa_id) {
        $this->pessoa_id = $pessoa_id;
    }

    public function setOMedico($oMedico) {
        $this->oMedico = $oMedico;
    }

    public function setOPessoa($oPessoa) {
        $this->oPessoa = $oPessoa;
    }

}
?>