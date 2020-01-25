<script language="JavaScript" type="text/javascript" src="js/pessoa.js"></script>
<div class="container">
    <div class="row">

        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading text-center"><h4>Novo Item do Glossário</h4></div>
                <div class="panel-body">
                    <div class="row">
                        <!-- justified -->
                        <div class="col-md-6"></div>
                        <div class="col-md-offset-1 col-md-5 text-right">
                                <?php include 'buscar.php'; ?>
                        </div>
                    </div>
                    <form method="post" action="?area=glossarioControle" name="form" enctype="multipart/form-data" class="form-group">
                        <input type="hidden" name="idGlossario" value="<?php echo $glossario->getId() ?>" />
                        <fieldset>
                                <legend>Informações do Item</legend>
                                <div class="row">
                                    <div class="col-md-offset-1 col-md-10 form-group">
                                        <label for="titulo">Titulo: *</label>
                                        <input type="text" autocomplete="off" id="titulo" required maxlength="100" class="form-control" value="<?= $glossario->getTitulo() ?>" name="titulo">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-offset-1 col-md-10 form-group">
                                        <label for="descricao">Descrição: *</label>
                                        <textarea rows="3" autocomplete="off" id="descricao" class="form-control" value="<?php echo $glossario->getDescricao() ?>" name="descricao" type="text"><?php echo $glossario->getDescricao() ?></textarea>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-offset-1 col-md-3 form-group">
                                        <label for="categoria_id">Categoria do Item: *</label>
                                        <select name="categoria_id" required="true" id="categoria_id" class="form-control">
                                            <option selected="selected" value="">Selecione</option>
                                                <?php 
                                                    foreach($arrayCategoria as $oCategoria){
                                                    ?>
                                            <option <?php if($oCategoria->getId() == $glossario->getGlossario_categoria_Id()) echo "selected"; ?> value="<?php echo $oCategoria->getId(); ?>">
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