<div class="container-fluid">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading text-center"><h4>Agenda Médica</h4></div>
                <div class="panel-body">
                    <div class="row">
                            <div class="col-md-6">
                                <!-- barra de botoes -->

                                <table>
                                    <tr class="col-md-1">
										<?php if(isset($_SESSION['permissao']) && $_SESSION['permissao'] == 'Administrador'){ ?>
                                        <td>
                                            <form method="post" action="?area=agendaMedicaControle" class="form-group">
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
                                            <form method="post" action="?area=agendaMedicaControle" class="form-group">
                                                <div class="input-group">
                                                    <span class="input-group-btn btn-block">
                                                        <input type="hidden" name="idAgendaMedica" value="<?php echo $agendaMedica->getAgenda_id(); ?>" />
                                                        <button class="btn btn-default" type="submit" name="acao" value="btExcluir">
                                                            <span class="glyphicon glyphicon-trash"></span> Excluir
                                                        </button>
                                                    </span>
                                                </div>
                                            </form>
                                        </td>
                                        <td>
                                            <form method="post" action="?area=agendaMedicaControle" class="form-group">
                                                <div class="input-group">
                                                    <span class="input-group-btn">
                                                        <input type="hidden" name="idAgendaMedica" value="<?php echo $agendaMedica->getAgenda_id(); ?>" />
                                                        <button class="btn btn-default btn-block" type="submit" name="acao" value="btEditar">
                                                            <span class="glyphicon glyphicon-edit"></span> Editar
                                                        </button>
                                                    </span>
                                                </div>
                                            </form>
                                        </td>
										<?php } ?>
                                    </tr>
                                </table>
                            </div>
                            <div class="col-md-6 text-right">
                                <div class="row">
                                    <!-- justified -->
                                    <div class="col-md-2"></div>
                                    <div class="col-md-10 text-right">
                                            <?php include 'buscar.php'; ?>
                                    </div>
                                </div>
                            </div>
                    </div>
                    <br/>
                    <table class="table">
                        <thead>
                                <caption><h4>Ficha da Agenda Medica</h4></caption>
                        </thead>
                        <tbody>
                            <tr>
                                <td>
                                        <strong>Dia da Semana:</strong>
                                </td>
                                <td>
                                        <?php if($agendaMedica->getOAgenda()->getDia_semana() == 1)
                                                    echo "Segunda-feira<br>";
                                                  else if($agendaMedica->getOAgenda()->getDia_semana() == 2)
                                                    echo "Terça-feira<br>";
                                                  else if($agendaMedica->getOAgenda()->getDia_semana() == 3)
                                                    echo "Quarta-feira<br>";
                                                  else if($agendaMedica->getOAgenda()->getDia_semana() == 4)
                                                    echo "Quinta-feira<br>";
                                                  else if($agendaMedica->getOAgenda()->getDia_semana() == 5)
                                                    echo "Sexta-feira<br>";
                                                  else if($agendaMedica->getOAgenda()->getDia_semana() == 6)
                                                    echo "Sábado<br>"; ?>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                        <strong>Local:</strong>
                                </td>
                                <td>
                                        <?php echo $agendaMedica->getOAgenda()->getOLocal()->getNome();?>					
                                </td>
                            </tr>
                            <tr>
                                <td>
                                        <strong>Nome do médico: </strong>
                                </td>
                                <td>
                                        <?php echo $agendaMedica->getOMedico()->getOPessoa()->getNome();?>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                        <strong>CPF: </strong>
                                </td>
                                <td>
                                        <?php echo $agendaMedica->getOMedico()->getOPessoa()->getCpf();?>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                        <strong>Telefone: </strong>
                                </td>
                                <td>
                                        <?php echo $agendaMedica->getOMedico()->getOPessoa()->getTelefone();?>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                        <strong>Email: </strong>
                                </td>
                                <td>
                                        <?php echo $agendaMedica->getOMedico()->getOPessoa()->getEmail();?>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                        <strong>Horarios agendados: </strong>
                                </td>
                                <td></td>
                            </tr>
                            <tr>
                                <?php foreach($vHorarios as $oHorario){ ?>
                            <tr>
                                    <td><?php echo $oHorario->getHorario() ?></td>
                                    <td><?php if($oHorario->getAtivo() == 1){ ?>
                                        <form method="post" action="?area=agendaMedicaControle">
                                            <input type="hidden" name="idAgendaHorario" value="<?php echo $oHorario->getId(); ?>" />
                                            <input type="hidden" name="idAgendaMedica" value="<?php echo $agendaMedica->getAgenda_id(); ?>" />
                                            <button class="btn btn btn-danger" title="Desativar" type="submit" value="btAtivarHr" name="acao">
                                                    <i class="glyphicon glyphicon-ban-circle icon-white"></i>
                                            </button>
                                            <input name="ativo" value="0" hidden>
                                        </form>
                                   <?php }else{ ?>
                                        <form method="post" action="?area=agendaMedicaControle">
                                            <input type="hidden" name="idAgendaHorario" value="<?php echo $oHorario->getId(); ?>" />
                                            <input type="hidden" name="idAgendaMedica" value="<?php echo $agendaMedica->getAgenda_id(); ?>" />
                                            <button class="btn btn btn-success" title="Ativar" type="submit" value="btAtivarHr" name="acao">
                                                    <i class="glyphicon glyphicon-ok-circle icon-white"></i>
                                            </button>
                                            <input name="ativo" value="1" hidden>
                                        </form>
                                   <?php } ?></td>
                            </tr>
                                <?php } ?>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>