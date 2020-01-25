<?php
        
        require_once '../modelo/Pessoa.class.php';
        require_once '../modelo/Permissao.class.php';
	require_once '../dao/PessoaDAO.class.php';
        
        $pessoaDAO = new PessoaDAO();

	$result = $pessoaDAO->buscarById($_REQUEST['id']);
	if($result == null){ ?>
		
		<div class="row">
                    <div class="col-md-offset-1 col-md-5 form-group">
                        <label for="cpf">Nome: *</label>
                        <input autocomplete="off" id="nome" class="form-control" value="" name="nome">
                    </div>
                    <div class="col-md-5 form-group">
                        <label for="conta">Telefone: *</label>
                        <input onkeypress="MascaraTelefone(form.telefone)" autocomplete="off" placeholder="Ex:(00)000000-0000" maxlength="14" id="telefone" class="form-control" value="" name="telefone">
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-offset-1 col-md-5 form-group">
                        <label for="email">Email: *</label>
                        <input autocomplete="off" value="" id="email" name="email" type="email" required="True" maxlength="100" class="form-control"/>
                    </div>
                    <div class="col-md-5 form-group" style="margin-top:10px;">
                        <label class="control-label">Currículo: *</label>
                        <input id="upload" name="file" required type="file">
                    </div>
                </div>

	<?php }else{ ?>
		<div class="row">
                    <div class="col-md-offset-1 col-md-5 form-group">
                        <label for="cpf">Nome: *</label>
                        <input autocomplete="off" id="nome" class="form-control" value="<?php echo $result->getNome() ?>" name="nome">
                    </div>
                    <div class="col-md-5 form-group">
                        <label for="conta">Telefone: *</label>
                        <input onkeypress="MascaraTelefone(form.telefone)" autocomplete="off" placeholder="Ex:(00)000000-0000" maxlength="14" id="telefone" class="form-control" value="<?php echo $result->getTelefone() ?>" name="telefone">
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-offset-1 col-md-5 form-group">
                        <label for="email">Email: *</label>
                        <input autocomplete="off" value="<?php echo $result->getEmail() ?>" id="email" name="email" type="email" required="True" maxlength="100" class="form-control"/>
                    </div>
                    <div class="col-md-5 form-group" style="margin-top:10px;">
                        <label class="control-label">Currículo: *</label>
                        <input id="upload" name="file" required type="file">
                    </div>
                </div>
	<?php }

?>