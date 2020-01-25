<?php
    require_once 'Loader.class.php';
    require_once 'util/Redireciona.class.php';

    $agendaExameDAO = new AgendaExameDAO();
    $agendaPacienteDAO = new AgendaPacienteDAO();

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
        $oPessoa = new Pessoa();
        
        if ($_POST['captcha_results'] != ($_POST['num1'] + $_POST['num2'])) {
			$url="?area=agendaPacienteExameControle&acao=form&error=true";
			Redirecionar::go($url);
		}else{
        
			if(isset($_POST['idUsuarioExame']) && $_POST['idUsuarioExame'] != null){
				//Mensagem
				$url="?area=agendaPacienteExameControle&acao=form";
				Redirecionar::go($url);
			}
			
			$idPermissao = 1;
			$oAgendaPaciente = new AgendaPaciente();
			
			if(isset($_POST['idAgendaPacienteExame']))
				$oAgendaPaciente->setId($_POST['idAgendaPacienteExame']);
			if(isset($_POST['idCpf']) && $_POST['idCpf'] != null){
				$oPessoa->setId($_POST['idCpf']);
			}
			
			
			$oPessoa->setNome($_POST['nome']);
			$oPessoa->setEmail($_POST['email']);
			$oPessoa->setCpf($_POST['cpf']);
			$oPessoa->setTelefone($_POST['telefone']);
			$oPessoa->setPermissao_id($idPermissao);
			$oPessoa->setBloqueado('S');
			
			$arrayDiaAgenda = explode(",",$_POST['dia']);
			
			$oAgendaPaciente->setData(date('Y',$_POST['mes']).'-'.date('m',$_POST['mes']).'-'.$arrayDiaAgenda[0]);
			$oAgendaPaciente->setData_pedido(date('Y-m-d H-i-s',strtotime($_POST['dateUser'])));
			$oAgendaPaciente->setData_status(date('Y-m-d H-i-s',strtotime($_POST['dateUser'])));
			$oAgendaPaciente->setAgenda_horario_id($_POST['horario']);
			$oAgendaPaciente->setAgenda_status_id(1);
			
			
			$oAgendaPaciente = $agendaPacienteDAO->salvar($oAgendaPaciente,$oPessoa);
			//Permissões e permissões
			$url="?area=agendaPacienteExameControle&acao=form&success=true";
			Redirecionar::go($url);
		}
    }else if($acao == "btBuscar"){
        
        $oAgendaPacienteExames = $agendaPacienteDAO->buscar($_POST['busca'],$pagina_corrente,$itens_por_pagina,'E');
        $arrayExame = $agendaExameDAO->listar();
        $arrayResult = Array();
        foreach($oAgendaPacienteExames as $agendaExame){
            foreach($arrayExame as $exame){
                if($agendaExame->getOAgenda_horario()->getAgenda_id() == $exame->getAgenda_id()){
                    $arrayResult[] = $agendaExame;
                }
            }
        }
        $oAgendaPacienteExames = $arrayResult;
        include 'visao/listarAgendaPacienteExame.php';
            
    }else if($acao == "btExibir"){
            $agendaPacienteExame = $agendaPacienteDAO->buscarById($_POST['idAgendaPacienteExame']);
            $vStatus = $agendaPacienteDAO->listarStatus();
            include 'visao/exibirAgendaPacienteExame.php';
    }else if($acao == "btExcluir"){
            $oAgendaPacienteExame = $agendaPacienteDAO->deletar($_POST['idAgendaPacienteExame']);
            if(isset($_POST['busca'])){
                    $oAgendaPacienteExames = $agendaPacienteDAO->listar($pagina_corrente,$itens_por_pagina,'E');
					$arrayExame = $agendaExameDAO->listar();
					$arrayResult = Array();
					foreach($oAgendaPacienteExames as $agendaExame){
						foreach($arrayExame as $exame){
							if($agendaExame->getOAgenda_horario()->getAgenda_id() == $exame->getAgenda_id()){
								$arrayResult[] = $agendaExame;
							}
						}
					}
					$oAgendaPacienteExames = $arrayResult;
                    include 'visao/listarAgendaPacienteExame.php';
            }else{
                    Redirecionar::go("?area=agendaPacienteExameControle&acao=form");
            }
    }else if($acao == "btEditar"){
        
        $agendaPacienteExame = $agendaPacienteDAO->buscarById($_POST['idAgendaPacienteExame']);
        $oExames = $agendaExameDAO->listarExames();
        
        include 'visao/agendaPacienteExameForm.php';
        
    }else if($acao == "form"){
        
        //Lista apenas exame no qual há médicos registrados
        $oExames = $agendaExameDAO->listarExames();
        
        $agendaPacienteExame = new AgendaPaciente();
        $agendaPacienteExame->setOPessoa(new Pessoa());

        include 'visao/agendaPacienteExameForm.php';
    }else if($acao == "buscarById"){
        if(isset($_REQUEST['idAgendaPacienteExame'])){
                $agendaPacienteExame = $agendaPacienteDAO->buscarById($_REQUEST['idAgendaPacienteExame']);
                $vStatus = $agendaPacienteDAO->listarStatus();
                include 'visao/exibirAgendaPacienteExame.php';
        }else{
            //Como tratar quando vem para ca?
                echo "echo balls";
        }
    }else if($acao == "btListar"){
        $oAgendaPacienteExames = $agendaPacienteDAO->listar($pagina_corrente,$itens_por_pagina,'E');
        $arrayExame = $agendaExameDAO->listar();
        $arrayResult = Array();
        
        foreach($oAgendaPacienteExames as $agendaExame){
            foreach($arrayExame as $exame){
                if($agendaExame->getOAgenda_horario()->getAgenda_id() == $exame->getAgenda_id()){
                    $arrayResult[] = $agendaExame;
                }
            }
        }
        $oAgendaPacienteExames = $arrayResult;
        
        include 'visao/listarAgendaPacienteExame.php';
    }else if($acao == "btStatus"){
        if($_REQUEST['status'] != null){
            $agendaPacienteDAO->mudarStatus($_REQUEST['idAgendaPacienteExame'],$_REQUEST['status']);
            $url="?area=agendaPacienteExameControle&acao=buscarById&idAgendaPacienteExame=".$_REQUEST['idAgendaPacienteExame'];
            Redirecionar::go($url);
        }else{
            $url="?area=agendaPacienteExameControle&acao=buscarById&idAgendaPacienteExame=".$_REQUEST['idAgendaPacienteExame'];
            Redirecionar::go($url);
        }
        
    }

?>