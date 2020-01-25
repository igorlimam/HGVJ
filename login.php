<?php

session_start();
require_once 'Loader.class.php';
require_once 'util/Redireciona.class.php';
$oPessoa = new Pessoa();
$oPessoa->setCpf(addslashes($_POST['usuario']));
$oPessoa->setSenha(addslashes($_POST['senha']));
$consulta = new PessoaDAO();
$oAP = $consulta->identifica($oPessoa->getCpf(), $oPessoa->getSenha());
//echo $resultado."<br>";
if ($oAP != NULL) {
    if ($oAP->getId()) {
        if ($oAP->getBloqueado() == 'N') {
            $_SESSION['logado'] = true;
            $_SESSION['pessoa'] = $oAP->getNome();
            $_SESSION['permissao'] = $oAP->getOpermissao()->getNome();
            if ($_SESSION['permissao'] == "Paciente") {
                session_destroy();
                Redirecionar::go("index.php");
            } else {
                if ($_SESSION['permissao'] == "Administrador") {
                    $_SESSION['id_tipo'] = $oAP->getId();
                } else {

                    if ($_SESSION['permissao'] == "Secretaria") {

                        $_SESSION['id_tipo'] = $oAP->getId();
                    } else {

                        if ($_SESSION['permissao'] == "Medico") {

                            $_SESSION['id_tipo'] = $oAP->getId();
                        }
                    }
                }
            }

            $_SESSION['id_pessoa'] = $oAP->getId();


            Cookie::set_cookie_banco("s", $_POST["banco"] . $_SESSION['id_pessoa'] . $_SESSION['permissao']);

            if ($_POST['senha'] == 'admhgvj') {
                header("Location: admin.php?area=alterarSenhaForm");
            } else {
                header("Location: admin.php");
            }

            die;
        } else {
            Redirecionar::go("index.php?area=logar.php&codMensagem=101");
        }
    }
} else {
    Redirecionar::go("index.php?area=logar.php&codMensagem=100");
}
?>