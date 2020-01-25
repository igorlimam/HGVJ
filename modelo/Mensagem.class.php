<?php

/**
 * Description
 *
 * @author Igor de Lima Mendes
 */
class Mensagem {
    private $id;
    private $remetente;
    private $email;
    private $assunto;
    private $conteudo;
    private $telefone;
    private $data_envio;
    private $status;
    private $data_status;
    private $resposta;
    private $mensagem_categoria_id;
    
    private $oMensagem_categoria;

    public function __construct() {
        
    }
    
    public function getId() {
        return $this->id;
    }

    public function getRemetente() {
        return $this->remetente;
    }

    public function getEmail() {
        return $this->email;
    }

    public function getAssunto() {
        return $this->assunto;
    }

    public function getConteudo() {
        return $this->conteudo;
    }

    public function getTelefone() {
        return $this->telefone;
    }

    public function getData_envio() {
        return $this->data_envio;
    }

    public function getStatus() {
        return $this->status;
    }

    public function getData_status() {
        return $this->data_status;
    }

    public function getResposta() {
        return $this->resposta;
    }

    public function getMensagem_categoria_id() {
        return $this->mensagem_categoria_id;
    }

    public function getOMensagem_categoria() {
        return $this->oMensagem_categoria;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function setRemetente($remetente) {
        $this->remetente = $remetente;
    }

    public function setEmail($email) {
        $this->email = $email;
    }

    public function setAssunto($assunto) {
        $this->assunto = $assunto;
    }

    public function setConteudo($conteudo) {
        $this->conteudo = $conteudo;
    }

    public function setTelefone($telefone) {
        $this->telefone = $telefone;
    }

    public function setData_envio($data_envio) {
        $this->data_envio = $data_envio;
    }

    public function setStatus($status) {
        $this->status = $status;
    }

    public function setData_status($data_status) {
        $this->data_status = $data_status;
    }

    public function setResposta($resposta) {
        $this->resposta = $resposta;
    }

    public function setMensagem_categoria_id($mensagem_categoria_id) {
        $this->mensagem_categoria_id = $mensagem_categoria_id;
    }

    public function setOMensagem_categoria($oMensagem_categoria) {
        $this->oMensagem_categoria = $oMensagem_categoria;
    }

}
?>