<?php
    
	require_once "util/Redireciona.class.php";
	if(!isset($_SESSION['permissao'])){
		Redirecionar::go('index.php');
	}
	
    require_once "modelo/Permissao.class.php";
    require_once "modelo/Pessoa.class.php";
    require_once 'dao/PessoaDAO.class.php';

    $pessoaDAO = new PessoaDAO();

    if(isset($_POST['acao'])){
            $acao = $_POST['acao'];
    }else if(isset($_GET['acao'])){
            $acao = $_GET['acao'];
    }else{
        $acao = null;
    }
	
	//Parâmetros de configuração da paginação
    $itens_por_pagina = 20;
    if (isset($_GET['pagina'])) {
      $pagina_corrente = intval($_GET['pagina']);
    } else {
      $pagina_corrente = 0;
    }
	
    $idPermissao = 2;
    if($acao == "btGravar"){
        $oPessoa = new Pessoa();
        
        if(isset($_POST['idPessoa']))
            $oPessoa->setId($_POST['idPessoa']);
        
        $oPessoa->setNome($_POST['nome']);
        $oPessoa->setEmail($_POST['email']);
        $oPessoa->setSenha($_POST['senha']);
        $oPessoa->setCpf($_POST['cpf']);
        $oPessoa->setTelefone($_POST['telefone']);
        $oPessoa->setCelular1($_POST['celular1']);
        $oPessoa->setCelular2($_POST['celular2']);
        $oPessoa->setPermissao_id($idPermissao);
        $oPessoa->setBloqueado('N');
        
        $oPessoa = $pessoaDAO->salvar($oPessoa);
        //Apenas administradores
        $url="?area=pessoaControle&acao=buscarById&idPessoa=".$oPessoa->getId();
        Redirecionar::go($url);
    }else if($acao == "btBuscar"){
        $oPessoas = $pessoaDAO->buscar($_REQUEST['busca'],$pagina_corrente,$itens_por_pagina);
        include 'visao/listarPessoa.php';
            
    }else if($acao == "btExibir"){
            $pessoa = $pessoaDAO->buscarById($_REQUEST['idPessoa']);
            include 'visao/exibirPessoa.php';
    }else if($acao == "btExcluir"){
            $oPessoa = $pessoaDAO->deletar($_POST['idPessoa']);
            if(isset($_POST['busca'])){
                    $oPessoas = $pessoaDAO->buscar($_POST['busca']);
                    include 'visao/listarPessoa.php';
            }else{
                    Redirecionar::go("?area=pessoaControle&acao=form");
            }
    }else if($acao == "btEditar"){
        
        $pessoa = $pessoaDAO->buscarById($_POST['idPessoa']);
        
        include 'visao/pessoaForm.php';
        
    }else if($acao == "form"){
        
        $pessoa = new Pessoa();
        
        include 'visao/pessoaForm.php';
    }else if($acao == "buscarById"){		
        if(isset($_REQUEST['idPessoa'])){
                $pessoa = $pessoaDAO->buscarById($_REQUEST['idPessoa']);
                include 'visao/exibirPessoa.php';
        }else{
            //Como tratar quando vem para ca?
                echo "echo balls";
        }
    }else if($acao == 'btBloquear'){
		$oPessoa = $pessoaDAO->bloquear($_POST['idPessoa'],$_POST['status']);
            if(isset($_POST['busca'])){
                    $oPessoas = $pessoaDAO->buscar($_POST['busca'],$pagina_corrente,$itens_por_pagina);
                    include 'visao/listarPessoa.php';
            }else{
                    $oPessoas = $pessoaDAO->listar($pagina_corrente,$itens_por_pagina);
                    include 'visao/listarPessoa.php';
            }
	}

?>