<div class="container">
	<div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading text-center"><h4>Resultado da pesquisa</h4></div>
                <div class="panel-body">
            

	<table class="table table-striped">
		<caption><h4>Medicas(os)</h4></caption>
		<thead>
			<tr>
				<th>N&ordm;</th>
                                <th>Nome</th>
                                <th>Selecionar</th>
			</tr>
		</thead>
		<tbody>
	  
		<?php
			foreach($vSecretarias as $oSecretaria){
				?><tr>
					<td><?php echo $oSecretaria->getId()."<br>";?></td>
                                        <td><?php echo $oSecretaria->getOMedico()->getOPessoa()->getNome()."<br>";?></td>
					<td>
						<form method="post" action="?area=agendaPacienteConsultaControle">
							<input type="hidden" name="idMedico" value="<?php echo $oSecretaria->getMedico_id(); ?>" />
							<button class="btn btn-success" title="Selecionar" type="submit" value="btAgenda" name="acao">
								<i class="glyphicon glyphicon-play-circle icon-white"></i>
							</button>
						</form>
					</td>
				</tr>
			<?php } ?>
		</tbody>
	</table>
</nav>
	</div>
        </div>
</div>
</div>
</div>