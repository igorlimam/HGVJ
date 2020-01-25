<?php

/**
 * Description
 *
 * @author Igor de Lima Mendes
 */
class Pergunta {
    private $id;
    private $descricao;
    private $resposta;
    private $pergunta_categoria_id;
    
    private $oPergunta_categoria;

    public function __construct() {
        
    }
    
    public function getId() {
        return $this->id;
    }

    public function getDescricao() {
        return $this->descricao;
    }

    public function getResposta() {
        return $this->resposta;
    }

    public function getPergunta_categoria_id() {
        return $this->pergunta_categoria_id;
    }

    public function getOPergunta_categoria() {
        return $this->oPergunta_categoria;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function setDescricao($descricao) {
        $this->descricao = $descricao;
    }

    public function setResposta($resposta) {
        $this->resposta = $resposta;
    }

    public function setPergunta_categoria_id($pergunta_categoria_id) {
        $this->pergunta_categoria_id = $pergunta_categoria_id;
    }

    public function setOPergunta_categoria($oPergunta_categoria) {
        $this->oPergunta_categoria = $oPergunta_categoria;
    }
    
}
?>