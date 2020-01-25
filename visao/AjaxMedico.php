<?php
        
        require_once "../modelo/Pessoa.class.php";
        require_once "../modelo/Permissao.class.php";
        require_once "../dao/PessoaDAO.class.php";
        require_once '../dao/PermissaoDAO.class.php';
        
        $pessoaDAO = new PessoaDAO();
        if($_REQUEST['cpf'] == ""){
            $_REQUEST['cpf'] = "*********************";
        }
        $result = $pessoaDAO->buscar($_REQUEST['cpf'],1);
	if($result != null){ ?>
            <div class="alert alert-danger" role="alert">
             <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
             <span class="sr-only">Erro:</span>
              &nbsp;CPF já cadastrado
           </div>
        <?php }else{ ?>
<div></div>
       <?php } 
?>