<?php

/**
 * Description
 *
 * @author Igor de Lima Mendes
 */
class Curriculo {
    private $id;
    private $data_submissao;
    private $status;
    private $data_status;
    private $pessoa_id;
    private $area_cargo_id;
    
    private $oPessoa;
    private $oArea_cargo;

    public function __construct() {
        
    }
    
    public function getId() {
        return $this->id;
    }

    public function getData_submissao() {
        return $this->data_submissao;
    }

    public function getStatus() {
        return $this->status;
    }

    public function getData_status() {
        return $this->data_status;
    }

    public function getPessoa_id() {
        return $this->pessoa_id;
    }

    public function getArea_cargo_id() {
        return $this->area_cargo_id;
    }

    public function getOPessoa() {
        return $this->oPessoa;
    }

    public function getOArea_cargo() {
        return $this->oArea_cargo;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function setData_submissao($data_submissao) {
        $this->data_submissao = $data_submissao;
    }

    public function setStatus($status) {
        $this->status = $status;
    }

    public function setData_status($data_status) {
        $this->data_status = $data_status;
    }

    public function setPessoa_id($pessoa_id) {
        $this->pessoa_id = $pessoa_id;
    }

    public function setArea_cargo_id($area_cargo_id) {
        $this->area_cargo_id = $area_cargo_id;
    }

    public function setOPessoa($oPessoa) {
        $this->oPessoa = $oPessoa;
    }

    public function setOArea_cargo($oArea_cargo) {
        $this->oArea_cargo = $oArea_cargo;
    }

}
?>