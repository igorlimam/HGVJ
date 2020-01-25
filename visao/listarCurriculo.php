<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading text-center"><h4>Resultado da pesquisa</h4></div>
                <div class="panel-body">
                    <div class="row">
                        <!-- justified -->
                        <form action="?area=<?php echo $_GET['area']; ?>" method="post">
                            <div class="col-md-12">
                                <div class="col-md-4">
                                    <label for="cargo_id">Cargo</label>
                                    <select name="cargo_id" id="cargo_id" class="form-control">
                                        <option selected="selected" value="">Selecione</option>
                                        <?php
                                        foreach ($areaCargos as $oEspecialidade) {
                                            ?>
                                            <option value="<?php echo $oEspecialidade->getId(); ?>">
                                                <?php
                                                echo utf8_encode($oEspecialidade->getNome());
                                                ?>
                                            </option>
                                            <?php
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="col-md-3 form-group">
                                    <label for="dataI">Data Inicial</label>
                                    <input   autocomplete="off" class="form-control" name="dataI" type="date">
                                </div>
                                <div class="col-md-3 form-group">
                                    <label for="dataF">Data Final</label>
                                    <input autocomplete="off" class="form-control" name="dataF" type="date">
                                </div>
                                <div class="col-md-2 form-group">
                                    <label for="status">Status</label>
                                    <select name="status" id="satus" class="form-control">
                                        <option selected="selected" value="">Selecione</option>
                                        <option value="1">Avaliando</option>
                                        <option value="2">Rejeitado</option>
                                        <option value="3">Aceito</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-offset-9 col-md-3 form-group">
                                <div class="col-md-12">
                                    <button class="btn button-color btn-block" name="acao" title="buscar" value="btBuscar" type="submit" title="Buscar">
                                        <span class="glyphicon glyphicon-search"></span> 
                                        Pesquisar
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>

                    <table class="table table-striped">
                        <caption><h4>Curriculo</h4></caption>
                        <thead>
                            <tr>
                                <th>N&ordm;</th>
                                <th>Data de submissão</th>
                                <th>Status</th>
                                <th>Data Status</th>
                                <th>Nome</th>
                                <th>Cargo</th>
                                <th>Exibir</th>
                                <th>Baixar</th>
                                <th>Excluir</th>
                            </tr>
                        </thead>
                        <tbody>

                            <?php
                            foreach ($oCurriculos as $oCurriculo) {
                                ?><tr>
                                    <td><?php echo $oCurriculo->getId() . "<br>"; ?></td>
                                    <td><?php echo date('d/m/Y', strtotime($oCurriculo->getData_submissao())) . "<br>"; ?></td>
                                    <td><?php
                                        if ($oCurriculo->getStatus() != null) {
                                            if ($oCurriculo->getStatus() == 1)
                                                echo "Avaliando";
                                            else if ($oCurriculo->getStatus() == 2)
                                                echo "Rejeitado";
                                            else if ($oCurriculo->getStatus() == 3)
                                                echo "Aceito";
                                            echo "<br>";
                                        };
                                        ?></td>
                                    <td><?php if ($oCurriculo->getData_status() != null)
                                            echo date('d/m/Y', strtotime($oCurriculo->getData_status())) . "<br>";
                                        ?></td>
                                    <td><?php echo $oCurriculo->getOPessoa()->getNome() . "<br>"; ?></td>
                                    <td><?php echo utf8_encode($oCurriculo->getOArea_cargo()->getNome()) . "<br>"; ?></td>
                                    <td>
                                        <form method="post" action="?area=curriculoControle">
                                            <input type="hidden" name="idCurriculo" value="<?php echo $oCurriculo->getId(); ?>" />
                                            <button class="btn btn-info" title="Exibir" type="submit" value="btExibir" name="acao">
                                                <i class="glyphicon glyphicon-list-alt icon-white"></i>
                                            </button>
                                        </form>
                                    </td>				
                                    <td>
                                        <form method="post" action="?area=curriculoControle">
                                            <a class="cor-fonte" href="/util/download.php?download_file=<?php echo $oCurriculo->getOPessoa()->getId() ?>"><span class="glyphicon glyphicon-download icon-white" style="font-size: 30px" aria-hidden="true"></span></a>
                                        </form>
                                    </td>
                                    <td>
                                        <form method="post" action="?area=curriculoControle">
                                            <input type="hidden" name="filtroBusca" value="<?php echo $filtroBusca; ?>" />
                                            <input type="hidden" name="idCurriculo" value="<?php echo $oCurriculo->getId(); ?>" />
                                            <button class="btn btn btn-danger" title="Excluir" type="submit" value="btExcluir" name="acao">
                                                <i class="glyphicon glyphicon-trash icon-white"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
<?php } ?>
                        </tbody>
                    </table>
                    <nav class="text-center" aria-label="Page navigation">
                        <ul class="pagination background-color">
                            <?php
                            for ($cont = 0; $cont < $_SESSION['numero_pag']; ++$cont) {
                                if ($_SESSION['numero_pag'] == 1) {
                                    break;
                                }
                                ?><li><a href="?area=curriculoControle&acao=btListar&pagina=<?php echo $cont ?>"><?php echo $cont + 1 ?></a></li> <?php }
                            ?>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</div>