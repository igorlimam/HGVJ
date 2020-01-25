<script language="JavaScript" type="text/javascript" src="js/agenda.js"></script>
<script language="JavaScript" type="text/javascript" src="js/horarios.js"></script>
<div class="container">
    <div class="row">

        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading text-center"><h4>Novo Agendamento de Exame</h4></div>
                <div class="panel-body">
                    <div class="row">
                        <!-- justified -->
                        <div class="col-md-6"></div>
                        <div class="col-md-offset-1 col-md-5 text-right">
                                <?php include 'buscar.php'; ?>
                        </div>
                    </div>
                    <form method="post" action="?area=agendaExameControle" name="form" enctype="multipart/form-data" class="form-group">
                            <input type="hidden" name="idAgendaExame" value="<?php echo $agendaExame->getAgenda_id() ?>" />
                            <fieldset>
                                <legend>Dados do Agendamento</legend>
                                <div class="row">
                                    <div class="col-md-offset-1 col-md-5 form-group">
                                        <label for="categoria_id">Categoria do Exame *</label>
                                        <select name="categoria_id" id="categoria_id" class="form-control" onchange="selectExame(this.value,'exame_id')">
                                            <option selected="true" value="" required>Selecione</option>
                                            <?php 
                                                foreach($oCategorias as $oCategoria){
                                                ?>
                                                    <option value="<?php echo $oCategoria->getid(); ?>">
                                                        <?php 
                                                                echo utf8_encode($oCategoria->getNome());
                                                        ?>
                                                    </option>
                                                <?php
                                                }
                                            ?>
                                        </select>
                                    </div>
                                    <div class="col-md-5 form-group">
                                        <label for="exame_id">Nome do Exame: *</label>
                                        <select name="exame_id" required="true" id="exame_id" class="form-control">
                                            <option selected="selected" value="">Selecione</option>
                                        </select>
                                    </div>  
                                </div>
                                    <div class="row">
                                        <div class="col-md-offset-1 col-md-5 form-group">
                                            <label for="diaSemana_id">Dia da semana: *</label>
                                            <select autocomplete="off" required id="diaSemana_id" class="form-control" name="diaSemana_id">
                                                <option selected value="" >Selecione</option>
                                                <option value="1" >Segunda-feira</option>
                                                <option value="2" >Terça-feira</option>
                                                <option value="3" >Quarta-feira</option>
                                                <option value="4" >Quinta-feira</option>
                                                <option value="5" >Sexta-feira</option>
                                                <option value="6" >Sábado</option>
                                            </select>
                                        </div>
                                        <div class="col-md-5 form-group">
                                            <label for="conta">Local: *</label>
                                            <select name="local_id" id="local_id" class="form-control">
                                                <option selected="true" value="" required>Selecione</option>
                                                <?php
                                                    foreach($oLocais as $oLocal){
                                                    ?>
                                                        <option value="<?php echo $oLocal->getId(); ?>">
                                                            <?php 
                                                                    echo utf8_encode($oLocal->getNome());
                                                            ?>
                                                        </option>
                                                    <?php
                                                    }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-offset-1 col-md-4 form-group">
                                            <label for="horario">Horários: *</label>
                                            <input type="time" autocomplete="off" id="horario" class="form-control" value="">
                                        </div>
                                        <div class="col-md-1 form-group">
                                            <label>&nbsp;</label>
                                            <button type="button" class="btn btn-success btn-block" onclick="addHorariosE('divTable')" id="btAdd" name="btAdd" title="Adicionar novo horário"><span class="glyphicon glyphicon-plus" aria-hidden="true"></span></button>
                                        </div>
                                        <div id="divTable" class="col-md-5">
                                    
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
                            </div><br>
                            
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>