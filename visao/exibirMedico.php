<div class="container-fluid">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading text-center"><h4>Médico</h4></div>
                <div class="panel-body">
                    <div class="row">
                            <div class="col-md-6">
                                <!-- barra de botoes -->

                                <table>
                                    <tr>
										<?php if($_SESSION['permissao'] == 'Administrador'){ ?>
											<td>
												<form method="post" action="?area=medicoControle" class="form-group">
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
												<form method="post" action="?area=medicoControle" class="form-group">
													<div class="input-group">
														<span class="input-group-btn btn-block">
															<input type="hidden" name="idMedico" value="<?php echo $medico->getPessoa_id(); ?>" />
															<button class="btn btn-default" type="submit" name="acao" value="btExcluir">
																<span class="glyphicon glyphicon-trash"></span> Excluir
															</button>
														</span>
													</div>
												</form>
											</td>
											<?php if($medico->getAtivo() == 1){ ?>
												<td>
													<form method="post" action="?area=medicoControle" class="form-group">
														<div class="input-group">
															<span class="input-group-btn btn-block">
																<input type="hidden" name="idMedico" value="<?php echo $medico->getPessoa_id(); ?>" />
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
													<form method="post" action="?area=medicoControle" class="form-group">
														<div class="input-group">
															<span class="input-group-btn btn-block">
																<input type="hidden" name="idMedico" value="<?php echo $medico->getPessoa_id(); ?>" />
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
										<?php if($_SESSION['permissao'] == 'Administrador' || ($_SESSION['permissao'] == 'Medico' && $medico->getPessoa_id() == $_SESSION['id_pessoa'])){ ?>
											<td>
												<form method="post" action="?area=medicoControle" class="form-group">
													<div class="input-group">
														<span class="input-group-btn">
															<input type="hidden" name="idMedico" value="<?php echo $medico->getPessoa_id(); ?>" />
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
                                <caption><h4>Ficha do Médico</h4></caption>
                        </thead>
                        <tbody>
                            <tr>
                                <td>
                                        <strong>Registro:</strong> 
                                </td>
                                <td>
                                        <?php echo $medico->getRegistro();?>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                        <strong>Nome:</strong>
                                </td>
                                <td>
                                        <?php echo $medico->getOPessoa()->getNome();?>					
                                </td>
                            </tr>
                            <tr>
                                <td>
                                        <strong>CPF: </strong>
                                </td>
                                <td>
                                        <?php echo $medico->getOPessoa()->getCpf();?>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                        <strong>Telefone: </strong>
                                </td>
                                <td>
                                        <?php echo $medico->getOPessoa()->getTelefone();?>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                        <strong>Email: </strong>
                                </td>
                                <td>
                                        <?php echo $medico->getOPessoa()->getEmail();?>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                        <strong>Ativo: </strong>
                                </td>
                                <td>
                                        <?php if($medico->getAtivo() == 1) echo "Sim<br>"; else echo "Não<br>";?>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                        <strong>Especialidade(s): </strong>
                                </td>
                                <td>
                                        <?php 
                                        
                                            foreach($especialidades as $especialidade){
                                                echo utf8_encode($especialidade->getOEspecialidade()->getNome())."<br>";
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