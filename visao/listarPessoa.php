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
		<caption><h4>Usuários</h4></caption>
		<thead>
			<tr>
				<th>N&ordm;</th>
                                <th>Nome</th>
                                <th>Email</th>
                                <th>Nivel de Permissão</th>
                                <th>Ativo</th>
			</tr>
		</thead>
		<tbody>
	  
		<?php
			foreach($oPessoas as $oPessoa){
				?><tr>
					<td><?php echo $oPessoa->getId()."<br>";?></td>
                                        <td><?php echo $oPessoa->getNome()."<br>";?></td>
                                        <td><?php echo $oPessoa->getEmail()."<br>";?></td>
                                        <td><?php echo utf8_encode($oPessoa->getOPermissao()->getNome())."<br>";?></td>
                                        <td><?php if($oPessoa->getBloqueado() == 'N') echo "Sim<br>"; else echo "Não<br>"; ?></td>
					
					<?php if($_SESSION['permissao'] == 'Administrador'){ ?>
					<td>
						<?php if($oPessoa->getBloqueado() == 'S'){ ?>
							<form method="post" action="?area=pessoaControle">
								<input type="hidden" name="idPessoa" value="<?php echo $oPessoa->getId(); ?>" />
								<input type="hidden" name="status" value="N" />
								<button class="btn btn-success" title="Desbloquear" type="submit" value="btBloquear" name="acao">
									<i class="glyphicon glyphicon-ok-circle icon-white"></i>
								</button>
							</form>
						<?php }else{ ?>
							<form method="post" action="?area=pessoaControle">
								<input type="hidden" name="idPessoa" value="<?php echo $oPessoa->getId(); ?>" />
								<input type="hidden" name="status" value="S" />
								<button class="btn btn-danger" title="Bloquear" type="submit" value="btBloquear" name="acao">
									<i class="glyphicon glyphicon-ban-circle icon-white"></i>
								</button>
							</form>
						<?php } ?>
					</td>
					<?php } ?>
					<td>
						<form method="post" action="?area=pessoaControle">
                                                    <input type="hidden" name="idPessoa" value="<?php echo $oPessoa->getId(); ?>" />
                                                    <button class="btn btn-info" title="Exibir" type="submit" value="btExibir" name="acao">
                                                        <i class="glyphicon glyphicon-list-alt icon-white"></i>
                                                    </button>
						</form>
					</td>
					<?php if($_SESSION['permissao'] == 'Administrador'){ ?>
					<td>
                                            <form method="post" action="?area=pessoaControle">
                                                <input type="hidden" name="idPessoa" value="<?php echo $oPessoa->getId(); ?>" />
                                                <button class="btn btn btn-success" title="Editar" type="submit" value="btEditar" name="acao">
                                                    <i class="glyphicon glyphicon-edit icon-white"></i>
                                                </button>
                                            </form>
					</td>
					<td>
                                            <form method="post" action="?area=pessoaControle">
                                                    <input type="hidden" name="filtroBusca" value="<?php echo $filtroBusca; ?>" />
                                                    <input type="hidden" name="idPessoa" value="<?php echo $oPessoa->getId(); ?>" />
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
		?><li><a href="?area=pessoaControle&acao=btBuscar&busca=&pagina=<?php echo $cont ?>"><?php echo $cont+1 ?></a></li> <?php
	} ?>
  </ul>
</nav>
	</div>
        </div>
</div>
</div>
</div>