<?php

/**
 * Description
 *
 * @author Igor de Lima Mendes
 */
class Medico {
    private $registro;
    private $pessoa_id;
    private $ativo;
    
    private $oPessoa;
    
    public function __construct() {
        
    }

    public function getRegistro() {
        return $this->registro;
    }

    public function getPessoa_id() {
        return $this->pessoa_id;
    }

    public function getAtivo() {
        return $this->ativo;
    }

    public function getOPessoa() {
        return $this->oPessoa;
    }

    public function setRegistro($registro) {
        $this->registro = $registro;
    }

    public function setPessoa_id($pessoa_id) {
        $this->pessoa_id = $pessoa_id;
    }

    public function setAtivo($ativo) {
        $this->ativo = $ativo;
    }

    public function setOPessoa($oPessoa) {
        $this->oPessoa = $oPessoa;
    }

}
?>