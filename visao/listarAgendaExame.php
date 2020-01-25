<div class="container">
	<div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading text-center"><h4>Resultado da pesquisa</h4></div>
                <div class="panel-body">
            <div class="row">
                <!-- justified -->
                <div class="col-md-6"></div>
                <div class="col-md-6 text-right">
                        <?php include 'buscar.php'; ?>
                </div>
            </div>

	<table class="table table-striped">
		<caption><h4>Agenda Médica</h4></caption>
		<thead>
			<tr>
				<th>N&ordm;</th>
				<th>Dia</th>
                                <th>Exame</th>
                                <th>Local</th>
			</tr>
		</thead>
		<tbody>
	  
		<?php
			foreach($oAgendasExame as $oAgendaExame){
				?><tr>
					<td><?php echo $oAgendaExame->getAgenda_id()."<br>";?></td>
                                        <td><?php if($oAgendaExame->getOAgenda()->getDia_semana() == 1)
                                                    echo "Segunda-feira<br>";
                                                  else if($oAgendaExame->getOAgenda()->getDia_semana() == 2)
                                                    echo "Terça-feira<br>";
                                                  else if($oAgendaExame->getOAgenda()->getDia_semana() == 3)
                                                    echo "Quarta-feira<br>";
                                                  else if($oAgendaExame->getOAgenda()->getDia_semana() == 4)
                                                    echo "Quinta-feira<br>";
                                                  else if($oAgendaExame->getOAgenda()->getDia_semana() == 5)
                                                    echo "Sexta-feira<br>";
                                                  else if($oAgendaExame->getOAgenda()->getDia_semana() == 6)
                                                    echo "Sábado<br>";
                                                  
                                        ?></td>
                                        <td><?php echo $oAgendaExame->getOExame()->getNome()."<br>";?></td>
                                        <td><?php echo $oAgendaExame->getOAgenda()->getOLocal()->getNome()."<br>"; ?></td>
                                        <td class="text-right col-md-1">
                                            <?php if($oAgendaExame->getOAgenda()->getAtivo() == 1){ ?>
                                                <form method="post" action="?area=agendaExameControle">
							<input type="hidden" name="idAgendaExame" value="<?php echo $oAgendaExame->getAgenda_id(); ?>" />
							<button class="btn btn btn-danger" title="Desativar" type="submit" value="btAtivar" name="acao">
								<i class="glyphicon glyphicon-ban-circle icon-white"></i>
                                                        </button>
                                                        <input name="ativo" value="0" hidden>
						</form>
                                           <?php }else{?>
                                                <form method="post" action="?area=agendaExameControle">
							<input type="hidden" name="idAgendaExame" value="<?php echo $oAgendaExame->getAgenda_id(); ?>" />
							<button class="btn btn btn-success" title="Ativar" type="submit" value="btAtivar" name="acao">
								<i class="glyphicon glyphicon-ok-circle icon-white"></i>
							</button>	
                                                        <input name="ativo" value="1" hidden>
						</form>
                                           <?php } ?>
					</td>
                                        <td class="text-right col-md-1">
						<form method="post" action="?area=agendaExameControle">
							<input type="hidden" name="idAgendaExame" value="<?php echo $oAgendaExame->getAgenda_id(); ?>" />
							<button class="btn btn-info" title="Exibir" type="submit" value="btExibir" name="acao">
								<i class="glyphicon glyphicon-list-alt icon-white"></i>
							</button>
						</form>
					</td>
                                        <td class="text-right col-md-1">
                                            <form method="post" action="?area=agendaExameControle">
                                                <input type="hidden" name="idAgendaExame" value="<?php echo $oAgendaExame->getAgenda_id(); ?>" />
                                                <button class="btn btn btn-success" title="Editar" type="submit" value="btEditar" name="acao">
                                                    <i class="glyphicon glyphicon-edit icon-white"></i>
                                                </button>
                                            </form>
					</td>
					<td class="text-right col-md-1">
						<form method="post" action="?area=agendaExameControle">
							<input type="hidden" name="filtroBusca" value="<?php echo $filtroBusca; ?>" />
							<input type="hidden" name="idAgendaExame" value="<?php echo $oAgendaExame->getAgenda_id(); ?>" />
							<button class="btn btn btn-danger" title="Excluir" type="submit" value="btExcluir" name="acao">
								<i class="glyphicon glyphicon-trash icon-white"></i>
							</button>
						</form>
					</td>
				</tr>
			<?php } ?>
		</tbody>
	</table>
	<nav class="text-center" aria-label="Page navigation">
  <ul class="pagination background-color">
	<?php for($cont = 0; $cont < $_SESSION['numero_pag']; ++$cont){
		if($_SESSION['numero_pag'] == 1){
			break;
		}
		?><li><a href="?area=agendaExameControle&acao=btBuscar&busca=&pagina=<?php echo $cont ?>"><?php echo $cont+1 ?></a></li> <?php
	} ?>
  </ul>
</nav>
	</div>
        </div>
</div>
</div>
</div>