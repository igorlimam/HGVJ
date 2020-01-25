<div class="container">
    <div class="row">

        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading text-center"><h4>Processo Seletivo</h4></div>
                <div class="panel-body">

                    <?php if (isset($_GET['mensagem']) == 1) { ?>
                        <div class="alert alert-success alert-dismissible" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <strong>CPF não inscrito!</strong> Verifique se digitou corretamente.
                        </div>
                    <?php } ?>

                    <form method="post" action="?area=inscricaoControle" name="form" enctype="multipart/form-data" class="form-group">
                        <fieldset>
                            <legend class="text-right">Reimprimir Fcha de Inscrição</legend>                             
                            <div class="row">
                                <div class="col-md-12 col-md-offset-7">
                                    <div class="col-md-3 form-group">
                                        <label for="cpfP">CPF: *</label>
                                        <input type="text" autocomplete="off" onkeypress="MascaraCPF(form.cpfP)" placeholder="Ex:000.000.000-00" id="cpfP" required maxlength="14" class="form-control" value="" name="cpfP">
                                    </div>
                                    <div class="col-md-2 form-group">
                                        <label>&nbsp;</label>
                                        <button value="btReimprimir" name="acao" title="Gravar" type="submit" class="btn btn-success form-control">
                                            <span class="glyphicon glyphicon-floppy-disk"></span> Pesquisar
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </fieldset>
                    </form>


                    <h3 class="text-center">ANEXO V</h3>
                    <h3 class="text-center">FICHA DE INSCRIÇÃO</h3>

                    <form method="post" action="?area=inscricaoControle" name="form" enctype="multipart/form-data" class="form-group">

                        <fieldset>
                            <legend>Dados pessoais</legend>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="col-md-9 form-group">
                                        <label for="nome">Nome: *</label>
                                        <input id="nome" class="form-control" value="<?php echo $oPessoa->getNome() ?>" name="nome" type="text" required="true">
                                    </div>
                                    <div class="col-md-3 form-group">
                                        <label for="nascimento">Data de Nascimento: *</label>
                                        <input value="<?php echo $oPessoa->getNascimento(); ?>" required="true" autocomplete="off" class="form-control" name="nascimento" type="date" id="nascimento">
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label for="civil">Estado Civil: *</label>
                                        <select required="true" class="form-control" name="civil" id="civil">
                                            <option value="">Selecione</option>
                                            <option value="Solteiro">Solteiro</option>
                                            <option value="Casado">Casado</option>
                                            <option value="Outros">Outros</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label for="nacionalidade">Nacionalidade: *</label>
                                        <input required="true" value="<?php echo $oPessoa->getNacionalidade(); ?>" name="nacionalidade" id="nacionalidade" class="form-control" type="text">
                                    </div>
                                </div>
                            </div>
                        </fieldset>

                        <fieldset>
                            <legend>Filiação</legend>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="col-md-6 form-group">
                                        <label for="pai">Pai: </label>
                                        <input type="text" maxlength="100" class="form-control" value="<?php echo $oPessoa->getPai(); ?>" name="pai" id="pai">
                                    </div>

                                    <div class="col-md-6 form-group">
                                        <label for="mae">Mãe: *</label>
                                        <input type="text" required maxlength="100" class="form-control" value="<?php echo $oPessoa->getMae(); ?>" name="mae" id="mae">
                                    </div>  
                                </div>
                            </div>
                        </fieldset>

                        <fieldset>
                            <legend>Endereço</legend>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="col-md-9 form-group">
                                        <label for="logradouro">Logradouro: *</label>
                                        <input required="true" id="logradouro" class="form-control" value="<?php echo $oPessoa->getLogradouro() ?>" name="logradouro" type="text">
                                    </div>
                                    <div class="col-md-3 form-group">
                                        <label for="numero">Número: *</label>
                                        <input required="true" value="<?php echo $oPessoa->getNumero() ?>" name="numero" id="numero" class="form-control" type="text">
                                    </div>
                                    <div class="col-md-3 form-group">
                                        <label for="complemento">Complemento: </label>
                                        <input value="<?php echo $oPessoa->getComplemento(); ?>" name="complemento" id="complemento" class="form-control" type="text">
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label for="bairro">Bairro: *</label>
                                        <input required="true" value="<?php echo $oPessoa->getBairro(); ?>" name="bairro" id="bairro" class="form-control" type="text">
                                    </div>
                                    <div class="col-md-3 form-group">
                                        <label for="cep">CEP: *</label>
                                        <input required="true" value="<?php echo $oPessoa->getCep(); ?>" name="cep" id="cep" class="form-control" type="text">
                                    </div>

                                    <div class="col-md-7 form-group">
                                        <label for="cidade">Cidade: *</label>
                                        <input required="true" value="<?php echo $oPessoa->getCidade(); ?>" name="cidade" id="cidade" class="form-control" type="text">
                                    </div>
                                    <div class="col-md-5 form-group">
                                        <label for="uf">UF: *</label>
                                        <input required="true" value="<?php echo $oPessoa->getEstado(); ?>" name="uf" id="uf" class="form-control" type="text">
                                    </div>                                    
                                </div>
                            </div>
                        </fieldset>

                        <fieldset>
                            <legend>Contato</legend>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="col-md-3 form-group">
                                        <label for="telefone">Telefone:</label>
                                        <input type="text" autocomplete="off" placeholder="Ex:(00)0000-0000" maxlength="14" id="telefone" class="form-control" value="<?php echo $oPessoa->getTelefone(); ?>" name="telefone">
                                    </div>
                                    <div class="col-md-3 form-group">
                                        <label for="celular1">Celular 1: *</label>
                                        <input required="true" type="text" onkeypress="MascaraTelefone(form.telefone)" autocomplete="off" placeholder="Ex:(00)00000-0000" maxlength="14" class="form-control" value="<?php echo $oPessoa->getCelular1() ?>" name="celular1" id="celular1">
                                    </div>
                                    <div class="col-md-3 form-group">
                                        <label for="celular2">Celular 2:</label>
                                        <input type="text" onkeypress="MascaraTelefone(form.telefone)" autocomplete="off" placeholder="Ex:(00)00000-0000" maxlength="14" class="form-control" value="<?php echo $oPessoa->getCelular2() ?>" name="celular2" id="celular2">
                                    </div>
                                    <div class="col-md-3 form-group">
                                        <label for="celular3">Celular 3:</label>
                                        <input type="text" onkeypress="MascaraTelefone(form.telefone)" autocomplete="off" placeholder="Ex:(00)00000-0000" maxlength="14" class="form-control" value="<?php echo $oPessoa->getCelular3() ?>" name="celular3" id="celular3">
                                    </div>
                                    <div class="col-md-12 form-group">
                                        <label for="email">Email:</label>
                                        <input type="email" autocomplete="off" id="email" class="form-control" value="<?php echo $oPessoa->getEmail() ?>" name="email">
                                    </div>                           
                                </div>
                            </div>
                        </fieldset>

                        <fieldset>
                            <legend>Documentação</legend>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="col-md-4 form-group">
                                        <label for="rg">RG: *</label>
                                        <input id="rg" value="<?php echo $oPessoa->getRg(); ?>" name="rg" type="text" class="form-control" required="true">
                                    </div>
                                    <div class="col-md-4 form-group">
                                        <label for="dataemissao">Data de Emissão: *</label>
                                        <input value="<?php echo $oPessoa->getData_emissao(); ?>" required="true" autocomplete="off" class="form-control" name="dataemissao" type="date" id="dataemissao">
                                    </div>
                                    <div class="col-md-4 form-group">
                                        <label for="oe">Órgão Emissor: *</label>
                                        <input required="true" id="oe" value="<?php echo $oPessoa->getOrgao_emissor(); ?>" name="oe" type="text" class="form-control">
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label for="cpf">CPF: *</label>
                                        <input type="text" autocomplete="off" onkeypress="MascaraCPF(form.cpf)" placeholder="Ex:000.000.000-00" id="cpf" required maxlength="14" class="form-control" value="<?php echo $oPessoa->getCpf(); ?>" name="cpf">
                                    </div>                     
                                    <div class="col-md-6 form-group">
                                        <label for="resevista">Resevista:</label>
                                        <input type="text" id="resevista" maxlength="24" class="form-control" value="<?php echo $oPessoa->getReservista(); ?>" name="resevista">
                                    </div>
                                    <div class="col-md-8 form-group">
                                        <label for="conselho">Conselho: </label>
                                        <input type="text" id="conselho" class="form-control" value="<?php echo $oPessoa->getConselho(); ?>" name="conselho">
                                    </div>
                                    <div class="col-md-4 form-group">
                                        <label for="nconselho">Número: </label>
                                        <input type="text" id="nconselho" class="form-control" value="<?php echo $oPessoa->getConselho_numero(); ?>" name="nconselho">
                                    </div>

                                    <div class="col-md-4 form-group">
                                        <label for="ctps">CTPS: *</label>
                                        <input id="ctps" value="<?php echo $oPessoa->getCtps(); ?>" required="true" name="ctps" type="text" class="form-control">
                                    </div>
                                    <div class="col-md-4 form-group">
                                        <label for="serie">Série: *</label>
                                        <input id="serie" value="<?php echo $oPessoa->getSerie(); ?>" required="true" name="serie" type="text" class="form-control">
                                    </div>
                                    <div class="col-md-4 form-group">
                                        <label for="emissor">Emissor: *</label>
                                        <input required="true" id="emissor" value="<?php echo $oPessoa->getEmissor_ctps(); ?>" name="emissor" type="text" class="form-control">
                                    </div>
                                </div>
                            </div>
                        </fieldset>

                        <fieldset>
                            <legend>Seleção</legend>
                            <div class="row">
                                <div class="col-md-12">

                                    <div class="col-md-8 form-group">
                                        <label for="cargo">Cargo Escolhido: *</label>
                                        <select required="true" class="form-control" name="cargo" id="cargo">
                                            <option value="">Selecione</option>
                                            <?php foreach ($cargos as $cargo) { ?>
                                                <option value="<?php echo $cargo->getId(); ?>"><?php echo utf8_encode($cargo->getNome()); ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </fieldset>

                        <div class="row text-center">
                            <div class="col-md-4 col-md-offset-4">
                                <label><?php echo "Quanto é " . $num1 . ' + ' . $num2 . ' ? '; ?></label>
                                <input autocomplete="off" type="text" required="true" name="captcha_results" size="4">
                                <input type="hidden" name='num1' value='<?php echo $num1; ?>'>
                                <input type="hidden" name='num2' value='<?php echo $num2; ?>'>

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