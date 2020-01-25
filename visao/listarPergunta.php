<div class="container">
	<div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading text-center"><h4>Perguntas Frequentes</h4></div>
                <div class="panel-body">
            <div class="row">
                <!-- justified -->
                <div class="col-md-6"></div>
                <div class="col-md-offset-2 col-md-4 text-right">
                        <?php include 'buscar.php'; ?>
                </div>
            </div>

	<table class="table table-responsive table-striped">
		<tbody>
	  
		<?php
			foreach($oPerguntas as $oPergunta){
				?><tr>
                                        <td><h4 class="cor-fonte"><?php echo $oPergunta->getDescricao()."<br>";?></h4>
                                            <h5><?php echo $oPergunta->getResposta()."<br>";?></h5>
                                        </td>
                                        <!-- Permissoes para os botões -->
                                        <?php if(isset($_SESSION) && isset($_SESSION['id_pessoa'])){ ?>
                                        <td><br>
						<form method="post" action="?area=perguntaControle" class="text-right">
							<input type="hidden" name="idPergunta" value="<?php echo $oPergunta->getId(); ?>" />
							<button class="btn btn btn-success" title="Editar" type="submit" value="btEditar" name="acao">
								<i class="glyphicon glyphicon-edit icon-white"></i>
							</button>	
						</form>
					</td>
                                        <td><br>
                                            <form method="post" action="?area=perguntaControle" class="text-right">
							<input type="hidden" name="filtroBusca" value="<?php echo $filtroBusca; ?>" />
							<input type="hidden" name="idPergunta" value="<?php echo $oPergunta->getId(); ?>" />
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
		?><li><a href="?area=perguntaControle&acao=btListar&pagina=<?php echo $cont ?>"><?php echo $cont+1 ?></a></li> <?php
	} ?>
  </ul>
	</div>
        </div>
</div>
</div>
</div>