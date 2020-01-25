<div class="container">
	<div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading text-center"><h4>Exames</h4></div>
                <div class="panel-body">
            <div class="row">
                <!-- justified -->
                <div class="col-md-6"></div>
                <div class="col-md-6 text-right">
                        <form action="?area=<?php echo $_GET['area']; ?>" method="post">		
							<div class="col-md-8 form-group">
								<input autocomplete="off" class="form-control" name="busca" type="text">
							</div>
							<div class="col-md-4 form-group">
								<button class="btn button-color btn-block" name="acao" value="btBuscar2" type="submit" title="Buscar">
									<span class="glyphicon glyphicon-search"></span> 
									 Pesquisar
								</button>
							</div>
							
						</form>
                </div>
            </div>

	<table class="table table-responsive table-striped">
		<tbody>
	  
		<?php
			foreach($oExames as $oExame){
				?><tr>
                                        <td><h4><?php echo $oExame->getNome()."<br>";?></h4>
                                        </td>
                                        <!-- Permissoes para os botões -->
                                        <?php if(isset($_SESSION) && isset($_SESSION['id_pessoa'])){ ?>
                                        
                                        <td><br>
						<form method="post" action="?area=exameControle">
							<input type="hidden" name="filtroBusca" value="<?php echo $filtroBusca; ?>" />
							<input type="hidden" name="idExame" value="<?php echo $oExame->getId(); ?>" />
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
		?><li><a href="?area=exameControle&acao=btListar&pagina=<?php echo $cont ?>"><?php echo $cont+1 ?></a></li> <?php
	} ?>
  </ul>
</nav>
	</div>
        </div>
</div>
</div>
</div>

