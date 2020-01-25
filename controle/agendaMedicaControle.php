<?php
	require_once "util/Redireciona.class.php";
	if(!isset($_SESSION['permissao'])){
		Redirecionar::go('index.php');
	}
	
	require_once 'Loader.class.php';
    require_once 'modelo/Agenda.class.php';
    require_once "modelo/AgendaMedica.class.php";
    require_once 'modelo/Pessoa.class.php';
    require_once 'modelo/Local.class.php';
    require_once 'modelo/Permissao.class.php';
    require_once 'dao/PessoaDAO.class.php';
    require_once "modelo/Medico.class.php";
    require_once "modelo/Especialidade.class.php";
    require_once "dao/MedicoDAO.class.php";
    require_once 'dao/EspecialidadeDAO.class.php';
    require_once 'modelo/AgendaHorario.class.php';
    require_once 'dao/AgendaMedicaDAO.class.php';
    
    $medicoDAO = new MedicoDAO();
    $especialidadeDAO = new EspecialidadeDAO();
    $agendaMedicaDAO = new AgendaMedicaDAO();

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
        $oAgendaMedica = new AgendaMedica();
        $oAgendaMedica->setOAgenda(new Agenda());
        $oAgendaMedica->setMedico_id($_POST['medico_id']);
        $oAgendaMedica->getOAgenda()->setDia_semana($_POST['diaSemana_id']);
        $oAgendaMedica->getOAgenda()->setAtivo(1);
        $oAgendaMedica->getOAgenda()->setLocal_id($_POST['local_id']);
          
        if(isset($_POST['idAgendaMedica']))
            $oAgendaMedica->setAgenda_id($_POST['idAgendaMedica']);
        
        $oAgendaMedica = $agendaMedicaDAO->salvar($oAgendaMedica);
        //Permissões e permissões
        $url="?area=agendaMedicaControle&acao=buscarById&idAgendaMedica=".$oAgendaMedica->getOAgenda()->getId();
        Redirecionar::go($url);
    }else if($acao == "btBuscar"){
		if(isset($_SESSION['permissao']) && $_SESSION['permissao'] == 'Secretaria'){
			//Objeto secretária
			$secretariaDAO = new SecretariaDAO();
			$secretaria = $secretariaDAO->buscarById($_SESSION['id_pessoa']);
			
			//Objeto Agenda Médica
			$oAgendasMedica = $agendaMedicaDAO->buscar($_REQUEST['busca'],$pagina_corrente,$itens_por_pagina);
			$arrayResult = Array();
			
			foreach($oAgendasMedica as $agendaMedica){
				for($cont = 0; $cont < count($secretaria);++$cont){
					if($agendaMedica->getOMedico()->getPessoa_id() == $secretaria[$cont]->getMedico_id()){
						$arrayResult[] = $agendaMedica;
					}
				}
			}
			//Troca de Array
			$oAgendasMedica = $arrayResult;
			
		
		}else if(isset($_SESSION['permissao']) && $_SESSION['permissao'] == 'Medico'){
			//Objeto medico
			$medico = $medicoDAO->buscarById($_SESSION['id_pessoa']);
			
			//Objeto Agenda Médica
			$oAgendasMedica = $agendaMedicaDAO->buscar($_REQUEST['busca'],$pagina_corrente,$itens_por_pagina);
			$arrayResult = Array();
			
			foreach($oAgendasMedica as $agendaMedica){
				if($agendaMedica->getOMedico()->getPessoa_id() == $medico->getPessoa_id()){
					$arrayResult[] = $agendaMedica;
				}
			}
			//Troca de Array
			$oAgendasMedica = $arrayResult;
			
		
		}else{
			$oAgendasMedica = $agendaMedicaDAO->buscar($_REQUEST['busca'],$pagina_corrente,$itens_por_pagina);
		}
		
        include 'visao/listarAgendaMedica.php';
            
    }else if($acao == "btExibir"){
            $agendaMedica = $agendaMedicaDAO->buscarById($_REQUEST['idAgendaMedica']);
            $vHorarios = $agendaMedicaDAO->listarHorarios($_REQUEST['idAgendaMedica']);
			
			
			
            include 'visao/exibirAgendaMedica.php';
    }else if($acao == "btExcluir"){
            $oAgendaMedica = $agendaMedicaDAO->deletar($_POST['idAgendaMedica']);
            if(isset($_POST['busca'])){
                    $oAgendasMedica = $agendaMedicaDAO->buscar($_POST['busca']);
                    include 'visao/listarAgendaMedica.php';
            }else{
                    Redirecionar::go("?area=agendaMedicaControle&acao=form");
            }
    }else if($acao == "btEditar"){
        
        $agendaMedica = $agendaMedicaDAO->buscarById($_POST['idAgendaMedica']);
        //Lista apenas especialidades na qual há médicos registrados
        $oEspecialidades = $medicoDAO->ListarEspecialidades();
        
        $oLocais = $agendaMedicaDAO->ListarLocais();
        
        include 'visao/agendaMedicaForm.php';
        
    }else if($acao == "form"){
        
		if(isset($_SESSION['permissao']) && $_SESSION['permissao'] == 'Secretaria'){
			
			//Objeto secretária
			$secretariaDAO = new SecretariaDAO();
			$secretaria = $secretariaDAO->buscarById($_SESSION['id_pessoa']);
			
			//Lista apenas especialidades na qual há médicos registrados
			$oEspecialidades = $medicoDAO->ListarEspecialidades();
			
		}else if(isset($_SESSION['permissao']) && $_SESSION['permissao'] == 'Medico'){
			
			//Lista apenas especialidades na qual há médicos registrados
			$oEspecialidades = $medicoDAO->ListarEspecialidades($_SESSION['id_pessoa']);
			
		}else{
			//Lista apenas especialidades na qual há médicos registrados
			$oEspecialidades = $medicoDAO->ListarEspecialidades();
		}
		
        
        
        $oLocais = $agendaMedicaDAO->ListarLocais();
        
        $agendaMedica = new AgendaMedica();
        $agendaMedica->setOMedico(new Medico());
        $agendaMedica->setOAgenda(new Agenda());

        include 'visao/agendaMedicaForm.php';
    }else if($acao == "buscarById"){		
        if(isset($_REQUEST['idAgendaMedica'])){
            
                $agendaMedica = $agendaMedicaDAO->buscarById($_REQUEST['idAgendaMedica']);
                $vHorarios = $agendaMedicaDAO->listarHorarios($_REQUEST['idAgendaMedica']);
                include 'visao/exibirAgendaMedica.php';
        }else{
            //Como tratar quando vem para ca?
                echo "echo balls";
        }
    }else if($acao == "btAtivar"){		
        
        if($_POST['ativo'] == 1){
            $agendaMedicaDAO->mudarStatus($_POST['idAgendaMedica'],$_POST['ativo']);
        }else{
            $agendaMedicaDAO->mudarStatus($_POST['idAgendaMedica'],$_POST['ativo']);
        }
        $url="?area=agendaMedicaControle&acao=btBuscar&busca=";
        Redirecionar::go($url);
    }else if($acao == "btAtivarHr"){		
        
        if($_POST['ativo'] == 1){
            $agendaMedicaDAO->mudarStatusHorario($_POST['idAgendaHorario'],$_POST['ativo']);
        }else{
            $agendaMedicaDAO->mudarStatusHorario($_POST['idAgendaHorario'],$_POST['ativo']);
        }
        $url="?area=agendaMedicaControle&acao=btExibir&idAgendaMedica=".$_POST['idAgendaMedica'];
        Redirecionar::go($url);
    }

?>