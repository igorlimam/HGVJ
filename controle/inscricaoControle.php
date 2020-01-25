<?php
require_once "util/Redireciona.class.php";
require_once "Loader.class.php";

$pessoaDAO = new PessoaDAO();

if (isset($_POST['acao'])) {
    $acao = $_POST['acao'];
} else if (isset($_GET['acao'])) {
    $acao = $_GET['acao'];
} else {
    $acao = null;
}

//Parâmetros de configuração da paginação
$itens_por_pagina = 100;
if (isset($_GET['pagina'])) {
    $pagina_corrente = intval($_GET['pagina']);
} else {
    $pagina_corrente = 0;
}

if ($acao == "exibir") {
    $idCurriculo = explode('|', $_GET['re']);
    $idCurriculo = $idCurriculo[1];
    $curriculoDAO = new CurriculoDAO();
    $oCurriculo = $curriculoDAO->buscarById($idCurriculo);
    include 'visao/exibirInscricao.php';
} else if ($acao == "btReimprimir") {
    $curriculoDAO = new CurriculoDAO();
    $oCurriculo = $curriculoDAO->buscarByCpf($_POST['cpfP']);
    if (!$oCurriculo) {
        $url = "?area=inscricaoControle&acao=form&error=true&mensagem=1";
        Redirecionar::go($url);
    } else {
        $mensagem = 1;
        include 'visao/exibirInscricao.php';
    }
} else if ($acao == "btGravar") {
    if (isset($_SESSION['permissao']) && ($_SESSION['permissao'] == 'Administrador' || $_SESSION['permissao'] == 'Secretaria')) {
        if ($_POST['captcha_results'] != ($_POST['num1'] + $_POST['num2'])) {
            $url = "?area=inscricaoControle&acao=form&error=true";
            Redirecionar::go($url);
        } else {
            $idPermissao = 1;
            $oPessoa = new Pessoa();

            $oPessoa->setNome($_POST['nome']);
            $oPessoa->setEmail($_POST['email']);
            $oPessoa->setSenha("hgvjdemo");
            $oPessoa->setCpf($_POST['cpf']);
            $oPessoa->setTelefone($_POST['telefone']);
            $oPessoa->setPermissao_id($idPermissao);
            $oPessoa->setBloqueado('S');

            $oPessoa->setNascimento($_POST['nascimento']);
            $oPessoa->setConselho($_POST['conselho']);
            $oPessoa->setReservista($_POST['resevista']);
            $oPessoa->setOrgao_emissor($_POST['oe']);
            $oPessoa->setData_emissao($_POST['dataemissao']);
            $oPessoa->setRg($_POST['rg']);
            $oPessoa->setCelular3($_POST['celular3']);
            $oPessoa->setCelular2($_POST['celular2']);
            $oPessoa->setCelular1($_POST['celular1']);
            $oPessoa->setEstado($_POST['uf']);
            $oPessoa->setCidade($_POST['cidade']);
            $oPessoa->setCep($_POST['cep']);
            $oPessoa->setBairro($_POST['bairro']);
            $oPessoa->setComplemento($_POST['complemento']);
            $oPessoa->setNumero($_POST['numero']);
            $oPessoa->setLogradouro($_POST['logradouro']);
            $oPessoa->setMae($_POST['mae']);
            $oPessoa->setPai($_POST['pai']);
            $oPessoa->setNacionalidade($_POST['nacionalidade']);
            $oPessoa->setEstado_civil($_POST['civil']);
            $oPessoa->setConselho_numero($_POST['nconselho']);
            $oPessoa->setEmissor_ctps($_POST['emissor']);
            $oPessoa->setSerie($_POST['serie']);
            $oPessoa->setCtps($_POST['ctps']);

            $oCurriculo = new Curriculo();

            $oCurriculo->setArea_cargo_id($_POST['cargo']);
            //O timestamp não está funcionando bem, talvez por causa do fuso
            date_default_timezone_set('Brazil/East');
            $oCurriculo->setData_submissao(date('Y-m-d H-i-s', time()));
            $oCurriculo->setOPessoa($oPessoa);

            $curriculoDAO = new CurriculoDAO();
            $retorno = $curriculoDAO->salvarInscricao($oCurriculo);
            if ($retorno[2] == 1) {
                ?><div class="alert alert-danger" role="alert"><?php echo $retorno[0]; ?></div><?php
            } else {
                $url = "?area=inscricaoControle&acao=exibir&success=true&re=" . md5($oCurriculo->getId() . "hgvjlinkdesign") . "|" . $oCurriculo->getId() . "|" . md5("hgvjlinkdesign" . $oCurriculo->getId());
                Redirecionar::go($url);
            }
        }
    }
} else if ($acao == "form") {
    if (isset($_SESSION['permissao']) && ($_SESSION['permissao'] == 'Administrador' || $_SESSION['permissao'] == 'Secretaria')) {
        $oPessoa = new Pessoa();
        $cargoDao = new AreaCargoDAO();
        $cargos = $cargoDao->listar();

        require_once 'util/captcha.php';
        $num1 = create_captcha(1, 5);
        $num2 = create_captcha(1, 5);

        include 'visao/inscricaoForm.php';
    }
} else if ($acao == "btListar") {
    if (isset($_SESSION['permissao']) && ($_SESSION['permissao'] == 'Administrador' || $_SESSION['permissao'] == 'Secretaria')) {
        require_once 'dao/AreaCargoDAO.class.php';
        $areaCargoDAO = new AreaCargoDAO();
        $curriculoDAO = new CurriculoDAO();
        $areaCargos = $areaCargoDAO->listar();
        $oCurriculos = $curriculoDAO->listar($pagina_corrente, $itens_por_pagina);
        include 'visao/listarInscricao.php';
    }
} else if ($acao == "imprimirListar") {
    if (isset($_SESSION['permissao']) && ($_SESSION['permissao'] == 'Administrador' || $_SESSION['permissao'] == 'Secretaria')) {
        require_once 'dao/AreaCargoDAO.class.php';
        $areaCargoDAO = new AreaCargoDAO();
        $areaCargos = $areaCargoDAO->listar();
        $curriculoDAO = new CurriculoDAO();
        $dataI = $_POST['dataI'];
        $dataF = $_POST['dataF'];
        $cargo = $_POST['cargo_id'];
        $status = $_POST['status'];
        $oCurriculos = $curriculoDAO->buscarImprimir($dataI, $dataF, $cargo, $status);
        include 'visao/listarInscricaoImprimir.php';
    }
} else if ($acao == "btExibir") {
    if (isset($_SESSION['permissao']) && ($_SESSION['permissao'] == 'Administrador' || $_SESSION['permissao'] == 'Secretaria')) {
        $curriculoDAO = new CurriculoDAO();
        $oCurriculo = $curriculoDAO->buscarById($_POST['idCurriculo']);
        include 'visao/exibirInscricaoIn.php';
    }
} else if ($acao == "btBuscar") {
    if (isset($_SESSION['permissao']) && ($_SESSION['permissao'] == 'Administrador' || $_SESSION['permissao'] == 'Secretaria')) {
        require_once 'dao/AreaCargoDAO.class.php';
        $areaCargoDAO = new AreaCargoDAO();
        $areaCargos = $areaCargoDAO->listar();
        $curriculoDAO = new CurriculoDAO();
        $dataI = $_POST['dataI'];
        $dataF = $_POST['dataF'];
        $cargo = $_POST['cargo_id'];
        $status = $_POST['status'];
        $oCurriculos = $curriculoDAO->buscar($dataI, $dataF, $cargo, $status, $pagina_corrente, $itens_por_pagina);
        include 'visao/listarInscricao.php';
    }
} else if ($acao == "btExcluir") {
    if (isset($_SESSION['permissao']) && ($_SESSION['permissao'] == 'Administrador' || $_SESSION['permissao'] == 'Secretaria')) {
        $areaCargoDAO = new AreaCargoDAO();
        $curriculoDAO = new CurriculoDAO();
        $areaCargos = $areaCargoDAO->listar();
        $curriculo = $curriculoDAO->deletar($_POST['idCurriculo']);
        $oCurriculos = $curriculoDAO->listar($pagina_corrente, $itens_por_pagina);
        include 'visao/listarInscricao.php';
    }
}
?>