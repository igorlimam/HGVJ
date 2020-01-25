<?php

class Mensagem {

    /**
     * Início da chave{
     *        1 = Inf
     *        2 = Sucesso
     *        3 = Erro
     * } 
     * Array (chave => (valor, tipo))
     */
    public static $mensagem = array(100 => array("Login e/ou senha inv&aacute;lidos.", "info","glyphicon-info-sign"),
        101 => array("Usu&aacute;rio bloqueado, procure a diretoria.", "info","glyphicon-info-sign"),
        102 => array("Cadastro realizado com sucesso.", "success","glyphicon-ok-sign"),
        103 => array("Cadastro exclu&iacute;do com sucesso.", "success","glyphicon-ok-sign"),
        104 => array("Cadastro alterado com sucesso.", "success","glyphicon-ok-sign"),
        105 => array("O Aluno n&atilde;o possui responv&aacute;vel. Clique no bot&atilde;o logo abaixo para vincular um responv&aacute;vel.", "info","glyphicon-info-sign"),
        106 => array("Senha restaurada com sucesso.", "success","glyphicon-ok-sign"),
        301 => array("H&aacute; nota(s) acima do limite permitido, por favor corrija para prosseguir.", "danger","glyphicon-warning-sign"),
        302 => array("Campo preenchido com valor acima do m&aacute;ximo. Algumas Atividades N&atilde;o Foram Criadas.", "danger","glyphicon-warning-sign")
    );

}

?>