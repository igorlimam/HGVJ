<?php

session_start();
require_once('Loader.class.php');
require_once "util/Redireciona.class.php";
$_SESSION['logado'] = false;
$_SESSION = array();
Cookie::destroy_cookie("s");
session_destroy();
Redirecionar::go("index.php");
die;
?>