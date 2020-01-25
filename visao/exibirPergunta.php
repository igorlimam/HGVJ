<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading text-center"><h4>Pergunta</h4></div>
                <div class="panel-body">
                    <div class="row">
                            <div class="col-md-6">
                                <!-- barra de botoes -->

                                <table>
                                    <tr>
                                        <td>
                                            <form method="post" action="?area=perguntaControle" class="form-group">
                                                <div class="input-group">
                                                    <span class="input-group-btn">
                                                        <button class="btn btn-default btn-block" type="submit" name="acao" value="form">
                                                            <span class="glyphicon glyphicon-arrow-left"></span> Voltar
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
                    <table class="table table-responsive">
                        <thead>
                                <caption><h4><?php echo $pergunta->getDescricao();?></h4></caption>
                        </thead>
                        <tbody>
                            <tr>
                                <td colspan="2">
                                    <p><?php echo $pergunta->getResposta();?></p>
                                </td>
                            </tr>
                            <tr>
                                <td class="col-md-1">
                                    <strong>Categoria: </strong>
                                </td>
                                <td>
                                        <?php echo $pergunta->getOPergunta_categoria()->getNome();?>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>