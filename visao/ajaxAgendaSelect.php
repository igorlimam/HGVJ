<?php
        session_start();
		require_once "../Loader.class.php";
        require_once "../modelo/Pessoa.class.php";
        require_once "../modelo/Permissao.class.php";
        require_once "../dao/PessoaDAO.class.php";
        require_once '../dao/PermissaoDAO.class.php';
        require_once '../dao/MedicoDAO.class.php';
        require_once '../modelo/Medico.class.php';
        require_once '../modelo/MedicoEspecialidade.class.php';
        
        $medicoEspecialidade = new MedicoEspecialidade();
        $medicoDAO = new MedicoDAO();
        
		if(isset($_SESSION['permissao']) && $_SESSION['permissao'] == 'Secretaria'){
			//Objeto secretária
			$secretariaDAO = new SecretariaDAO();
			$secretaria = $secretariaDAO->buscarById($_SESSION['id_pessoa']);
			
			$medicoEspecialidade = $medicoDAO->buscarMedico($_REQUEST['id']);
			
			foreach($medicoEspecialidade as $especialidade){
				for($cont = 0; $cont < count($secretaria);++$cont){
					if($especialidade->getMedico_id() == $secretaria[$cont]->getMedico_id()){
						$arrayResult[] = $especialidade;
					}
				}
			}
			//Troca de Array
			$medicoEspecialidade = $arrayResult;
			
		
		}else if(isset($_SESSION['permissao']) && $_SESSION['permissao'] == 'Medico'){
			//Objeto medico
			$medico = $medicoDAO->buscarById($_SESSION['id_pessoa']);
			
			$medicoEspecialidade = $medicoDAO->buscarMedico($_REQUEST['id']);
			
			foreach($medicoEspecialidade as $especialidade){
				if($especialidade->getMedico_id() == $medico->getPessoa_id()){
					$arrayResult[] = $especialidade;
				}
			}
			//Troca de Array
			$medicoEspecialidade = $arrayResult;
			
		
		}else{
			$medicoEspecialidade = $medicoDAO->buscarMedico($_REQUEST['id']);
		}
		
        if(count($medicoEspecialidade) < 1){
            echo '<option selected="selected" value="">Selecione</option>';
        }else{
            ?> <option selected="selected" value="">Selecione</option> <?php
        foreach($medicoEspecialidade as $medico){
            
            ?>
        <option value="<?= $medico->getMedico_id() ?>"><?= $medico->getOMedico()->getOPessoa()->getNome() ?></option>  
        <?php }}
        ?>
            