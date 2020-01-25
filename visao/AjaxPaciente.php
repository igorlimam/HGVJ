<?php
        
        require_once '../modelo/Pessoa.class.php';
        require_once '../modelo/Permissao.class.php';
	require_once '../dao/PessoaDAO.class.php';
        
        $pessoaDAO = new PessoaDAO();
        
	$result = $pessoaDAO->buscarById($_REQUEST['id']);
	if($result == null){ ?>

		<div class="row">
                    <div class="col-md-offset-1 col-md-5 form-group">
                        <label for="cpf">CPF: *</label>
                        <div class="input-group">
                            <div class="input-group-addon"><span title="Campo de busca auto completável" class="glyphicon glyphicon-option-horizontal" aria-hidden="true"></span></div>
                            <input autocomplete="off" onkeypress="MascaraCPF(form.cpf)" placeholder="Ex:000.000.000-00" id="cpf" required maxlength="14" class="form-control" value="<?php echo $_REQUEST['cpf'] ?>" name="cpf" onkeyup="autoComplete(this.value,'PessoaDAO','buscar','idCpf','cpf','Cpf')" onblur="paciente('idCpf','divAjax',this.value)">
                            <input id="idCpf" name="idCpf" hidden="true" value="">
                        </div>
                    </div>
                    <div class="col-md-5 form-group">
                        <label for="nome">Nome: *</label>
                        <input autocomplete="off" id="nome" class="form-control" value="" name="nome">
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-offset-1 col-md-5 form-group">
                        <label for="email">Email: </label>
                        <input autocomplete="off" value="" id="email" name="email" type="email" maxlength="100" class="form-control"/>
                    </div>
                    <div class="col-md-5 form-group">
                        <label for="telefone">Telefone: </label>
                        <input onkeypress="MascaraTelefone(form.telefone)" autocomplete="off" placeholder="Ex:(00)000000-0000" maxlength="14" id="telefone" class="form-control" value="" name="telefone">
                    </div>
                </div>

	<?php }else{ ?>
		<div class="row">
                    <div class="col-md-offset-1 col-md-5 form-group">
                        <label for="cpf">CPF: *</label>
                        <div class="input-group">
                            <div class="input-group-addon"><span title="Campo de busca auto completável" class="glyphicon glyphicon-option-horizontal" aria-hidden="true"></span></div>
                            <input autocomplete="off" onkeypress="MascaraCPF(form.cpf)" placeholder="Ex:000.000.000-00" id="cpf" required maxlength="14" class="form-control" value="<?= $result->getCpf() ?>" name="cpf" onkeyup="autoComplete(this.value,'PessoaDAO','buscar','idCpf','cpf','Cpf')" onblur="paciente('idCpf','divAjax',this.value)">
                            <input id="idCpf" name="idCpf" hidden="true" value="<?= $result->getId() ?>">
                        </div>
                    </div>
                    <div class="col-md-5 form-group">
                        <label for="nome">Nome: *</label>
                        <input readonly autocomplete="off" id="nome" class="form-control" value="<?php echo $result->getNome() ?>" name="nome">
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-offset-1 col-md-5 form-group">
                        <label for="email">Email: </label>
                        <input autocomplete="off" value="<?php echo $result->getEmail() ?>" id="email" name="email" type="email" maxlength="100" class="form-control"/>
                    </div>
                    <div class="col-md-5 form-group">
                        <label for="telefone">Telefone: </label>
                        <input onkeypress="MascaraTelefone(form.telefone)" autocomplete="off" placeholder="Ex:(00)000000-0000" maxlength="14" id="telefone" class="form-control" value="<?php echo $result->getTelefone() ?>" name="telefone">
                    </div>
                </div>
	<?php }

?>