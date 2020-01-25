<?php
	require_once 'Loader.class.php';
    require_once 'util/Redireciona.class.php';

    $medicoDAO = new MedicoDAO();
    $agendaMedicaDAO = new AgendaMedicaDAO();
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
			$url="?area=agendaPacienteConsultaControle&acao=form&error=true";
			Redirecionar::go($url);
		}else{
			if(isset($_POST['idUsuarioExame']) && $_POST['idUsuarioExame'] != null){
				//Mensagem
				$url="?area=agendaPacienteConsultaControle&acao=form";
				Redirecionar::go($url);
			}
			
			$idPermissao = 1;
			$oAgendaPaciente = new AgendaPaciente();
			
			if(isset($_POST['idAgendaPacienteConsulta']))
				$oAgendaPaciente->setId($_POST['idAgendaPacienteConsulta']);
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
			$url="?area=agendaPacienteConsultaControle&acao=form&success=true";
			Redirecionar::go($url);
		}
    
	}else if($acao == "btBuscar"){
		
        $oAgendaPacienteConsultas = $agendaPacienteDAO->buscar($_POST['busca'],$pagina_corrente,$itens_por_pagina,'C');
        $arrayConsulta = $agendaMedicaDAO->listar();
        $arrayResult = Array();
        foreach($oAgendaPacienteConsultas as $agendaConsulta){
            foreach($arrayConsulta as $consulta){
                if($agendaConsulta->getOAgenda_horario()->getAgenda_id() == $consulta->getAgenda_id()){
                    $arrayResult[] = $agendaConsulta;
                }
            }
        }
        
        $oAgendaPacienteConsultas = $arrayResult;
        include 'visao/listarAgendaPacienteConsulta.php';
            
    }else if($acao == "btExibir"){
		
            $agendaPacienteConsulta = $agendaPacienteDAO->buscarById($_POST['idAgendaPacienteConsulta']);
			
            $vStatus = $agendaPacienteDAO->listarStatus();
            include 'visao/exibirAgendaPacienteConsulta.php';
    
	}else if($acao == "btExcluir"){
            $oAgendaPacienteConsulta = $agendaPacienteDAO->deletar($_POST['idAgendaPacienteConsulta']);
            if(isset($_POST['busca'])){
                    $oAgendaPacienteConsultas = $agendaPacienteDAO->listar($pagina_corrente,$itens_por_pagina,'C');
					$arrayConsulta = $agendaMedicaDAO->listar();
					$arrayResult = Array();
					foreach($oAgendaPacienteConsultas as $agendaConsulta){
						foreach($arrayConsulta as $consulta){
							if($agendaConsulta->getOAgenda_horario()->getAgenda_id() == $consulta->getAgenda_id()){
								$arrayResult[] = $agendaConsulta;
							}
						}
					}
					
					$oAgendaPacienteConsultas = $arrayResult;
                    include 'visao/listarAgendaPacienteConsulta.php';
            }else{
                    Redirecionar::go("?area=agendaPacienteConsultaControle&acao=form");
            }
    }else if($acao == "btEditar"){
        
        $agendaPacienteConsulta = $agendaPacienteDAO->buscarById($_POST['idAgendaPacienteConsulta']);
        $oEspecialidades = $medicoDAO->ListarEspecialidades();
        
        include 'visao/agendaPacienteConsultaForm.php';
        
    }else if($acao == "form"){
        
        //Lista apenas especialidades na qual há médicos registrados
        $oEspecialidades = $medicoDAO->ListarEspecialidades();
        
        $agendaPacienteConsulta = new AgendaPaciente();
        $agendaPacienteConsulta->setOPessoa(new Pessoa());

        include 'visao/agendaPacienteConsultaForm.php';
    }else if($acao == "buscarById"){
        if(isset($_REQUEST['idAgendaPacienteConsulta'])){
                $agendaPacienteConsulta = $agendaPacienteDAO->buscarById($_REQUEST['idAgendaPacienteConsulta']);
                $vStatus = $agendaPacienteDAO->listarStatus();
                include 'visao/exibirAgendaPacienteConsulta.php';
        }else{
            //Como tratar quando vem para ca?
                echo "echo balls";
        }
    }else if($acao == "btListar"){
		
        $oAgendaPacienteConsultas = $agendaPacienteDAO->listar($pagina_corrente,$itens_por_pagina,'C');
		
		$arrayConsulta = $agendaMedicaDAO->listar();
        $arrayResult = Array();
        foreach($oAgendaPacienteConsultas as $agendaConsulta){
            foreach($arrayConsulta as $consulta){
                if($agendaConsulta->getOAgenda_horario()->getAgenda_id() == $consulta->getAgenda_id()){
                    $arrayResult[] = $agendaConsulta;
                }
            }
        }
        
		//$medico = $medicoDAO->buscarById();
		
        $oAgendaPacienteConsultas = $arrayResult;
        
        include 'visao/listarAgendaPacienteConsulta.php';
    }else if($acao == "btStatus"){
        if($_REQUEST['status'] != null){
            $agendaPacienteDAO->mudarStatus($_REQUEST['idAgendaPacienteConsulta'],$_REQUEST['status']);
            $url="?area=agendaPacienteConsultaControle&acao=buscarById&idAgendaPacienteConsulta=".$_REQUEST['idAgendaPacienteConsulta'];
            Redirecionar::go($url);
        }else{
            $url="?area=agendaPacienteConsultaControle&acao=buscarById&idAgendaPacienteConsulta=".$_REQUEST['idAgendaPacienteConsulta'];
            Redirecionar::go($url);
        }
        
    }else if($acao == 'btMedico'){
		$secretariaDAO = new SecretariaDAO();
		$vSecretarias = $secretariaDAO->buscarById($_SESSION['id_pessoa']);
		include 'visao/selecionarMedico.php';
	}else if($acao == 'btAgenda'){
		
		if(isset($_GET['medic']) && $_GET['medic'] == true){
			$oAgendaPacienteConsultas = $agendaPacienteDAO->listarAgenda($pagina_corrente,$itens_por_pagina,$_SESSION['id_pessoa']);
		}else{
			$oAgendaPacienteConsultas = $agendaPacienteDAO->listarAgenda($pagina_corrente,$itens_por_pagina,$_REQUEST['idMedico']);
		}
		
		
		$arrayConsulta = $agendaMedicaDAO->listar();
        $arrayResult = Array();
        foreach($oAgendaPacienteConsultas as $agendaConsulta){
            foreach($arrayConsulta as $consulta){
                if($agendaConsulta->getOAgenda_horario()->getAgenda_id() == $consulta->getAgenda_id()){
                    $arrayResult[] = $agendaConsulta;
                }
            }
        }
        
        $oAgendaPacienteConsultas = $arrayResult;
        
        include 'visao/listarAgendaPacienteConsulta.php';
	}

?>