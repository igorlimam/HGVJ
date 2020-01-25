<script language="JavaScript" type="text/javascript" src="ckeditor/ckeditor.js"></script>
<div class="container">
    <div class="row">

        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading text-center"><h4>Nova Notícia</h4></div>
                <div class="panel-body">
                    <div class="row">
                        <!-- justified -->
                        <div class="col-md-6"></div>
                        <div class="col-md-6 text-right">
                                <?php include 'buscar.php'; ?>
                        </div>
                    </div>
                    <form method="post" action="?area=noticiaControle" name="form" enctype="multipart/form-data" class="form-group">
                        <input type="hidden" name="idNoticia" value="<?php echo $noticia->getId() ?>" />
                        <fieldset>
                                <legend>Informações da Notícia</legend>
                                <div class="row">
                                    <div class="col-md-offset-1 col-md-10 form-group">
                                        <label for="titulo">Titulo: *</label>
                                            <input type="text" autocomplete="off" id="titulo" required maxlength="100" class="form-control" value="<?= $noticia->getTitulo() ?>" name="titulo">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-offset-1 col-md-10 form-group">
                                        <label for="conteudo">Conteúdo: *</label>
                                        <textarea rows="20" autocomplete="off" id="conteudo" class="form-control ckeditor" value="<?php echo $noticia->getConteudo() ?>" name="conteudo" type="text"><?php echo $noticia->getConteudo() ?></textarea>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-offset-1 col-md-4 form-group">
                                        <label for="fonte">Fonte: </label>
                                        <input type="text" autocomplete="off" id="email" class="form-control" value="<?php echo $noticia->getFonte() ?>" name="fonte">
                                    </div>
                                    <div class="col-md-4 form-group">
                                        <label for="ativo">Ativo: *</label>
                                        <select name="ativo" required="true" id="ativo" class="form-control">
                                            <option selected="true" value="1">Sim</option>
                                            <option value="0">Não</option>
                                        </select>
                                    </div>
                                    <div class="col-md-3 form-group">
                                        <label for="usuario_id">Cadastrado por: *</label>
                                        <select name="usuario_id" required="true" id="usuario_id" class="form-control">
                                            <option selected="selected" value="">Selecione</option>
                                                <?php 
                                                    foreach($autores as $key=>$autor){
                                                    ?>
                                            <option <?php if($key == $noticia->getUsuario_Id()) echo "selected"; ?> value="<?php echo $key; ?>">
                                                            <?php 
                                                                    echo utf8_encode(utf8_decode($autor));
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
<script language="JavaScript" type="text/javascript">
    $("#conteudo").keydown(function(e) {
        if(e.keyCode === 9) { // tab was pressed
            // get caret position/selection
            var start = this.selectionStart;
                end = this.selectionEnd;

            var $this = $(this);

            // set textarea value to: text before caret + tab + text after caret
            $this.val($this.val().substring(0, start)
                        + "\t"
                        + $this.val().substring(end));

            // put caret at right position again
            this.selectionStart = this.selectionEnd = start + 1;

            // prevent the focus lose
            return false;
        }
    });
</script>