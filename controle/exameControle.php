<?php
    require_once "modelo/Exame.class.php";
    require_once "modelo/ExameCategoria.class.php";
    require_once "dao/ExameDAO.class.php";
    require_once "util/Redireciona.class.php";

    $exameDAO = new ExameDAO();

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
	
    if($acao == "btBuscar"){
        $oExames = $exameDAO->buscar($_REQUEST['busca'],$pagina_corrente,$itens_por_pagina);
        include 'visao/listarExame.php';
            
    }else if($acao == "btExibir"){
            $exame = $exameDAO->buscarById($_POST['idExame']);
            include 'visao/exibirExame.php';
    }else if($acao == "buscarById"){		
        if(isset($_REQUEST['idExame'])){
                $exame = $exameDAO->buscarById($_REQUEST['idExame']);
                include 'visao/exibirExame.php';
        }else{
            //Como tratar quando vem para ca?
                echo "echo balls";
        }
    }else if($acao == "btListar"){
        $oExames = $exameDAO->listar($pagina_corrente,$itens_por_pagina);
        include 'visao/listarUsuarioExame.php';
            
    }else if($acao == "btBuscar2"){
        $oExames = $exameDAO->buscar($_REQUEST['busca'],$pagina_corrente,$itens_por_pagina);
        include 'visao/listarUsuarioExame.php';
            
    }else if(isset($_SESSION['permissao'])){//Apenas em seção
		
		if($acao == "btGravar"){
			$oExame = new Exame();

			if(isset($_POST['idExame']))
				$oExame->setId($_POST['idExame']);
			
			$oExame->setNome($_POST['nome']);
			$oExame->setAtivo($_POST['ativo']);
			$oExame->setExame_categoria_id($_POST['categoria_id']);
			
			$oExame = $exameDAO->salvar($oExame);
			//Permissões e permissões
			$url="?area=exameControle&acao=buscarById&idExame=".$oExame->getId();
			Redirecionar::go($url);
		}else if($acao == "btExcluir"){
            $oExame = $ExameDAO->deletar($_POST['idExame']);
            if(isset($_POST['busca'])){
                    $oExames = $exameDAO->buscar($_POST['busca']);
                    include 'visao/listarExame.php';
            }else{
                    Redirecionar::go("?area=exameControle&acao=form");
            }
		}else if($acao == "btEditar"){
			
			$exame = $exameDAO->buscarById($_POST['idExame']);
			
			$arrayCategoria = $exameDAO->listarCategoria();
			
			include 'visao/exameForm.php';
			
		}else if($acao == "form"){
			
			$exame = new Exame();
			$arrayCategoria = $exameDAO->listarCategoria();
			
			include 'visao/exameForm.php';
		}
	}else{
		Redirecionar::go('index.php');
	}

?>