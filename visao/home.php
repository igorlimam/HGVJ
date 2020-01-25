<?php

	require_once 'Loader.class.php';
	$noticiaDAO = new NoticiaDAO();
	$vNoticias = $noticiaDAO->listar(0,8);

?>
<div id="myCarousel" class="carousel slide" data-ride="carousel">
  <!-- Indicators -->
  <ol class="carousel-indicators">
    <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
    <li data-target="#myCarousel" data-slide-to="1"></li>
    <li data-target="#myCarousel" data-slide-to="2"></li>
    <li data-target="#myCarousel" data-slide-to="3"></li>
  </ol>

  <!-- Wrapper for slides -->
  <div class="carousel-inner" role="listbox">
    <div class="item active">
        <a href="?area=noticiaControle&acao=btListar">
            <img class="banner" class="img-fluid" src="img/banner.jpg">
        </a>
    </div>
  </div>

  <!-- Left and right controls -->
  <a class="left carousel-control" href="#myCarousel" role="button" data-slide="prev">
    <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
    <span class="sr-only">Previous</span>
  </a>
  <a class="right carousel-control" href="#myCarousel" role="button" data-slide="next">
    <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
    <span class="sr-only">Next</span>
  </a>
</div>
<div class="row-fluid">
    <br>
    <div class="col-md-12">
        <div class="text-center">
            <div class="col-md-4" style="margin-bottom: 20px;">
                <img class="img-rounded img-fluid imgIndex" src="imagens/unimed-urgente.jpg" style="">
                <h3 class="cor-fonte" >HGVJ Urgente</h3>
                <p>O Hospital Geral do Vale do Jaguaribe oferece um serviço exclusivo para você. É o HGVJ Urgente. Oferece assistência médica de urgência e emergência pré-hospitalar para seus clientes, atuando 24 horas por dia na região do Vale do Jaguaribe. Conheça mais sobre o Unimed Urgente.</p>
                <a href="#" class="cor"><button class="btn btn-lg button-color">Conheça</button></a>
                
            </div>
            <div class="col-md-4" style="margin-bottom: 20px;">
                <img class="img-rounded img-fluid imgIndex" src="imagens/laboratorio-1-300x300.jpg">
                <h3 class="cor-fonte">Laboratório HGVJ</h3>
                <p >O Laboratório da HGVJ realiza exames em diversas áreas, além de oferecer suporte completo para toda a segurança e conforto do paciente. Os procedimentos técnicos e administrativos são realizados por sistemas totalmente informatizados, desde o cadastro dos pacientes até a entrega final dos resultados, garantindo a rastreabilidade e a confiança em todo o processo.</p>
                <a href="#" class="cor"><button class="btn btn-lg button-color">Quero agendar</button></a>
            </div>
            <div class="col-md-4" style="margin-bottom: 20px;">
                <img class="img-rounded img-fluid imgIndex" src="imagens/pediatra.jpg">
                <h3 class="cor-fonte">HGVJ Pediatria</h3>
                <p> O setor de pediatria da HGVJ é constituído por uma equipe multidisciplinar composta por enfermeiros, médicos pediatras e de outras especialidades, técnicos em enfermagem, nutricionista e farmacêutico para a orientação e cuidados com os pacientes e seus familiares. Os profissionais são submetidos constantemente a treinamentos e capacitações, que fortalecem a qualidade do serviço prestado pelo Hospital Infantil. </p>
                <a href="#" class="cor"><button class="btn btn-lg button-color">Quero agendar</button></a>
            </div>
        </div>
    </div>
</div><br>
<div class="row-fluid" style="background:#E8F5E9;">
    <div class="col-md-12" style="margin-bottom:3%">
        <legend><h2 class="text-center"><span class="glyphicon glyphicon-globe" aria-hidden="true"></span> Notícias</h2></legend>
        <div class="col-md-offset-1 col-md-5">
			<?php $cont = 0; foreach($vNoticias as $oNoticia){
				if($cont % 2 == 0){
					?> <h4><span class="glyphicon glyphicon-check cor-fonte" aria-hidden="true"></span><a class="cor-fonte" href="?area=noticiaControle&acao=btExibir&idNoticia=<?php echo $oNoticia->getId(); ?>"> <?php echo $oNoticia->getTitulo()."<br>";?></a></h4>
					
					<h5><?php echo date('d/m/Y',strtotime($oNoticia->getData())) ?></h5><br> <?php 
				}
				++$cont;
			} ?>
		</div>
		<div class="col-md-offset-1 col-md-5">
			
			<?php $cont = 0; foreach($vNoticias as $oNoticia){
				if($cont % 2 == 1){
					?> <h4><span class="glyphicon glyphicon-check cor-fonte" aria-hidden="true"></span><a class="cor-fonte" href="?area=noticiaControle&acao=btExibir&idNoticia=<?php echo $oNoticia->getId(); ?>"> <?php echo $oNoticia->getTitulo()."<br>";?></a></h4>
					
					<h5><?php echo date('d/m/Y',strtotime($oNoticia->getData())) ?></h5><br> <?php 
				}
				++$cont;
			} ?>
		</div>
    </div>
</div>
<div class="row-fluid">
    <legend><h2 class="text-center"><span class="glyphicon glyphicon-ok" aria-hidden="true"></span> INFORMAÇÕES PARA VISITANTES</h2></legend>
    <div class="col-md-offset-1 col-md-10" style="margin-bottom:20px;">
        <div class="col-md-4">
            <div>
                <div class="col-md-offset-2 col-md-12">
                    <img class="img-responsive" src="imagens/icones-orientacoes-roupas.png">
                </div>
                <div class="col-md-12">
                    <h3>Ao visitar o hospital, dê preferência a roupas confortáveis e adequadas.</h3>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div>
                <div class="col-md-offset-2 col-md-12">
                    <img class="img-responsive" src="imagens/icones-orientacoes-criancas.png">
                </div>
                <div class="col-md-12">
                    <h3>Somente crianças com 12 anos de idade ou mais podem visitar o HGVJ, acompanhadas de um adulto.</h3>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div>
                <div class="col-md-offset-2 col-md-12">
                    <img class="img-responsive" src="imagens/icones-orientacoes-alimentos.png">
                </div>
                <div class="col-md-12">
                    <h3>Evite trazer alimentos de quaisquer tipos ao hospital, não é permitido levá-los aos leitos.</h3>
                </div>
            </div>
        </div>
    </div>
</div>