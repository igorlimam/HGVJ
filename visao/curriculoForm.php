<script language="JavaScript" type="text/javascript" src="js/curriculoEtc.js"></script>
<?php require_once 'util/captcha.php';
    $num1 = create_captcha(1, 5);
    $num2 = create_captcha(1, 5);
?>
<div class="container">
    <div class="row">

        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading text-center"><h4>Enviar Currículo</h4></div>
                <div class="panel-body">
                    <?php if(isset($_GET['error']) && $_GET['error'] == true){
                        echo '<div class="alert alert-danger" role="alert">
                        <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
                        <span class="sr-only">Erro:</span>
                        Resposta errada. Por favor, preencha os campos novamente
                      </div>';
                    }else if(isset($_GET['success']) && $_GET['success']){
                        echo '<div class="alert alert-success" role="alert"><strong>Sucesso!</strong> Seu curriculo foi cadastrado com sucesso!</div>';
                    } ?>
                   <?php if(0){ //Permissões e permissões?>
                    <div class="row">
                            <!-- justified -->
                            <form action="?area=curriculoControle" method="post">
                                <div class="col-md-12 text-center">
                                    <label class="text-center">Pesquisar curriculos</label>
                                    <div class="col-md-offset-3">
                                        <div class="col-md-4 form-group">
                                            <input required="true" autocomplete="off" class="form-control" name="dataI" type="date">
                                        </div>
                                    </div>
                                    <div class="col-md-6 text-right">
                                        <div class="col-md-5 form-group">
                                            <input required="true" autocomplete="off" class="form-control" name="dataF" type="date">
                                        </div>
                                        <div class="col-md-4 form-group">
                                            <button class="btn button-color btn-block" name="acao" title="buscar" value="btBuscar" type="submit" title="Buscar">
                                                <span class="glyphicon glyphicon-search"></span> 
                                                Pesquisar
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                    </div>
                   <?php } ?>
                    <form method="post" action="?area=curriculoControle" name="form" enctype="multipart/form-data" class="form-group">
                            <input type="hidden" name="idCurriculo" value="<?php $curriculo->getId() ?>" />
                            <fieldset>
                                    <legend>Dados pessoais</legend>
                                    <div class="row">
                                        <div class="col-md-offset-1 col-md-5 form-group">
                                            <label for="cpf">CPF: *</label>
											<input autocomplete="off" onkeypress="MascaraCPF(form.cpf)" placeholder="Ex:000.000.000-00" id="cpf" required maxlength="14" class="form-control" value="<?= $curriculo->getOPessoa()->getCpf() ?>" name="cpf">
                                        </div>
                                        <div class="col-md-5 form-group">
                                            <label for="conta">Cargo: *</label>
                                            <select name="cargo_id" required id="cargo_id" class="form-control">
                                                <option selected="selected" value="">Selecione</option>
                                                    <?php 
                                                        foreach($areaCargos as $oEspecialidade){
                                                        ?>
                                                            <option <?php if($curriculo->getArea_cargo_id() == $oEspecialidade->getId()) echo "selected"; ?> value="<?php echo $oEspecialidade->getId(); ?>">
                                                                <?php 
                                                                        echo utf8_encode($oEspecialidade->getNome());
                                                                ?>
                                                            </option>
                                                        <?php
                                                        }
                                                    ?>
                                            </select>
                                        </div>  
                                    </div>
                                    <div id="divAjax">
                                        <div class="row">
                                            <div class="col-md-offset-1 col-md-5 form-group">
                                                <label for="cpf">Nome: *</label>
                                                <input autocomplete="off" id="nome" class="form-control" value="<?php echo $curriculo->getOPessoa()->getNome() ?>" name="nome">
                                            </div>
                                            <div class="col-md-5 form-group">
                                                <label for="conta">Telefone: *</label>
                                                <input onkeypress="MascaraTelefone(form.telefone)" autocomplete="off" placeholder="Ex:(00)000000-0000" maxlength="14" id="telefone" class="form-control" value="<?php echo $curriculo->getOPessoa()->getTelefone() ?>" name="telefone">
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-offset-1 col-md-5 form-group">
                                                <label for="email">Email: *</label>
                                                <input autocomplete="off" value="<?php echo $curriculo->getOPessoa()->getEmail() ?>" id="email" name="email" type="email" required="True" maxlength="100" class="form-control"/>
                                            </div>
                                            <input value="" hidden="true" name="idUsuarioExame" oninput = "exameVerifica(this.value)" onsubmit="exameVerifica(this.value)" id="idUsuarioExame" onblur="exameVerifica(this.value)" onkeyup="exameVerifica(this.value)" onfocus="exameVerifica(this.value)">
                                            <div class="col-md-5 form-group" style="margin-top:10px;">
                                                <label class="control-label">Currículo: *</label>
                                                <input id="upload" name="file" required type="file">
                                            </div>
                                        </div>
                                    </div>

                            </fieldset><br><br>

                            <div class="row text-center">
                                <div class="col-md-offset-5 col-md-2 form-group">
                                    <label><?php echo "Quanto é ".$num1 . ' + ' . $num2 . ' ? '; ?></label>
                                    <input autocomplete="off" type="text" required="true" name="captcha_results" size="2">
                                    <input type="hidden" name='num1' value='<?php echo $num1; ?>'>
                                    <input type="hidden" name='num2' value='<?php echo $num2; ?>'>
                                    <button value="btGravar" name="acao" onclick="setDate('date')" title="Gravar" type="submit" style="margin-top:10px;" class="btn btn-success btn-lg btn-block">
                                            <span class="glyphicon glyphicon-send"></span> Enviar
                                    </button>
                                    <input hidden='true' value="" name="dateUser" id="date">
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

$("document").ready(function(){
    
    $("#upload").change(function() {
        var tamanho = document.getElementById('upload').files[0].size;
        if(tamanho < 3145728){
            console.log("ok");
        }else{
            alert("Arquivo maior que o permitido, favor escolher o CURRICULO");
            document.getElementById('upload').value = null;
        }
    });

});

</script>