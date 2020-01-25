<div class="container">
	<div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading text-center"><h4>Notícias</h4></div>
                <div class="panel-body">
            <div class="row">
                <!-- justified -->
                <div class="col-md-6"></div>
                <div class="col-md-6 text-right">
                        <?php include 'buscar.php'; ?>
                </div>
            </div>

	<table class="table table-responsive table-striped">
		<tbody>
	  
		<?php
			if(count($oNoticias) == 0){
				?> <div class="alert alert-info" role="alert">Não há notícias cadastradas no momento</div> <?php
			}else{
			foreach($oNoticias as $oNoticia){
				?><tr>
					<td><a class="cor-fonte" href="?area=noticiaControle&acao=btExibir&idNoticia=<?php echo $oNoticia->getId(); ?>"><h4><?php echo $oNoticia->getTitulo()."<br>";?></h4></a>
						<h5><?php echo $oNoticia->getOUsuario()->getNome()."<br>";?></h5>
						<h5><?php echo date('d/m/Y',strtotime($oNoticia->getData())) ?></h5>
					</td>
					<!-- Permissoes para os botões -->
					<?php if(isset($_SESSION['permissao']) && $_SESSION['permissao'] == 'Administrador'){ ?>
					
                                        <?php if($oNoticia->getAtivo() == 1){ ?>
                                            <td class="text-right"><br>
                                                <form method="post" action="?area=noticiaControle">
                                                        <input type="hidden" name="ativo" value="0" />
                                                        <input type="hidden" name="idNoticia" value="<?php echo $oNoticia->getId(); ?>" />
                                                        <button class="btn btn btn-danger" title="Desativar" type="submit" value="btAtivar" name="acao">
                                                                <i class="glyphicon glyphicon-ban-circle icon-white"></i>
                                                        </button>
                                                </form>
                                            </td>
                                        <?php }else if($oNoticia->getAtivo() == 0){ ?>
                                            <td class="text-right"><br>
                                                <form method="post" action="?area=noticiaControle">
                                                        <input type="hidden" name="ativo" value="1" />
                                                        <input type="hidden" name="idNoticia" value="<?php echo $oNoticia->getId(); ?>" />
                                                        <button class="btn btn btn-success" title="Ativar" type="submit" value="btAtivar" name="acao">
                                                                <i class="glyphicon glyphicon-ok-circle icon-white"></i>
                                                        </button>
                                                </form>
                                            </td>
                                        <?php } ?>
                                        <td class="text-left"><br>
						<form method="post" action="?area=noticiaControle">
							<input type="hidden" name="filtroBusca" value="<?php echo $filtroBusca; ?>" />
							<input type="hidden" name="idNoticia" value="<?php echo $oNoticia->getId(); ?>" />
							<button class="btn btn btn-danger" title="Excluir" type="submit" value="btExcluir" name="acao">
								<i class="glyphicon glyphicon-trash icon-white"></i>
							</button>
						</form>
					</td>
					<?php }} ?>
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
		?><li><a href="?area=noticiaControle&acao=btListar&pagina=<?php echo $cont ?>"><?php echo $cont+1 ?></a></li> <?php
	} ?>
  </ul>
</nav>
	</div>
        </div>
</div>
</div>
</div>

