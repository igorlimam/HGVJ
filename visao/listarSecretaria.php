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
		<caption><h4>Secretária(o)</h4></caption>
		<thead>
			<tr>
				<th>N&ordm;</th>
                                <th>Nome</th>
                                <th>Telefone</th>
                                <th>Ativo</th>
			</tr>
		</thead>
		<tbody>
	  
		<?php
			foreach($oSecretarias as $oSecretaria){
				?><tr>
					<td><?php echo $oSecretaria->getId()."<br>";?></td>
                                        <td><?php echo $oSecretaria->getOPessoa()->getNome()."<br>";?></td>
                                        <td><?php echo $oSecretaria->getOPessoa()->getTelefone()."<br>";?></td>
                                        <td><?php if($oSecretaria->getAtivo() == 1) echo "Sim<br>"; else echo "Não<br>"; ?></td>
					<td>
						<form method="post" action="?area=secretariaControle">
							<input type="hidden" name="idSecretaria" value="<?php echo $oSecretaria->getOPessoa()->getId(); ?>" />
							<button class="btn btn-info" title="Exibir" type="submit" value="btExibir" name="acao">
								<i class="glyphicon glyphicon-list-alt icon-white"></i>
							</button>
						</form>
					</td>		
					<?php if($_SESSION['permissao'] == 'Administrador' || ($_SESSION['permissao'] == 'Secretaria' && $oSecretaria->getPessoa_id() == $_SESSION['id_pessoa'])){ ?>
						<td>
							<form method="post" action="?area=secretariaControle">
								<input type="hidden" name="idSecretaria" value="<?php echo $oSecretaria->getOPessoa()->getId(); ?>" />
								<button class="btn btn btn-success" title="Editar" type="submit" value="btEditar" name="acao">
									<i class="glyphicon glyphicon-edit icon-white"></i>
								</button>	
							</form>
						</td>
					<?php } ?>
					<?php if($_SESSION['permissao'] == 'Administrador'){ ?>
						<td>
							<form method="post" action="?area=secretariaControle">
								<input type="hidden" name="filtroBusca" value="<?php echo $filtroBusca; ?>" />
								<input type="hidden" name="idSecretaria" value="<?php echo $oSecretaria->getOPessoa()->getId(); ?>" />
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
		?><li><a href="?area=secretariaControle&acao=btBuscar&busca=&pagina=<?php echo $cont ?>"><?php echo $cont+1 ?></a></li> <?php
	} ?>
  </ul>
</nav>
	</div>
        </div>
</div>
</div>
</div>