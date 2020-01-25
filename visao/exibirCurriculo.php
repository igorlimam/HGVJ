<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading text-center"><h4>Currículo</h4></div>
                <div class="panel-body">
                    <div class="row">
                            <!-- justified -->
                            <form action="?area=<?php echo $_GET['area']; ?>" method="post">
                                <div class="col-md-12">
                                    <div class="col-md-4 form-group">
                                        <label for="cargo_id">Cargo</label>
                                        <select name="cargo_id" id="cargo_id" class="form-control">
                                            <option selected="selected" value="">Selecione</option>
                                                <?php 
                                                    foreach($areaCargos as $oEspecialidade){
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
                            <div class="col-md-6">
                                <!-- barra de botoes -->

                                <table>
                                    <tr class="col-md-1">
                                        <td>
                                            <form method="post" action="?area=curriculoControle" class="form-group">
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
                                            <form method="post" action="?area=curriculoControle" class="form-group">
                                                <div class="input-group">
                                                    <span class="input-group-btn">
                                                        <input type="hidden" name="idCurriculo" value="<?php echo $curriculo->getId(); ?>" />
                                                        <button class="btn btn-default btn-block" type="submit" name="acao" value="btEditar">
                                                            <span class="glyphicon glyphicon-edit"></span> Editar
                                                        </button>
                                                    </span>
                                                </div>
                                            </form>
                                        </td>
                                        <td>
                                            <form method="post" action="?area=curriculoControle" class="form-group">
                                                <div class="input-group">
                                                    <span class="input-group-btn btn-block">
                                                        <input type="hidden" name="idCurriculo" value="<?php echo $curriculo->getId(); ?>" />
                                                        <button class="btn btn-default" type="submit" name="acao" value="btExcluir">
                                                            <span class="glyphicon glyphicon-trash"></span> Excluir
                                                        </button>
                                                    </span>
                                                </div>
                                            </form>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="padding-left:15px;"><strong><p>Mudar Status</p></strong></td>
                                    </tr>
                                    <tr>
                                        <td style="padding-left:15px;">
                                        <form method="post" action="?area=curriculoControle" class="form-group">
                                                <div class="input-group">
                                                    <span class="input-group-btn btn-block">
                                                        <input type="hidden" name="idCurriculo" value="<?php echo $curriculo->getId(); ?>" />
                                                        <select name="status" id="status" class="form-control">
                                                            <option selected="selected" value="">Selecione</option>
                                                            <option value="1">Avaliando</option>
                                                            <option value="2">Rejeitado</option>
                                                            <option value="3">Aceito</option>
                                                        </select>
                                                        <button class="btn btn-default" type="submit" name="acao" value="btStatus">
                                                            <span class="glyphicon glyphicon-upload"></span> Alterar
                                                        </button>
                                                    </span>
                                                </div>
                                            </form>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                            
                    </div>
                    <br/>
                    <table class="table">
                        <thead>
                                <caption><h4>Ficha de Currículo</h4></caption>
                        </thead>
                        <tbody>
                            <tr>
                                <td>
                                        <strong>Data de submissão:</strong> 
                                </td>
                                <td>
                                        <?php echo date('d/m/Y', strtotime($curriculo->getData_submissao()));?>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                        <strong>Status:</strong>
                                </td>
                                <td>
                                        <?php 
                                        
                                        if($curriculo->getStatus() != null){
                                            if($curriculo->getStatus() == 1){
                                                echo "Avaliando";
                                            }else if($curriculo->getStatus() == 2){
                                                echo "Rejeitado";
                                            }else if($curriculo->getStatus() == 3){
                                                echo "Aceito";
                                            }
                                        }
                                        
                                        ?>					
                                </td>
                            </tr>
                            <tr>
                                <td>
                                        <strong>Data da confirmação do status: </strong>
                                </td>
                                <td>
                                        <?php if($curriculo->getData_status() != null) echo date('d/m/Y', strtotime($curriculo->getData_status())); ?>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                        <strong>Candidato: </strong>
                                </td>
                                <td>
                                        <?php echo $curriculo->getOPessoa()->getNome();?>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                        <strong>Cargo submetido: </strong>
                                </td>
                                <td>
                                        <?php echo $curriculo->getOArea_cargo()->getNome();?>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>