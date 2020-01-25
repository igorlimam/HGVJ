<?php
	require_once "util/Redireciona.class.php";
	if(!isset($_SESSION['permissao'])){
		Redirecionar::go('index.php');
	}
	
    require_once 'modelo/Permissao.class.php';
    require_once "modelo/Pessoa.class.php";
    require_once "modelo/Medico.class.php";
    require_once "modelo/Especialidade.class.php";
    require_once "dao/MedicoDAO.class.php";
    require_once 'dao/EspecialidadeDAO.class.php';
	

    $medicoDAO = new MedicoDAO();

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
        $oMedicos = $medicoDAO->buscar($_REQUEST['busca'],$pagina_corrente,$itens_por_pagina);
        include 'visao/listarMedico.php';
            
    }else if($acao == "btExibir"){
            $medico = $medicoDAO->buscarById($_REQUEST['idMedico']);
            $especialidades = $medicoDAO->ListarEspecialidades($medico->getPessoa_id());
            include 'visao/exibirMedico.php';
    }else if($acao == "buscarById"){		
        if(isset($_REQUEST['idMedico'])){
                $medico = $medicoDAO->buscarById($_REQUEST['idMedico']);
                $especialidades = $medicoDAO->ListarEspecialidades($medico->getPessoa_id());
                include 'visao/exibirMedico.php';
        }else{
            //Como tratar quando vem para ca?
                echo "echo balls";
        }
    }else if($acao == "btEditar"){
			
		$medico = $medicoDAO->buscarById($_POST['idMedico']);
		
		$especialidadeDAO = new EspecialidadeDAO();
		$espeialidades = $especialidadeDAO->listar();
		
		$especialidadeMedico = $medicoDAO->ListarEspecialidades($medico->getPessoa_id());
		
		include 'visao/medicoForm.php';
			
	}else if($_SESSION['permissao'] == "Administrador"){
		if($acao == "form"){
			
			$medico = new Medico();
			$medico->setOPessoa(new Pessoa());
			
			$especialidadeDAO = new EspecialidadeDAO();
			$espeialidades = $especialidadeDAO->listar();

			include 'visao/medicoForm.php';
		}else if($acao == "btExcluir"){
            $oMedico = $medicoDAO->deletar($_POST['idMedico']);
            if(isset($_POST['busca'])){
                    $oMedicos = $medicoDAO->buscar($_POST['busca']);
                    include 'visao/listarMedico.php';
            }else{
                    Redirecionar::go("?area=medicoControle&acao=form");
            }
		}else if($acao == "btGravar"){
			$idPermissao = 4;
			$oPessoa = new Pessoa();
			$oMedico = new Medico();

			if(isset($_POST['idMedico'])){
				$oMedico->setPessoa_id($_POST['idMedico']);
				$oPessoa->setId($_POST['idMedico']);
			}
			
			
			$oPessoa->setNome($_POST['nome']);
			$oPessoa->setEmail($_POST['email']);
			$oPessoa->setSenha($_POST['senha']);
			$oPessoa->setCpf($_POST['cpf']);
			$oPessoa->setTelefone($_POST['telefone']);
			$oPessoa->setNome($_POST['nome']);
			$oPessoa->setPermissao_id($idPermissao);
			$oPessoa->setBloqueado('N');
			
			$arrayEspecialidade = array();
			
			foreach($_POST['especialidades'] as $especialidade){
				$arrayEspecialidade[] = $especialidade;
			}

			$oMedico->setRegistro($_POST['registro']);
			$oMedico->setAtivo(1);
			$oMedico = $medicoDAO->salvar($oMedico,$oPessoa,$arrayEspecialidade);
			//Permissões e permissões
			$url="?area=medicoControle&acao=buscarById&idMedico=".$oMedico->getPessoa_id();
			Redirecionar::go($url);
		}else if($acao == "btStatus"){
			if($_REQUEST['status'] != null){
				$gold = $medicoDAO->mudarStatusMedico($_REQUEST['idMedico'],$_REQUEST['status']);
				$url="?area=medicoControle&acao=buscarById&idMedico=".$_REQUEST['idMedico'];
				Redirecionar::go($url);
			}else{
				$url="?area=medicoControle&acao=buscarById&idMedico=".$_REQUEST['idMedico'];
				Redirecionar::go($url);
			}
		}
	}else{
		Redirecionar::go('admin.php');
	}

?>