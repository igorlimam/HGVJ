<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading text-center"><h4><?php echo $noticia->getTitulo();?></h4></div>
                <div class="panel-body">
                    <div class="row">
                            <div class="col-md-6">
                                <!-- barra de botoes -->

                                <table>
                                    <tr>
                                        <td>
                                            <form method="post" action="?area=noticiaControle" class="form-group">
                                                <div class="input-group">
                                                    <span class="input-group-btn">
                                                        <button class="btn btn-default btn-block" type="submit" name="acao" value="btListar">
                                                            <span class="glyphicon glyphicon-arrow-left"></span> Voltar
                                                        </button>
                                                    </span>
                                                </div>
                                            </form>
                                        </td>
										<?php if(isset($_SESSION['permissao']) && $_SESSION['permissao'] == 'Administrador'){ ?>
										<td>
											<form method="post" action="?area=noticiaControle" class="form-group">
												<div class="input-group">
													<span class="input-group-btn">
														<input type="hidden" name="idNoticia" value="<?php echo $noticia->getId(); ?>" />
														<button class="btn btn btn-default btn-block" title="Editar" type="submit" value="btEditar" name="acao">
															<i class="glyphicon glyphicon-edit icon-white"></i> Editar
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
                                            <?php include 'buscar.php'; ?>
                                    </div>
                                </div>
                            </div>
                    </div>
                    <br/>
                    <table class="table table-responsive">
                        <tbody>
                            <tr>
                                <td colspan="2" style="padding-top:15px;padding-bottom:60px;">
                                    <p><?php echo $noticia->getConteudo();?></p>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                        <strong>Data de Publicação: </strong>
                                </td>
                                <td class="text-right">
                                        <?php echo date('d/m/Y',strtotime($noticia->getData()));?>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                        <strong>Fonte: </strong>
                                </td>
                                <td class="text-right">
                                        <?php echo $noticia->getFonte();?>
                                </td>
                            </tr>
                            <?php if(isset($_SESSION['permissao']) && $_SESSION['permissao'] == 'Administrador'){ ?>
                            <tr>
                                <td>
                                        <strong>Publicado por: </strong>
                                </td>
                                <td class="text-right">
                                        <?php echo $noticia->getOUsuario()->getNome();?>
                                </td>
                            </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>