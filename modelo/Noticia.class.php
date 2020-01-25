<?php

/**
 * Description
 *
 * @author Igor de Lima Mendes
 */
class Noticia {
    private $id;
    private $titulo;
    private $conteudo;
    private $data;
    private $fonte;
    private $ativo;
    private $usuario_id;
    
    private $oUsuario;

    public function __construct() {
        
    }
    
    public function getId() {
        return $this->id;
    }

    public function getTitulo() {
        return $this->titulo;
    }

    public function getConteudo() {
        return $this->conteudo;
    }

    public function getData() {
        return $this->data;
    }

    public function getFonte() {
        return $this->fonte;
    }

    public function getAtivo() {
        return $this->ativo;
    }

    public function getUsuario_id() {
        return $this->usuario_id;
    }

    public function getOUsuario() {
        return $this->oUsuario;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function setTitulo($titulo) {
        $this->titulo = $titulo;
    }

    public function setConteudo($conteudo) {
        $this->conteudo = $conteudo;
    }

    public function setData($data) {
        $this->data = $data;
    }

    public function setFonte($fonte) {
        $this->fonte = $fonte;
    }

    public function setAtivo($ativo) {
        $this->ativo = $ativo;
    }

    public function setUsuario_id($usuario_id) {
        $this->usuario_id = $usuario_id;
    }

    public function setOUsuario($oUsuario) {
        $this->oUsuario = $oUsuario;
    }

}
?>