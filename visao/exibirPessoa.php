<div class="container-fluid">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading text-center"><h4>Usuário</h4></div>
                <div class="panel-body">
                    <div class="row">
                            <div class="col-md-6">
                                <!-- barra de botoes -->

                                <table>
                                    <tr>
										<?php if(isset($_SESSION['id_pessoa']) && $_SESSION['permissao'] == 'Administrador'){ ?>
                                        <td>
                                            <form method="post" action="?area=pessoaControle" class="form-group">
                                                <div class="input-group">
                                                    <span class="input-group-btn">
                                                        <button class="btn btn-default btn-block" type="submit" name="acao" value="form">
                                                            <span class="glyphicon glyphicon-file"></span> Novo
                                                        </button>
                                                    </span>
                                                </div>
                                            </form>
                                        </td>
										<?php } ?>
                                        <td>
                                            <form method="post" action="?area=pessoaControle" class="form-group">
                                                <div class="input-group">
                                                    <span class="input-group-btn">
                                                        <input type="hidden" name="idPessoa" value="<?php echo $pessoa->getId(); ?>" />
                                                        <button class="btn btn-default btn-block" type="submit" name="acao" value="btEditar">
                                                            <span class="glyphicon glyphicon-edit"></span> Editar
                                                        </button>
                                                    </span>
                                                </div>
                                            </form>
                                        </td>
										<?php if(isset($_SESSION['id_pessoa']) && $_SESSION['permissao'] == 'Administrador'){ ?>
                                        <td>
                                            <form method="post" action="?area=pessoaControle" class="form-group">
                                                <div class="input-group">
                                                    <span class="input-group-btn btn-block">
                                                        <input type="hidden" name="idPessoa" value="<?php echo $pessoa->getId(); ?>" />
                                                        <button class="btn btn-default" type="submit" name="acao" value="btExcluir">
                                                            <span class="glyphicon glyphicon-trash"></span> Excluir
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
                                <caption><h4>Ficha do Usuário</h4></caption>
                        </thead>
                        <tbody>
                            <tr>
                                <td>
                                        <strong>Nome:</strong>
                                </td>
                                <td>
                                        <?php echo utf8_encode(utf8_decode($pessoa->getNome()));?>					
                                </td>
                            </tr>
                            <tr>
                                <td>
                                        <strong>CPF: </strong>
                                </td>
                                <td>
                                        <?php echo $pessoa->getCpf();?>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                        <strong>Telefone: </strong>
                                </td>
                                <td>
                                        <?php echo $pessoa->getTelefone();?>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                        <strong>Celular primário: </strong>
                                </td>
                                <td>
                                        <?php echo $pessoa->getCelular1();?>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                        <strong>Celular secundário: </strong>
                                </td>
                                <td>
                                        <?php echo $pessoa->getCelular2();?>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                        <strong>Email: </strong>
                                </td>
                                <td>
                                        <?php echo $pessoa->getEmail();?>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                        <strong>Ativo: </strong>
                                </td>
                                <td>
                                        <?php if($pessoa->getBloqueado() == 'N') echo "Sim<br>"; else echo "Não<br>";?>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                        <strong>Nível de Permissão: </strong>
                                </td>
                                <td>
                                        <?php echo utf8_encode($pessoa->getOPermissao()->getNome()) ;?>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>