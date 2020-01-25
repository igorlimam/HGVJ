<?php
require_once('Loader.class.php');
session_start();
if(Cookie::mudou_banco()){
    $_SESSION['logado'] = false;
}
if (!$_SESSION['logado']) {
    header("Location: logar.php");
    die;
} else
?>