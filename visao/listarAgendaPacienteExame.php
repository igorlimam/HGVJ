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
		<caption><h4>Agenda Paciente - Exames</h4></caption>
		<thead>
			<tr>
				<th>N&ordm;</th>
				<th>Nome</th>
                                <th>Telefone</th>
                                <th>Email</th>
                                <th>Agendado</th>
                                <th>Status</th>
			</tr>
		</thead>
		<tbody>
	  
		<?php   
			foreach($oAgendaPacienteExames as $oAgendaPaciente){
				?><tr>
					<td><?php echo $oAgendaPaciente->getId()."<br>";?></td>
                                        <td><?php echo $oAgendaPaciente->getOPessoa()->getNome()."<br>";?></td>
                                        <td><?php echo $oAgendaPaciente->getOPessoa()->getTelefone()."<br>";?></td>
                                        <td><?php echo $oAgendaPaciente->getOPessoa()->getEmail()."<br>";?></td>
                                        <td><?php echo date('d/m/Y',strtotime($oAgendaPaciente->getData()))."<br>";?></td>
                                        <td><?php echo $oAgendaPaciente->getOAgenda_status()->getNome()."<br>";?></td>
                                        <?php if(1){ ?>
                                        <td class="col-md-1 text-center">
						<form method="post" action="?area=agendaPacienteExameControle">
							<input type="hidden" name="idAgendaPacienteExame" value="<?php echo $oAgendaPaciente->getId(); ?>" />
							<button class="btn btn-info" title="Exibir" type="submit" value="btExibir" name="acao">
								<i class="glyphicon glyphicon-list-alt icon-white"></i>
							</button>
						</form>
					</td>				
					<td class="col-md-1 text-center">
						<form method="post" action="?area=agendaPacienteExameControle">
							<input type="hidden" name="idAgendaPacienteExame" value="<?php echo $oAgendaPaciente->getId(); ?>" />
							<button class="btn btn btn-success" title="Editar" type="submit" value="btEditar" name="acao">
								<i class="glyphicon glyphicon-edit icon-white"></i>
							</button>	
						</form>
					</td>
					<td class="col-md-1 text-center">
						<form method="post" action="?area=agendaPacienteExameControle">
							<input type="hidden" name="busca" value="<?php echo $filtroBusca; ?>" />
							<input type="hidden" name="idAgendaPacienteExame" value="<?php echo $oAgendaPaciente->getId(); ?>" />
							<button class="btn btn btn-danger" title="Excluir" type="submit" value="btExcluir" name="acao">
								<i class="glyphicon glyphicon-trash icon-white"></i>
							</button>
						</form>
					</td>
                                        <?php } ?>
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
		?><li><a href="?area=agendaPacienteExameControle&acao=btListar&pagina=<?php echo $cont ?>"><?php echo $cont+1 ?></a></li> <?php
	} ?>
  </ul>
</nav>
	</div>
        </div>
</div>
</div>
</div>

