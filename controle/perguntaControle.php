<?php
    require_once "modelo/Pergunta.class.php";
    require_once "modelo/PerguntaCategoria.class.php";
    require_once 'dao/PerguntaDAO.class.php';
    require_once "util/Redireciona.class.php";

    $perguntaDAO = new PerguntaDAO();

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
        $oPerguntas = $perguntaDAO->buscar($_POST['busca'],$pagina_corrente,$itens_por_pagina);
        include 'visao/listarPergunta.php';
    }else if($acao == "btExibir"){
            $pergunta = $perguntaDAO->buscarById($_REQUEST['idPergunta']);
            include 'visao/exibirPergunta.php';
    }else if($acao == "buscarById"){		
        if(isset($_REQUEST['idPergunta'])){
                $pergunta = $perguntaDAO->buscarById($_REQUEST['idPergunta']);
                include 'visao/exibirPergunta.php';
        }else{
            //Como tratar quando vem para ca?
                echo "echo balls";
        }
    }else if($acao == "btListar"){		
        $oPerguntas = $perguntaDAO->listar($pagina_corrente,$itens_por_pagina);
        include 'visao/listarPergunta.php';
    }else if(isset($_SESSION['permissao']) && $_SESSION['permissao'] == 'Administrador'){  //Apenas em seção
		if($acao == "btGravar"){
			$oPergunta = new Pergunta();

			if(isset($_POST['idPergunta']))
				$oPergunta->setId($_POST['idPergunta']);
			
			$oPergunta->setPergunta_categoria_id($_POST['categoria_id']);
			$oPergunta->setDescricao($_POST['descricao']);
			$oPergunta->setResposta($_POST['resposta']);
			
			$oPergunta = $perguntaDAO->salvar($oPergunta);
			$url="?area=perguntaControle&acao=buscarById&idPergunta=".$oPergunta->getId();
			Redirecionar::go($url);
		}else if($acao == "form"){
			
			$pergunta = new Pergunta();
			$arrayCategoria = $perguntaDAO->listarCategoria();
			
			include 'visao/perguntaForm.php';
		}else if($acao == "btEditar"){
			
			$pergunta = $perguntaDAO->buscarById($_POST['idPergunta']);
			
			$arrayCategoria = $perguntaDAO->listarCategoria();
			
			include 'visao/perguntaForm.php';
			
		}else if($acao == "btExcluir"){
				$oPergunta = $perguntaDAO->deletar($_POST['idPergunta']);
				if(isset($_POST['busca'])){
						$oPerguntas = $perguntaDAO->buscar($_POST['busca']);
						include 'visao/listarPergunta.php';
				}else{
						Redirecionar::go("?area=perguntaControle&acao=form");
				}
		}
	}else{
		Redirecionar::go('admin.php');
	}

?>
