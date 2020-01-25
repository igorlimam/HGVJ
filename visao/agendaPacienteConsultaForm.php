<script language="JavaScript" type="text/javascript" src="js/agenda.js"></script>
<?php require_once 'util/captcha.php'; 
    $num1 = create_captcha(1, 5);
    $num2 = create_captcha(1, 5);
?>

<div class="container">
    <div class="row">

        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading text-center"><h4>Solicitar Consulta</h4></div>
                <div class="panel-body">
                    <?php if(isset($_GET['error']) && $_GET['error'] == true){
                        echo '<div class="alert alert-danger" role="alert">
                        <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
                        <span class="sr-only">Erro:</span>
                        Resposta errada. Por favor, preencha os campos novamente
                      </div>';
                    }else if(isset($_GET['success']) && $_GET['success']){
                        echo '<div class="alert alert-success" role="alert"><strong>Sucesso!</strong> Seu pedido foi agendado com sucesso!</div>';
                    } ?>
                   <?php if(0){ //Permissões e permissões?>
                    <div class="row">
                            <!-- justified -->
                            <div class="col-md-6"></div>
                            <div class="col-md-6 text-right">
                                    <?php include 'buscar.php'; ?>
                            </div>
                    </div>
                   <?php } ?>
                    <form method="post" action="?area=agendaPacienteConsultaControle" id="form" name="form" enctype="multipart/form-data" class="form-group">
                            <input type="hidden" name="idAgendaPacienteConsulta" value="<?php echo $agendaPacienteConsulta->getId() ?>" />
                            
                            <fieldset>
                                    <legend>Dados pessoais</legend>
                                        <div class="row">
                                            <div class="col-md-offset-1 col-md-5 form-group">
                                                <label for="cpf">CPF: *</label><!-- id do input = cpf -->
                                                    <input type="text" autocomplete="off" onkeypress="MascaraCPF(form.cpf)" placeholder="Ex:000.000.000-00" id="cpf" required maxlength="14" class="form-control" value="<?= $agendaPacienteConsulta->getOPessoa()->getCpf() ?>" name="cpf"><div id="cpfMessage"></div>
                                            </div>
                                            <div class="col-md-5 form-group">
                                                <label for="nome">Nome: *</label>
                                                <input autocomplete="off" id="nome" class="form-control" value="<?php echo $agendaPacienteConsulta->getOPessoa()->getNome() ?>" name="nome">
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-offset-1 col-md-5 form-group">
                                                <label for="email">Email: </label>
                                                <input autocomplete="off" value="<?php echo $agendaPacienteConsulta->getOPessoa()->getEmail() ?>" id="email" name="email" type="email" maxlength="100" class="form-control"/>
                                            </div>
                                            <div class="col-md-5 form-group">
                                                <label for="telefone">Telefone: </label>
                                                <input onkeypress="MascaraTelefone(form.telefone)" autocomplete="off" placeholder="Ex:(00)000000-0000" maxlength="14" id="telefone" class="form-control" value="<?php echo $agendaPacienteConsulta->getOPessoa()->getTelefone() ?>" name="telefone">
                                            </div>
                                        </div>
                                    <div class="row">
                                        <div class="col-md-offset-1 col-md-5 form-group">
                                        <label for="especialidade_id">Especialidade: *</label>
                                            <select name="especialidade_id" id="especialidade_id" class="form-control" onchange="selectMedicoP(this.value,'medico_id')">
                                                <option selected="true" value="" required>Selecione</option>
                                                <?php 
                                                    foreach($oEspecialidades as $oEspecialidade){
                                                    ?>
                                                        <option value="<?php echo $oEspecialidade->getEspecialidade_id(); ?>">
                                                            <?php 
                                                                    echo utf8_encode($oEspecialidade->getOEspecialidade()->getNome());
                                                            ?>
                                                        </option>
                                                    <?php
                                                    }
                                                ?>
                                            </select>
                                        </div>
                                        <div class="col-md-5 form-group">
                                            <label for="medico_id">Médico(a): *</label>
                                            <select name="medico_id" required="true" id="medico_id" class="form-control" onchange="selectDiaMes(this.value)">
                                                <option selected="selected" value="">Selecione</option>
                                            </select>
                                        </div>
                                        <input value="" readonly hidden="true" name="idUsuarioExame" oninput = "exameVerifica(this.value)" onsubmit="exameVerifica(this.value)" id="idUsuarioExame" onblur="exameVerifica(this.value)" onkeyup="exameVerifica(this.value)" onfocus="exameVerifica(this.value)">
                                    </div>
                                    <div class="row">
                                        <div class="col-md-offset-1 col-md-5">
                                            <label for="mes">Mês a ser agendado: *</label>
                                            <select name="mes" disabled required="true" id="mes" class="form-control" onchange="selectDia(this.value,'dia')">
                                                <option selected="selected" value="">Selecione</option>
                                                <?php
                                                    setlocale(LC_ALL, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
                                                    date_default_timezone_set('America/East');
                                                    $today = strtotime('today');
                                                    for($cont = 0; $cont < 12; ++$cont){
                                                    
                                                    ?>
                                                        <option value="<?php echo $today; ?>">
                                                            <?php 
                                                                    echo utf8_encode(ucwords(strftime('%B', $today))." - ".strftime('%Y', $today));
                                                            ?>
                                                        </option>
                                                    <?php
                                                    $dateT = date('Y-m-d',$today);
                                                    $today = strtotime($dateT.' first day of +1 month');
                                                    }
                                                ?>
                                            </select>
                                        </div>
                                        <div class="col-md-5">
                                            <label for="dia">Dia a ser agendado: *</label>
                                            <select name="dia" disabled required="true" id="dia" onchange="selectHorario(this.value,'horario')" class="form-control">
                                                <option selected="selected" value="">Selecione</option>
                                            </select>
                                        </div>
                                    </div><br>
                                    <div class="row">
                                        <div class="col-md-offset-1 col-md-2">
                                            <label for="horario">Horário: *</label>
                                            <select name="horario" disabled required="true" id="horario" class="form-control">
                                                <option selected="selected" value="">Selecione</option>
                                            </select>
                                        </div>
                                        
                                    </div>

                            </fieldset><br>

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