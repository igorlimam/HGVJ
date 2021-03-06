<div class="container-fluid">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading text-center"><h4>Secretária(o)</h4></div>
                <div class="panel-body">
                    <div class="row">
                            <div class="col-md-6">
                                <!-- barra de botoes -->

                                <table>
                                    <tr>
										<?php if($_SESSION['permissao'] == 'Administrador'){ ?>
                                        <td>
                                            <form method="post" action="?area=secretariaControle" class="form-group">
                                                <div class="input-group">
                                                    <span class="input-group-btn">
                                                        <button class="btn btn-default btn-block" type="submit" name="acao" value="form">
                                                            <span class="glyphicon glyphicon-file"></span> Novo
                                                        </button>
                                                    </span>
                                                </div>
                                            </form>
                                        </td>
										<td>
                                            <form method="post" action="?area=secretariaControle" class="form-group">
                                                <div class="input-group">
                                                    <span class="input-group-btn btn-block">
                                                        <input type="hidden" name="idSecretaria" value="<?php echo $secretaria[0]->getOPessoa()->getId(); ?>" />
                                                        <button class="btn btn-default" type="submit" name="acao" value="btExcluir">
                                                            <span class="glyphicon glyphicon-trash"></span> Excluir
                                                        </button>
                                                    </span>
                                                </div>
                                            </form>
                                        </td>
										<?php if($secretaria[0]->getAtivo() == 1){ ?>
												<td>
													<form method="post" action="?area=secretariaControle" class="form-group">
														<div class="input-group">
															<span class="input-group-btn btn-block">
																<input type="hidden" name="idSecretaria" value="<?php echo $secretaria[0]->getPessoa_id(); ?>" />
																<input type="hidden" name="status" value="0" />
																<button class="btn btn-default" type="submit" name="acao" value="btStatus">
																	<span class="glyphicon glyphicon-ban-circle"></span> Desativar
																</button>
															</span>
														</div>
													</form>
												</td>
											<?php }else{ ?>
												<td>
													<form method="post" action="?area=secretariaControle" class="form-group">
														<div class="input-group">
															<span class="input-group-btn btn-block">
																<input type="hidden" name="idSecretaria" value="<?php echo $secretaria[0]->getPessoa_id(); ?>" />
																<input type="hidden" name="status" value="1" />
																<button class="btn btn-default" type="submit" name="acao" value="btStatus">
																	<span class="glyphicon glyphicon-ok-circle"></span> Ativar
																</button>
															</span>
														</div>
													</form>
												</td>
											<?php } ?>
										<?php } ?>
										<?php if($_SESSION['permissao'] == 'Administrador' || ($_SESSION['permissao'] == 'Secretaria' && $secretaria[0]->getPessoa_id() == $_SESSION['id_pessoa'])){ ?>
                                        <td>
                                            <form method="post" action="?area=secretariaControle" class="form-group">
                                                <div class="input-group">
                                                    <span class="input-group-btn">
                                                        <input type="hidden" name="idSecretaria" value="<?php echo $secretaria[0]->getOPessoa()->getId(); ?>" />
                                                        <button class="btn btn-default btn-block" type="submit" name="acao" value="btEditar">
                                                            <span class="glyphicon glyphicon-edit"></span> Editar
                                                        </button>
                                                    </span>
                                                </div>
                                            </form>
                                        </td>
										<?php } ?>
                                    </tr>
                                </table>
                            </div>
                            <div class="col-md-6 text-right">
                                <div class="row">
                                    <!-- justified -->
                                    <div class="col-md-2"></div>
                                    <div class="col-md-10 text-right">
										<?php if($_SESSION['permissao'] == 'Administrador'){ ?>
                                            <?php include 'buscar.php'; ?>
										<?php } ?>
                                    </div>
                                </div>
                            </div>
                    </div>
                    <br/>
                    <table class="table">
                        <thead>
                                <caption><h4>Ficha da(o) Secretária(o)</h4></caption>
                        </thead>
                        <tbody>
                            <tr>
                                <td>
                                        <strong>Nome:</strong>
                                </td>
                                <td>
                                        <?php echo $secretaria[0]->getOPessoa()->getNome();?>					
                                </td>
                            </tr>
                            <tr>
                                <td>
                                        <strong>CPF: </strong>
                                </td>
                                <td>
                                        <?php echo $secretaria[0]->getOPessoa()->getCpf();?>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                        <strong>Telefone: </strong>
                                </td>
                                <td>
                                        <?php echo $secretaria[0]->getOPessoa()->getTelefone();?>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                        <strong>Email: </strong>
                                </td>
                                <td>
                                        <?php echo $secretaria[0]->getOPessoa()->getEmail();?>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                        <strong>Ativo: </strong>
                                </td>
                                <td>
                                        <?php if($secretaria[0]->getAtivo() == 1) echo "Sim<br>"; else echo "Não<br>";?>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                        <strong>Médico Associado(s): </strong>
                                </td>
                                <td>
                                        <?php 
                                        
                                            foreach($secretaria as $secsecretaria){
                                                echo $secsecretaria->getOMedico()->getOPessoa()->getNome()."<br>";
                                            }
                                        
                                        ?>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>