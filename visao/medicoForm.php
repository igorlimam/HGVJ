<div class="container">
    <div class="row">

        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading text-center"><h4>Nova(o) Médica(o)</h4></div>
                <div class="panel-body">
                    <div class="row">
                        <!-- justified -->
                        <div class="col-md-6"></div>
                        <div class="col-md-offset-1 col-md-5 text-right">
                                <?php include 'buscar.php'; ?>
                        </div>
                    </div>
                    <form method="post" action="?area=medicoControle" name="form" enctype="multipart/form-data" class="form-group">
                            <input type="hidden" name="idMedico" value="<?= $medico->getPessoa_id() ?>" />
                            <fieldset>
                                <legend>Dados pessoais</legend>
                                <div class="row" id="divAjax">
                                    <div class="col-md-6">
                                        <div class="row">
                                            <div class="col-md-offset-2 col-md-9 form-group">
                                                <label for="cpf">CPF: *</label>
                                                    <input autocomplete="off" onkeypress="MascaraCPF(form.cpf)" placeholder="Ex:000.000.000-00" id="cpf" required maxlength="14" class="form-control" value="<?= $medico->getOPessoa()->getCpf() ?>" name="cpf">
                                            </div>
                                            <div class="col-md-1"></div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-offset-2 col-md-9 form-group">
                                                <label for="nome">Nome: *</label>
                                                <input autocomplete="off" id="nome" class="form-control" value="<?php echo $medico->getOPessoa()->getNome() ?>" name="nome">
                                            </div>
                                            <div class="col-md-1"></div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-offset-2 col-md-9 form-group">
                                                <label for="conta">Telefone: *</label>
                                                <input onkeypress="MascaraTelefone(form.telefone)" autocomplete="off" placeholder="Ex:(00)000000-0000" maxlength="14" id="telefone" class="form-control" value="<?php echo $medico->getOPessoa()->getTelefone() ?>" name="telefone">
                                            </div>
                                            <div class="col-md-1"></div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-offset-2 col-md-9 form-group">
                                                <label for="email">Email: *</label>
                                                <input autocomplete="off" value="<?php echo $medico->getOPessoa()->getEmail() ?>" id="email" name="email" type="email" required="True" maxlength="100" class="form-control"/>
                                            </div>
                                            <div class="col-md-1"></div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-offset-2 col-md-5 form-group">
                                                <label for="registro">Registro: *</label>
                                                <input autocomplete="off" value="<?php echo $medico->getRegistro() ?>" id="registro" name="registro" type="text" required="True" maxlength="45" class="form-control"/>
                                                <div class="col-md-1"></div>
                                            </div>
                                            <div class="col-md-4 form-group">
                                                <label for="senha">Senha: *</label>
                                                <input autocomplete="off" value="" id="senha" name="senha" type="password" required="True" maxlength="100" class="form-control"/>
                                            </div>
                                            <div class="col-md-1"></div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="col-md-12 form-group">
                                            <label for="conta">Especialidades: *</label><br>
                                            <table class="table table-striped">
                                                <thead>
                                                    <th>X</th>
                                                    <th>Especialidade</th>
                                                </thead>
                                                <tbody>
                                                <?php 
                                                foreach($espeialidades as $oEspecialidade){
                                                ?>
                                                    <tr>
                                                        <td><input type="checkbox" <?php 
                                                        
                                                            if(isset($especialidadeMedico)){
                                                                foreach($especialidadeMedico as $espMedico){
                                                                    if($oEspecialidade->getId() == $espMedico->getEspecialidade_id()){
                                                                        echo "checked";
                                                                    }
                                                                }
                                                            }
                                                        
                                                        ?> name="especialidades[]" value="<?php echo $oEspecialidade->getId(); ?>"></td>
                                                        <td><?php echo utf8_encode($oEspecialidade->getNome()); ?></td>
                                                    </tr>
                                                <?php
                                                }
                                                ?>
                                                </tbody>
                                            </table>
                                        </div>
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