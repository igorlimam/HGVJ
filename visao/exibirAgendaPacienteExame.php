<div class="container-fluid">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading text-center"><h4>Agenda Paciente - Exame</h4></div>
                <div class="panel-body">
                    <div class="row">
                            <div class="col-md-6">
                                <!-- barra de botoes -->

                                <table>
                                    <tr class="col-md-1">
                                        <td>
                                            <form method="post" action="?area=agendaPacienteExameControle" class="form-group">
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
                                            <form method="post" action="?area=agendaPacienteExameControle" class="form-group">
                                                <div class="input-group">
                                                    <span class="input-group-btn">
                                                        <input type="hidden" name="idAgendaPacienteExame" value="<?php echo $agendaPacienteExame->getId(); ?>" />
                                                        <button class="btn btn-default btn-block" type="submit" name="acao" value="btEditar">
                                                            <span class="glyphicon glyphicon-edit"></span> Editar
                                                        </button>
                                                    </span>
                                                </div>
                                            </form>
                                        </td>
                                        <td>
                                            <form method="post" action="?area=agendaPacienteExameControle" class="form-group">
                                                <div class="input-group">
                                                    <span class="input-group-btn btn-block">
                                                        <input type="hidden" name="idAgendaPacienteExame" value="<?php echo $agendaPacienteExame->getId(); ?>" />
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
                                        <form method="post" action="?area=agendaPacienteExameControle" class="form-group">
                                                <div class="input-group">
                                                    <span class="input-group-btn btn-block">
                                                        <input type="hidden" name="idAgendaPacienteExame" value="<?php echo $agendaPacienteExame->getId(); ?>" />
                                                        <select name="status" id="status" class="form-control">
                                                            <option selected="selected" value="">Selecione</option>
                                                            <?php foreach($vStatus as $status){?>
                                                            <option value="<?php echo $status->getId() ?>"><?php echo $status->getNome() ?></option>
                                                            <?php } ?>
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
                            <div class="col-md-6 text-right">
                                <div class="row">
                                    <!-- justified -->
                                    <div class="col-md-3"></div>
                                    <div class="col-md-9">
                                            <?php include 'buscar.php'; ?>
                                    </div>
                                </div>
                            </div>
                    </div>
                    <br/>
                    <table class="table">
                        <thead>
                                <caption><h4>Ficha de Agenda do Paciente</h4></caption>
                        </thead>
                        <tbody>
                            <tr>
                                <td>
                                        <strong>Paciente:</strong> 
                                </td>
                                <td>
                                        <?php echo $agendaPacienteExame->getOPessoa()->getNome();?>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                        <strong>CPF:</strong> 
                                </td>
                                <td>
                                        <?php echo $agendaPacienteExame->getOPessoa()->getCpf();?>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                        <strong>Email:</strong> 
                                </td>
                                <td>
                                        <?php echo $agendaPacienteExame->getOPessoa()->getEmail();?>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                        <strong>Telefone:</strong> 
                                </td>
                                <td>
                                        <?php echo $agendaPacienteExame->getOPessoa()->getTelefone();?>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                        <strong>Data Pedido:</strong> 
                                </td>
                                <td>
                                        <?php echo date('d/m/Y', strtotime($agendaPacienteExame->getData_pedido()));?>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                        <strong>Data Agendada:</strong> 
                                </td>
                                <td>
                                        <?php echo date('d/m/Y', strtotime($agendaPacienteExame->getData()));?>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                        <strong>Horário Agendado:</strong> 
                                </td>
                                <td>
                                        <?php echo date('H:i', strtotime($agendaPacienteExame->getOAgenda_horario()->getHorario()));?>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                        <strong>Status:</strong> 
                                </td>
                                <td>
                                        <?php echo $agendaPacienteExame->getOAgenda_status()->getNome();?>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <strong>Data Status:</strong> 
                                </td>
                                <td>
                                    <?php if($agendaPacienteExame->getData_status() != null) echo date('d/m/Y', strtotime($agendaPacienteExame->getData_status()));?>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>