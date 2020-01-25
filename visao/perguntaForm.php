<script language="JavaScript" type="text/javascript" src="js/pessoa.js"></script>
<div class="container">
    <div class="row">

        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading text-center"><h4>Nova Pergunta</h4></div>
                <div class="panel-body">
                    <div class="row">
                        <!-- justified -->
                        <div class="col-md-6"></div>
                        <div class="col-md-6 text-right">
                                <?php include 'buscar.php'; ?>
                        </div>
                    </div>
                    <form method="post" action="?area=perguntaControle" name="form" enctype="multipart/form-data" class="form-group">
                        <input type="hidden" name="idPergunta" value="<?php echo $pergunta->getId() ?>" />
                        <fieldset>
                                <legend>Informações da Pergunta</legend>
                                <div class="row">
                                    <div class="col-md-offset-1 col-md-10 form-group">
                                        <label for="descricao">Pergunta: *</label>
                                        <input type="text" autocomplete="off" id="descricao" required maxlength="100" class="form-control" value="<?= $pergunta->getDescricao() ?>" name="descricao">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-offset-1 col-md-10 form-group">
                                        <label for="conteudo">Resposta: *</label>
                                        <textarea rows="3" autocomplete="off" id="conteudo" class="form-control" value="<?php echo $pergunta->getResposta() ?>" name="resposta" type="text"><?php echo $pergunta->getResposta() ?></textarea>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-offset-1 col-md-3 form-group">
                                        <label for="categoria_id">Categoria da pergunta: *</label>
                                        <select name="categoria_id" required="true" id="categoria_id" class="form-control">
                                            <option selected="selected" value="">Selecione</option>
                                                <?php 
                                                    foreach($arrayCategoria as $oCategoria){
                                                    ?>
                                            <option <?php if($oCategoria->getId() == $pergunta->getPergunta_categoria_Id()) echo "selected"; ?> value="<?php echo $oCategoria->getId(); ?>">
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