<?php
    require_once 'modelo/Agenda.class.php';
    require_once "modelo/AgendaExame.class.php";
    require_once 'modelo/Exame.class.php';
    require_once 'modelo/Local.class.php';
    require_once 'modelo/ExameCategoria.class.php';
    require_once 'dao/ExameDAO.class.php';
    require_once 'modelo/AgendaHorario.class.php';
    require_once 'dao/AgendaExameDAO.class.php';
    require_once "util/Redireciona.class.php";
    
    $exameDAO = new ExameDAO();
    $agendaExameDAO = new AgendaExameDAO();

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
        $oAgendaExame = new AgendaExame();
        $oAgendaExame->setOAgenda(new Agenda());
        $oAgendaExame->setExame_id($_POST['exame_id']);
        $oAgendaExame->getOAgenda()->setDia_semana($_POST['diaSemana_id']);
        $oAgendaExame->getOAgenda()->setAtivo(1);
        $oAgendaExame->getOAgenda()->setLocal_id($_POST['local_id']);
          
        if(isset($_POST['idAgendaExame']))
            $oAgendaExame->setAgenda_id($_POST['idAgendaExame']);
        
        $oAgendaExame = $agendaExameDAO->salvar($oAgendaExame);
        //Permissões e permissões
        $url="?area=agendaExameControle&acao=buscarById&idAgendaExame=".$oAgendaExame->getOAgenda()->getId();
        Redirecionar::go($url);
    }else if($acao == "btBuscar"){
        $oAgendasExame = $agendaExameDAO->buscar($_REQUEST['busca'],$pagina_corrente,$itens_por_pagina);
        include 'visao/listarAgendaExame.php';
            
    }else if($acao == "btExibir"){
            $agendaExame = $agendaExameDAO->buscarById($_REQUEST['idAgendaExame']);
            $vHorarios = $agendaExameDAO->listarHorarios($_REQUEST['idAgendaExame']);
            include 'visao/exibirAgendaExame.php';
    }else if($acao == "btExcluir"){
            $oAgendaExame = $agendaExameDAO->deletar($_POST['idAgendaExame']);
            if(isset($_POST['busca'])){
                    $oAgendasExame = $agendaExameDAO->buscar($_POST['busca']);
                    include 'visao/listarAgendaExame.php';
            }else{
                    Redirecionar::go("?area=agendaExameControle&acao=form");
            }
    }else if($acao == "btEditar"){
        
        $agendaExame = $agendaExameDAO->buscarById($_POST['idAgendaExame']);
        
        $oCategorias = $exameDAO->listarCategoria();
        
        $oLocais = $agendaExameDAO->ListarLocais();
        
        include 'visao/agendaExameForm.php';
        
    }else if($acao == "form"){
        
        $oCategorias = $exameDAO->listarCategoria();
        
        $oLocais = $agendaExameDAO->ListarLocais();
        
        $agendaExame = new AgendaExame();
        $agendaExame->setOExame(new Exame());
        $agendaExame->setOAgenda(new Agenda());

        include 'visao/agendaExameForm.php';
    }else if($acao == "buscarById"){		
        if(isset($_REQUEST['idAgendaExame'])){
            
                $agendaExame = $agendaExameDAO->buscarById($_REQUEST['idAgendaExame']);
                $vHorarios = $agendaExameDAO->listarHorarios($_REQUEST['idAgendaExame']);
                include 'visao/exibirAgendaExame.php';
        }else{
            //Como tratar quando vem para ca?
                echo "echo balls";
        }
    }else if($acao == "btAtivar"){		
        
        if($_POST['ativo'] == 1){
            $agendaExameDAO->mudarStatus($_POST['idAgendaExame'],$_POST['ativo']);
        }else{
            $agendaExameDAO->mudarStatus($_POST['idAgendaExame'],$_POST['ativo']);
        }
        $url="?area=agendaExameControle&acao=btBuscar&busca=";
        Redirecionar::go($url);
    }else if($acao == "btAtivarHr"){		
        
        if($_POST['ativo'] == 1){
            $agendaExameDAO->mudarStatusHorario($_POST['idAgendaHorario'],$_POST['ativo']);
        }else{
            $agendaExameDAO->mudarStatusHorario($_POST['idAgendaHorario'],$_POST['ativo']);
        }
        $url="?area=agendaExameControle&acao=btExibir&idAgendaExame=".$_POST['idAgendaExame'];
        Redirecionar::go($url);
    }

?>