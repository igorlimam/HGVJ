<?php

require_once "modelo/Pessoa.class.php";
require_once "modelo/Curriculo.class.php";
require_once "modelo/AreaCargo.class.php";
require_once "dao/CurriculoDAO.class.php";
require_once "util/Redireciona.class.php";

$curriculoDAO = new CurriculoDAO();

if (isset($_POST['acao'])) {
    $acao = $_POST['acao'];
} else if (isset($_GET['acao'])) {
    $acao = $_GET['acao'];
} else {
    $acao = null;
}

//Parâmetros de configuração da paginação
$itens_por_pagina = 20;
if (isset($_GET['pagina'])) {
    $pagina_corrente = intval($_GET['pagina']);
} else {
    $pagina_corrente = 0;
}

if ($acao == "btGravar") {

    if ($_POST['captcha_results'] != ($_POST['num1'] + $_POST['num2'])) {
        $url = "?area=curriculoControle&acao=form&error=true";
        Redirecionar::go($url);
    } else {

        if (isset($_POST['idUsuarioExame']) && $_POST['idUsuarioExame'] != null) {
            //Mensagem
            $url = "?area=curriculoControle&acao=form";
            Redirecionar::go($url);
        }

        $idPermissao = 1;
        $oPessoa = new Pessoa();
        $oCurriculo = new Curriculo();

        if (isset($_POST['idCurriculo']))
            $oCurriculo->setId($_POST['idCurriculo']);

        $oPessoa->setNome($_POST['nome']);
        $oPessoa->setEmail($_POST['email']);
        $oPessoa->setCpf($_POST['cpf']);
        $oPessoa->setTelefone($_POST['telefone']);
        $oPessoa->setNome($_POST['nome']);
        $oPessoa->setPermissao_id($idPermissao);
        $oPessoa->setBloqueado('S');

        $file = $_FILES['file'];

        $oCurriculo->setArea_cargo_id($_POST['cargo_id']);
        //O timestamp não está funcionando bem, talvez por causa do fuso
        date_default_timezone_set('Brazil/East');
        $oCurriculo->setData_submissao(date('Y-m-d H-i-s', time()));

        $curriculoDAO->salvar($oCurriculo, $oPessoa, $file);
        //Permissões e permissões
        $url = "?area=curriculoControle&acao=form&success=true";
        Redirecionar::go($url);
    }
}else if ($acao == "form") {

    $curriculo = new Curriculo();
    $curriculo->setOPessoa(new Pessoa());

    require_once 'dao/AreaCargoDAO.class.php';
    $areaCargoDAO = new AreaCargoDAO();
    $areaCargos = $areaCargoDAO->listar();

    include 'visao/curriculoForm.php';
} else if (isset($_SESSION['permissao'])) {
    if ($acao == "btBuscar") {

        require_once 'dao/AreaCargoDAO.class.php';
        $areaCargoDAO = new AreaCargoDAO();
        $areaCargos = $areaCargoDAO->listar();

        $dataI = $_POST['dataI'];
        $dataF = $_POST['dataF'];
        $cargo = $_POST['cargo_id'];
        $status = $_POST['status'];
        $oCurriculos = $curriculoDAO->buscar($dataI, $dataF, $cargo, $status, $pagina_corrente, $itens_por_pagina);
        include 'visao/listarCurriculo.php';
    } else if ($acao == "btExibir") {
        require_once 'dao/AreaCargoDAO.class.php';
        $areaCargoDAO = new AreaCargoDAO();
        $areaCargos = $areaCargoDAO->listar();
        $curriculo = $curriculoDAO->buscarById($_POST['idCurriculo']);
        include 'visao/exibirCurriculo.php';
    } else if ($acao == "btExcluir") {
        $curriculo = $curriculoDAO->deletar($_POST['idCurriculo']);
        $oCurriculos = $curriculoDAO->listar($pagina_corrente, $itens_por_pagina);
        include 'visao/listarCurriculo.php';
    } else if ($acao == "btEditar") {

        $curriculo = $curriculoDAO->buscarById($_POST['idCurriculo']);
        require_once 'dao/AreaCargoDAO.class.php';
        $areaCargoDAO = new AreaCargoDAO();
        $areaCargos = $areaCargoDAO->listar();
        include 'visao/curriculoForm.php';
    } else if ($acao == "buscarById") {
        if (isset($_REQUEST['idCurriculo'])) {
            $curriculo = $curriculoDAO->buscarById($_REQUEST['idCurriculo']);
            include 'visao/exibirCurriculo.php';
        } else {
            echo "echo balls";
        }
    } else if ($acao == "btListar") {
        require_once 'dao/AreaCargoDAO.class.php';
        $areaCargoDAO = new AreaCargoDAO();
        $areaCargos = $areaCargoDAO->listar();
        $oCurriculos = $curriculoDAO->listar($pagina_corrente, $itens_por_pagina);
        include 'visao/listarCurriculo.php';
    } else if ($acao == "btStatus") {
        if ($_REQUEST['status'] != null) {
            $curriculoDAO->mudarStatus($_REQUEST['idCurriculo'], $_REQUEST['status']);
            $url = "?area=curriculoControle&acao=buscarById&idCurriculo=" . $_REQUEST['idCurriculo'];
            Redirecionar::go($url);
        } else {
            $url = "?area=curriculoControle&acao=buscarById&idCurriculo=" . $_REQUEST['idCurriculo'];
            Redirecionar::go($url);
        }
    }
} else {
    Redirecionar::go('index.php');
}
?>