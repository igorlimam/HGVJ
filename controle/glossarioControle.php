<?php
    require_once "modelo/Glossario.class.php";
    require_once "modelo/GlossarioCategoria.class.php";
    require_once 'dao/GlossarioDAO.class.php';
    require_once "util/Redireciona.class.php";

    $glossarioDAO = new GlossarioDAO();

    if(isset($_POST['acao'])){
            $acao = $_POST['acao'];
    }else if(isset($_GET['acao'])){
            $acao = $_GET['acao'];
    }else{
        $acao = null;
    }

    if($acao == "btBuscar"){
        $oGlossarios = $glossarioDAO->buscar($_POST['busca']);
		$oCategorias = $glossarioDAO->listarCategoria();
        include 'visao/listarGlossario.php';
    }else if($acao == "btExibir"){
            $glossario = $glossarioDAO->buscarById($_REQUEST['idGlossario']);
            include 'visao/exibirGlossario.php';
    }else if($acao == "buscarById"){		
        if(isset($_REQUEST['idGlossario'])){
                $glossario = $glossarioDAO->buscarById($_REQUEST['idGlossario']);
                include 'visao/exibirGlossario.php';
        }else{
            //Como tratar quando vem para ca?
                echo "echo balls";
        }
    }else if($acao == "btListar"){
		if(isset($_GET['categoria']) && !is_null($_GET['categoria'])){
			$oGlossarios = $glossarioDAO->listar($_GET['categoria']);
		}else{
			$oGlossarios = $glossarioDAO->listar(1);
		}
		$oCategorias = $glossarioDAO->listarCategoria();
        include 'visao/listarGlossario.php';
    }else if(isset($_SESSION['permissao'])){ //Apenas seção
		
		if($acao == "btGravar"){
			$oGlossario = new Glossario();

			if(isset($_POST['idGlossario']))
				$oGlossario->setId($_POST['idGlossario']);
			
			$oGlossario->setGlossario_categoria_id($_POST['categoria_id']);
			$oGlossario->setDescricao($_POST['descricao']);
			$oGlossario->setTitulo($_POST['titulo']);
			
			$oGlossario = $glossarioDAO->salvar($oGlossario);
			$url="?area=glossarioControle&acao=buscarById&idGlossario=".$oGlossario->getId();
			Redirecionar::go($url);
		}else if($acao == "btExcluir"){
			$oGlossario = $glossarioDAO->deletar($_POST['idGlossario']);
			if(isset($_POST['busca'])){
				$oGlossarios = $glossarioDAO->buscar($_POST['busca']);
				include 'visao/listarGlossario.php';
			}else{
				Redirecionar::go("?area=glossarioControle&acao=form");
			}
		}else if($acao == "btEditar"){
			
			$glossario = $glossarioDAO->buscarById($_POST['idGlossario']);
			
			$arrayCategoria = $glossarioDAO->listarTodasCategorias();
			
			include 'visao/glossarioForm.php';
			
		}else if($acao == "form"){
			
			$glossario = new Glossario();
			$arrayCategoria = $glossarioDAO->listarTodasCategorias();
			
			include 'visao/glossarioForm.php';
		}
	}else{
		Redirecionar::go('index.php');
	}

?>
