<div class="container">
    <div class="row">

        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading text-center"><h4>Nova(o) Secretária(o)</h4></div>
                <div class="panel-body">
                    <div class="row">
                        <!-- justified -->
                        <div class="col-md-6"></div>
                        <div class="col-md-offset-1 col-md-5 text-right">
                                <?php include 'buscar.php'; ?>
                        </div>
                    </div>
                    <form method="post" action="?area=secretariaControle" name="form" enctype="multipart/form-data" class="form-group">
                            <input type="hidden" name="idSecretaria" value="<?php echo $secretaria[0]->getPessoa_id() ?>" />
                            <fieldset>
                                    <legend>Dados pessoais</legend>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="col-md-offset-2 col-md-9 form-group">
                                                <label for="cpf">CPF: *</label><!-- id do input = cpf -->
                                                    <input type="text" autocomplete="off" onkeypress="MascaraCPF(form.cpf)" placeholder="Ex:000.000.000-00" id="cpf" required maxlength="14" class="form-control" value="<?= $secretaria[0]->getOPessoa()->getCpf() ?>" name="cpf">
                                            </div>
                                            <div id="divAjax">
                                                <div class="col-md-offset-2 col-md-9 form-group">
                                                    <label for="nome">Nome: *</label>
                                                    <input autocomplete="off" id="nome" class="form-control" value="<?php echo $secretaria[0]->getOPessoa()->getNome() ?>" name="nome" type="text">
                                                </div>
                                                <div class="col-md-offset-2 col-md-9 form-group">
                                                    <label for="conta">Telefone: *</label>
                                                    <input type="text" onkeypress="MascaraTelefone(form.telefone)" autocomplete="off" placeholder="Ex:(00)000000-0000" maxlength="14" id="telefone" class="form-control" value="<?php echo $secretaria[0]->getOPessoa()->getTelefone() ?>" name="telefone">
                                                </div>
                                                <div class="col-md-offset-2 col-md-9 form-group">
                                                    <label for="email">Email: *</label>
                                                    <input type="email" autocomplete="off" id="email" class="form-control" value="<?php echo $secretaria[0]->getOPessoa()->getEmail() ?>" name="email">
                                                </div>
                                                <div class="col-md-offset-2 col-md-9 form-group">
                                                    <label for="senha">Senha: *</label>
                                                    <input autocomplete="off" value="" id="senha" name="senha" type="password" required="True" maxlength="100" class="form-control"/>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-5 form-group">
                                            <label for="medico">Médicos que secretaria: *</label>
                                            <table class="table table-responsive table-striped">
                                                <thead>
                                                    <th>X</th>
                                                    <th>Médico</th>
                                                    
                                                </thead>
                                                <tbody>
                                                    <?php 
                                                foreach($oMedicos as $medico){
                                                ?>
                                                    <tr>
                                                        <td><input type="checkbox" <?php 
                                                            
                                                            foreach($secretaria as $obj){
                                                                if($obj->getMedico_id() == $medico->getPessoa_id()){
                                                                    echo "checked='true'";
                                                                }
                                                            }
                                                            
                                                        ?> name="medicos[]" value="<?php echo $medico->getPessoa_id(); ?>"></td>
                                                        <td><?php echo utf8_encode(utf8_decode($medico->getOPessoa()->getNome())); ?></td>
                                                    </tr>
                                                <?php
                                                }
                                                ?>
                                                </tbody>
                                            </table>
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