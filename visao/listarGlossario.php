<div class="container">
	<div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading text-center"><h4>Glossário</h4></div>
                <div class="panel-body">
            <div class="row">
                <!-- justified -->
                <div class="col-md-6">
                    <nav aria-label="Page navigation">
					  <ul class="pagination background-color" style="margin:0px;margin-left:15px;">
						<?php foreach($oCategorias as $categoria){
							?><li><a href="?area=glossarioControle&acao=btListar&categoria=<?php echo $categoria->getId() ?>"><?php echo $categoria->getNome() ?></a></li> <?php
						} ?>
					  </ul>
					</nav>
									</div>
                <div class="col-md-6 text-right">
                        <?php include 'buscar.php'; ?>
                </div>
            </div>

	<table class="table table-responsive table-condensed">
		<tbody>
                       <?php if(!isset($_GET['buscando'])){
						   ?> <tr><strong><h4 class="cor-fonte"><?php echo $oGlossarios[0]->getOGlossario_categoria()->getNome().".<br>";?></h4></strong></tr> <?php
					   } ?>
		<?php if(count($oGlossarios) > 0){
			foreach($oGlossarios as $oGlossario){
				?><tr>
                                    
					<td><h4 class="cor-fonte"><?php echo $oGlossario->getTitulo()."<br>";?></h4>
						<h5><?php echo utf8_encode(utf8_decode($oGlossario->getDescricao()))."<br>";?></h5>
					</td>
					<!-- Permissoes para os botões -->
					<?php if(isset($_SESSION) && count($_SESSION) >= 1){ ?>
					<td><br>
					<form method="post" action="?area=glossarioControle">
						<input type="hidden" name="idGlossario" value="<?php echo $oGlossario->getId(); ?>" />
						<button class="btn btn btn-success" title="Editar" type="submit" value="btEditar" name="acao">
							<i class="glyphicon glyphicon-edit icon-white"></i>
						</button>	
					</form>
					</td>
					<td><br>
						<form method="post" action="?area=glossarioControle">
							<input type="hidden" name="filtroBusca" value="<?php echo $filtroBusca; ?>" />
							<input type="hidden" name="idGlossario" value="<?php echo $oGlossario->getId(); ?>" />
							<button class="btn btn btn-danger" title="Excluir" type="submit" value="btExcluir" name="acao">
								<i class="glyphicon glyphicon-trash icon-white"></i>
							</button>
						</form>
					</td>
					<?php } ?>
				</tr>
			<?php }
		}else{
			?> <tr><td>
				<div class="alert alert-info" role="alert">Não há nenhum item cadastrado nesta seção</div>
			</td></tr> <?php
		} ?>
			
		</tbody>
	</table>
	</div>
        </div>
</div>
</div>
</div>
