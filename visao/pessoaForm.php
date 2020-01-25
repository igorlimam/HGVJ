<script language="JavaScript" type="text/javascript" src="js/pessoa.js"></script>
<div class="container">
    <div class="row">

        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading text-center"><h4>Novo(a) Administrador(a)</h4></div>
                <div class="panel-body">
                    <div class="row">
                        <!-- justified -->
                        <div class="col-md-6"></div>
                        <div class="col-md-offset-1 col-md-5 text-right">
                                <?php include 'buscar.php'; ?>
                        </div>
                    </div>
                    <form method="post" action="?area=pessoaControle" name="form" enctype="multipart/form-data" class="form-group">
                            <input type="hidden" name="idPessoa" value="<?php echo $pessoa->getId() ?>" />
                            <fieldset>
                                    <legend>Dados pessoais</legend>
                                    <div class="row">
                                        <div class="col-md-offset-1 col-md-5 form-group">
                                            <label for="nome">Nome: *</label>
                                            <input autocomplete="off" required id="nome" class="form-control" value="<?php echo $pessoa->getNome() ?>" name="nome" type="text">
                                        </div>
                                        <div class="col-md-5 form-group">
                                            <label for="cpf">CPF: *</label>
                                            <input type="text" autocomplete="off" onkeypress="MascaraCPF(form.cpf)" placeholder="Ex:000.000.000-00" id="cpf" required maxlength="14" class="form-control" value="<?= $pessoa->getCpf() ?>" name="cpf">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-offset-1 col-md-5 form-group">
                                            <label for="email">Email: </label>
                                            <input autocomplete="off" id="email" class="form-control" value="<?php echo $pessoa->getEmail() ?>" name="email" type="text">
                                        </div>
                                        <div class="col-md-5 form-group">
                                            <label for="conta">Telefone: </label>
                                            <input type="text" onkeypress="MascaraTelefone(form.telefone)" autocomplete="off" placeholder="Ex:(00)000000-0000" maxlength="14" id="telefone" class="form-control" value="<?php echo $pessoa->getTelefone() ?>" name="telefone">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-offset-1 col-md-5 form-group">
                                            <label for="celular1">Celular Principal: </label>
                                            <input autocomplete="off" id="celular1" onkeypress="MascaraTelefone(form.celular1)" class="form-control" maxlength="14" value="<?php echo $pessoa->getCelular1() ?>" name="celular1" type="text">
                                        </div>
                                        <div class="col-md-5 form-group">
                                            <label for="celular2">Celular Secundário: </label>
                                            <input autocomplete="off" id="celular2" onkeypress="MascaraTelefone(form.celular2)" class="form-control" maxlength="14" value="<?php echo $pessoa->getCelular2() ?>" name="celular2" type="text">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-offset-1 col-md-5 form-group">
                                            <label for="senha">Senha: *</label>
                                            <input autocomplete="off" value="" id="senha" name="senha" type="password" required="True" maxlength="100" class="form-control"/>
                                        </div>
                                    </div>

                            </fieldset>

                            <div class="row">
                                    <div class="col-md-4 col-md-offset-4">
                                            <button value="btGravar" name="acao" title="Gravar" type="submit" style="margin-top:10px;" class="btn btn-success btn-lg btn-block">
                                                    <span class="glyphicon glyphicon-floppy-disk"></span> Gravar
                                            </button>
                                            <div id="msgCampoObrigatorio" class="text-center">
                                                    * Campos Obrigat&oacute;rios
                                            </div>
                                    </div>
                            </div>                
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>