<div class="container-fluid">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading text-center"><h4>Exame</h4></div>
                <div class="panel-body">
                    <div class="row">
                            <div class="col-md-6">
                                <!-- barra de botoes -->

                                <table>
                                    <tr>
                                        <td>
                                            <form method="post" action="?area=exameControle" class="form-group">
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
                                            <form method="post" action="?area=exameControle" class="form-group">
                                                <div class="input-group">
                                                    <span class="input-group-btn">
                                                        <input type="hidden" name="idExame" value="<?php echo $exame->getId(); ?>" />
                                                        <button class="btn btn-default btn-block" type="submit" name="acao" value="btEditar">
                                                            <span class="glyphicon glyphicon-edit"></span> Editar
                                                        </button>
                                                    </span>
                                                </div>
                                            </form>
                                        </td>
                                        <td>
                                            <form method="post" action="?area=exameControle" class="form-group">
                                                <div class="input-group">
                                                    <span class="input-group-btn btn-block">
                                                        <input type="hidden" name="idExame" value="<?php echo $exame->getId(); ?>" />
                                                        <button class="btn btn-default" type="submit" name="acao" value="btExcluir">
                                                            <span class="glyphicon glyphicon-trash"></span> Excluir
                                                        </button>
                                                    </span>
                                                </div>
                                            </form>
                                        </td>
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
                    <table class="table">
                        <thead>
                                <caption><h4>Ficha do Cadastro de Exame</h4></caption>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="col-md-6">
                                        <strong>Nome:</strong>
                                </td>
                                <td>
                                        <?php echo $exame->getNome();?>					
                                </td>
                            </tr>
                            <tr>
                                <td>
                                        <strong>Ativo: </strong>
                                </td>
                                <td>
                                        <?php if($exame->getAtivo() == 1) echo "Sim<br>"; else echo "Não<br>";?>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                        <strong>Cattegoria Associada: </strong>
                                </td>
                                <td>
                                        <?php 
                                        
                                            echo $exame->getOExame_categoria()->getNome();
                                        
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