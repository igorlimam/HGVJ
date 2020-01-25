<?php
    require_once 'modelo/Permissao.class.php';
    require_once "modelo/Pessoa.class.php";
    require_once "modelo/Noticia.class.php";
    require_once 'dao/NoticiaDAO.class.php';
    require_once "util/Redireciona.class.php";

    $noticiaDAO = new NoticiaDAO();

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
	
    if($acao == "btGravar"){
		if(!isset($_SESSION['permissao']) && $_SESSION['permissao'] == 'Administrador'){
			Redirecionar::go('admin.php');
		}
        $oNoticia = new Noticia();

        if(isset($_POST['idNoticia']))
            $oNoticia->setId($_POST['idNoticia']);
        
        $oNoticia->setTitulo($_POST['titulo']);
        $oNoticia->setConteudo($_POST['conteudo']);
        $oNoticia->setFonte($_POST['fonte']);
        $oNoticia->setUsuario_id($_POST['usuario_id']);
        
        date_default_timezone_set('Brazil/East');
        $oNoticia->setData(date('Y-m-d H-i-s',time()));
        $oNoticia->setAtivo($_POST['ativo']);
        
        $oNoticia = $noticiaDAO->salvar($oNoticia);
        $url="?area=noticiaControle&acao=buscarById&idNoticia=".$oNoticia->getId();
        Redirecionar::go($url);
    }else if($acao == "btBuscar"){
        @$oNoticias = $noticiaDAO->buscar($_REQUEST['busca'],$pagina_corrente,$itens_por_pagina);
        include 'visao/listarNoticia.php';
    }else if($acao == "btExibir"){
            $noticia = $noticiaDAO->buscarById($_REQUEST['idNoticia']);
            include 'visao/exibirNoticia.php';
    }else if($acao == "btExcluir"){
		
		if(!isset($_SESSION['permissao']) && $_SESSION['permissao'] == 'Administrador'){
			Redirecionar::go('admin.php');
		}
		
		$oNoticia = $noticiaDAO->deletar($_POST['idNoticia']);
		if(isset($_POST['busca'])){
				$oNoticias = $noticiaDAO->buscar($_POST['busca']);
				include 'visao/listarNoticia.php';
		}else{
				Redirecionar::go("?area=noticiaControle&acao=form");
		}
    }else if($acao == "btEditar"){
        
		if(!isset($_SESSION['permissao']) && $_SESSION['permissao'] == 'Administrador'){
			Redirecionar::go('admin.php');
		}
		
        $noticia = $noticiaDAO->buscarById($_POST['idNoticia']);
        
        require_once 'dao/PessoaDAO.class.php';
        $pessoaDAO = new PessoaDAO();
        
        $autores = array();
        
        foreach($pessoaDAO->listar() as $oPessoa){
            if($oPessoa->getPermissao_id() == 2){
                $autores[$oPessoa->getId()] = $oPessoa->getNome();
            }
        }
        
        include 'visao/noticiaForm.php';
        
    }else if($acao == "form"){
        
		if(!isset($_SESSION['permissao']) && $_SESSION['permissao'] == 'Administrador'){
			Redirecionar::go('admin.php');
		}
		
        $noticia = new Noticia();
        $noticia->setOUsuario(new Pessoa());
        
        require_once 'dao/PessoaDAO.class.php';
        $pessoaDAO = new PessoaDAO();
        
        $autores = array();
        
        foreach($pessoaDAO->listar() as $oPessoa){
            if($oPessoa->getPermissao_id() == 2){
                $autores[$oPessoa->getId()] = $oPessoa->getNome();
            }
        }
        
        include 'visao/noticiaForm.php';
    }else if($acao == "buscarById"){		
        if(isset($_REQUEST['idNoticia'])){
                $noticia = $noticiaDAO->buscarById($_REQUEST['idNoticia']);
                include 'visao/exibirNoticia.php';
        }else{
            //Como tratar quando vem para ca?
                echo "echo balls";
        }
    }else if($acao == "btListar"){		
        $oNoticias = $noticiaDAO->listar($pagina_corrente,$itens_por_pagina);
        include 'visao/listarNoticia.php';
    }else if($acao == "btAtivar"){
        $uhu = $noticiaDAO->mudarStatus($_POST['idNoticia'],$_POST['ativo']);
        $url="?area=noticiaControle&acao=btBuscar&busca=";
        Redirecionar::go($url);
    }

?>
