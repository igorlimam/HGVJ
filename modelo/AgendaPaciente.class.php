<?php

/**
 * Description
 *
 * @author Igor de Lima Mendes
 */
class AgendaPaciente {
    private $id;
    private $data;
    private $data_pedido;
    private $data_status;
    private $agenda_horario_id;
    private $agenda_status_id;
    private $pessoa_id;
    
    private $oAgenda_horario;
    private $oAgenda_status;
    private $oPessoa;

    public function __construct() {
        
    }
    
    public function getId() {
        return $this->id;
    }

    public function getData() {
        return $this->data;
    }

    public function getData_pedido() {
        return $this->data_pedido;
    }

    public function getData_status() {
        return $this->data_status;
    }

    public function getAgenda_horario_id() {
        return $this->agenda_horario_id;
    }

    public function getAgenda_status_id() {
        return $this->agenda_status_id;
    }

    public function getPessoa_id() {
        return $this->pessoa_id;
    }

    public function getOAgenda_horario() {
        return $this->oAgenda_horario;
    }

    public function getOAgenda_status() {
        return $this->oAgenda_status;
    }

    public function getOPessoa() {
        return $this->oPessoa;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function setData($data) {
        $this->data = $data;
    }

    public function setData_pedido($data_pedido) {
        $this->data_pedido = $data_pedido;
    }

    public function setData_status($data_status) {
        $this->data_status = $data_status;
    }

    public function setAgenda_horario_id($agenda_horario_id) {
        $this->agenda_horario_id = $agenda_horario_id;
    }

    public function setAgenda_status_id($agenda_status_id) {
        $this->agenda_status_id = $agenda_status_id;
    }

    public function setPessoa_id($pessoa_id) {
        $this->pessoa_id = $pessoa_id;
    }

    public function setOAgenda_horario($oAgenda_horario) {
        $this->oAgenda_horario = $oAgenda_horario;
    }

    public function setOAgenda_status($oAgenda_status) {
        $this->oAgenda_status = $oAgenda_status;
    }

    public function setOPessoa($oPessoa) {
        $this->oPessoa = $oPessoa;
    }


}
?>