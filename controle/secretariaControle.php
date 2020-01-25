<?php
    require_once "util/Redireciona.class.php";
	if(!isset($_SESSION['permissao'])){
		Redirecionar::go('index.php');
	}
	
    require_once 'modelo/Permissao.class.php';
    require_once "modelo/Pessoa.class.php";
    require_once "modelo/Medico.class.php";
    require_once "modelo/Secretaria.class.php";
    require_once "dao/MedicoDAO.class.php";
    require_once 'dao/PessoaDAO.class.php';
    require_once 'dao/SecretariaDAO.class.php';

    $secretariaDAO = new SecretariaDAO();

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
        $oSecretarias = $secretariaDAO->buscar($_REQUEST['busca'],$pagina_corrente,$itens_por_pagina);
        include 'visao/listarSecretaria.php';
            
    }else if($acao == "btExibir"){
		$secretaria = $secretariaDAO->buscarById($_REQUEST['idSecretaria']);
		include 'visao/exibirSecretaria.php';
	}else if($acao == "buscarById"){		
        if(isset($_REQUEST['idSecretaria'])){
                $secretaria = $secretariaDAO->buscarById($_REQUEST['idSecretaria']);
                include 'visao/exibirSecretaria.php';
        }else{
            //Como tratar quando vem para ca?
                echo "echo balls";
        }
    }else if($acao == "btEditar"){
			
		$secretaria = $secretariaDAO->buscarById($_POST['idSecretaria']);
		
		$medicoDAO = new MedicoDAO();
		$oMedicos = $medicoDAO->listar();
		
		include 'visao/secretariaForm.php';
			
	}else if($_SESSION['permissao'] == 'Administrador'){
		if($acao == "btGravar"){
			$idPermissao = 3;
			$oPessoa = new Pessoa();
			$oSecretaria = new Secretaria();

			if(isset($_POST['idSecretaria']))
				$oPessoa->setId($_POST['idSecretaria']);
			
			$oPessoa->setNome($_POST['nome']);
			$oPessoa->setEmail($_POST['email']);
			$oPessoa->setSenha($_POST['senha']);
			$oPessoa->setCpf($_POST['cpf']);
			$oPessoa->setTelefone($_POST['telefone']);
			$oPessoa->setNome($_POST['nome']);
			$oPessoa->setPermissao_id($idPermissao);
			$oPessoa->setBloqueado('N');
			
			$arrayMedico = array();
			
			foreach($_POST['medicos'] as $medico){
				$arrayMedico[] = $medico;
			}
			
			$oSecretaria = $secretariaDAO->salvar($oPessoa,$arrayMedico);
			//Permissões e permissões
			$url="?area=secretariaControle&acao=buscarById&idSecretaria=".$oPessoa->getId();
			Redirecionar::go($url);
		}else if($acao == "btExcluir"){
				$oSecretaria = $secretariaDAO->deletar($_POST['idSecretaria']);
				if(isset($_POST['busca'])){
						$oSecretarias = $secretariaDAO->buscar($_POST['busca']);
						include 'visao/listarSecreteraria.php';
				}else{
						Redirecionar::go("?area=SecretariaControle&acao=form");
				}
		}else if($acao == "form"){
			$secretaria = Array();
			$oSecretaria = new Secretaria();
			$oSecretaria->setOPessoa(new Pessoa());
			$oSecretaria->setOMedico(new Medico());
			
			$secretaria[] = $oSecretaria;
			$medicoDAO = new MedicoDAO();
			$oMedicos = $medicoDAO->listar();
			
			include 'visao/secretariaForm.php';
		}else if($acao == "btStatus"){
			if($_REQUEST['status'] != null){
				$gold = $secretariaDAO->mudarStatusSecretaria($_REQUEST['idSecretaria'],$_REQUEST['status']);
				$url="?area=secretariaControle&acao=buscarById&idSecretaria=".$_REQUEST['idSecretaria'];
				Redirecionar::go($url);
			}else{
				$url="?area=secretariaControle&acao=buscarById&idSecretaria=".$_REQUEST['idSecretaria'];
				Redirecionar::go($url);
			}
		}
	}else{
		Redirecionar::go('admin.php');
	}

?>