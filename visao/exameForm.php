<script language="JavaScript" type="text/javascript" src="js/pessoa.js"></script>
<div class="container">
    <div class="row">

        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading text-center"><h4>Novo Exame</h4></div>
                <div class="panel-body">
                    <div class="row">
                        <!-- justified -->
                        <div class="col-md-6"></div>
                        <div class="col-md-offset-1 col-md-5 text-right">
                                <?php include 'buscar.php'; ?>
                        </div>
                    </div>
                    <form method="post" action="?area=exameControle" name="form" enctype="multipart/form-data" class="form-group">
                        <input type="hidden" name="idExame" value="<?php echo $exame->getId() ?>" />
                        <fieldset>
                                <legend>Dados Cadastrais</legend>
                                <div class="row">
                                    <div class="col-md-offset-1 col-md-5 form-group">
                                        <label for="nome">Nome do Exame: *</label>
                                        <input type="text" autocomplete="off" id="nome" required maxlength="100" class="form-control" value="<?= $exame->getNome() ?>" name="nome">
                                    </div>
                                    <div class="col-md-2 form-group">
                                        <label for="ativo">Ativo: *</label>
                                        <select name="ativo" required="true" id="ativo" class="form-control">
                                            <option selected="true" value="1">Sim</option>
                                            <option value="0">Não</option>
                                        </select>
                                    </div>
                                    <div class="col-md-3 form-group">
                                        <label for="categoria_id">Categoria do exame: *</label>
                                        <select name="categoria_id" required="true" id="categoria_id" class="form-control">
                                            <option selected="selected" value="">Selecione</option>
                                                <?php 
                                                    foreach($arrayCategoria as $oCategoria){
                                                    ?>
                                            <option <?php if($oCategoria->getId() == $exame->getExame_categoria_Id()) echo "selected"; ?> value="<?php echo $oCategoria->getId(); ?>">
                                                            <?php 
                                                                    echo utf8_encode(utf8_decode($oCategoria->getNome()));
                                                            ?>
                                                        </option>
                                                    <?php
                                                    }
                                                ?>
                                        </select>
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