<?php
session_start();
if (!isset($_SESSION['numero_pag']) || is_null($_SESSION['numero_pag']) || $_SESSION['numero_pag'] == null) {
    session_destroy();
}
/* if(!$_SESSION['logado']){
  header("Location: logar.php");
  die;
  }else{ */
?>

<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- As 3 meta tags acima *devem* vir em primeiro lugar dentro do `head`; qualquer outro conteúdo deve vir *após* essas tags -->
        <title>Hospital Geral do Vale do Jaguaribe</title>

        <!-- Bootstrap -->
        <link href="css/bootstrap.min.css" rel="stylesheet">
        <style>
            .nav li a:hover{
                background-color: #006900;
                color:#FFFFFF;
                height: 100%;
            }
            @media print {
                nav, footer, video, audio, object, embed, .mensagem { 
                    display:none; 
                }
            }
        </style>

        <link href="css/bootstrap-responsive.css" rel="stylesheet">
        <script language="JavaScript" type="text/javascript" src="js/MascaraValidacao.js"></script>
        <script language="JavaScript" type="text/javascript" src="js/jquery-3.1.1.min.js"></script>
        <script language="JavaScript" type="text/javascript" src="js/jquery-ui.js"></script>
        <link href="css/jquery-ui.css" rel="stylesheet">
        <link href="css/style.css" rel="stylesheet">
    </head>
    <body>

        <div class="self-fluid background-default">
            <div class="container" style="padding-top: 10px;width:100%">
                <div class="row-fluid">
                    <nav class="navbar background-default">
                        <div class="container-fluid">
                            <!-- Brand and toggle get grouped for better mobile display -->
                            <div class="navbar-header">
                                <button type="button" style="background:#FFFFFF" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                                    <span class="sr-only">Toggle navigation</span>
                                    <span class="icon-bar background-default"></span>
                                    <span class="icon-bar background-default"></span>
                                    <span class="icon-bar background-default"></span>
                                </button>
                                <a class="navbar-brand" href="index.php"><img src="imagens/logo_topo.jpg" style="height:40px;margin-top:-10px;"></a>
                            </div>

                            <!-- Collect the nav links, forms, and other content for toggling -->
                            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                                <ul class="nav navbar-nav">
                                    <li class="active"><a href="index.php">Início <span class="sr-only"></span></a></li>
                                    <li class="dropdown">
                                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">O HGVJ <span class="caret"></span></a>
                                        <ul class="dropdown-menu">
                                            <li><a href="?area=conhecaHGVJ">Conheça o HGVJ</a></li>
                                            <li><a href="#">Diretoria</a></li>
                                            <li><a href="#">Conheça nosso time</a></li>
                                            <li><a href="#">Missão/Visão</a></li>
                                            <li><a href="?area=noticiaControle&acao=btListar">Notícias</a></li>
                                        </ul>
                                    </li>
                                    <li class="dropdown">
                                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Serviços <span class="caret"></span></a>
                                        <ul class="dropdown-menu">
                                            <li><a href="#">Centro de Imagem</a></li>
                                            <li><a href="#">Laboratório de Análise Clínica</a></li>
                                            <li><a href="#">Pronto Atendimento</a></li>
                                            <li><a href="#">Medical Center</a></li>
                                            <li><a href="#">Atendimento Pediátrico</a></li>
                                        </ul>
                                    </li>
                                    <li class="dropdown">
                                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Atendimento <span class="caret"></span></a>
                                        <ul class="dropdown-menu">
                                            <li><a href="#">Canais de Atendimento</a></li>
                                            <li><a href="?area=perguntaControle&acao=btListar">Perguntas Frequentes</a></li>
                                            <li><a href="?area=glossarioControle&acao=btListar">Glossário</a></li>
                                            <!--<li><a href="?area=exameControle&acao=btListar">Exames</a></li>-->
                                        </ul>
                                    </li>
                                    <li class="dropdown">
                                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Solicitar Agendamento <span class="caret"></span></a>
                                        <ul class="dropdown-menu">
                                            <li><a href="?area=agendaPacienteConsultaControle&acao=form">Consulta</a></li>
                                            <li><a href="?area=agendaPacienteExameControle&acao=form">Exame</a></li>
                                        </ul>
                                    </li>
                                    <?php // echo '<li><a href="?area=curriculoControle&acao=form">Trabalhe Conosco</a></li>' ?>
                                    <?php //echo '<li><a href="?area=logar.php">Administrativo</a></li>'; ?>

                                </ul>

                                <!--<div class="nav navbar-nav navbar-right text-right">
                                        
                                                <img src="img/unimed.png" style="height:60px;width: 30%;padding-right:20px,padding-top:-60px">
                                        
                                </div>-->

                            </div><!-- /.navbar-collapse -->



                        </div><!-- /.container-fluid -->

                    </nav>
                </div>
            </div>
        </div>

        <div>
            <div class="row-fluid">
                <?php
                if (!isset($_GET['area'])) {
                    include('visao/home.php');
                } else {
                    $area = $_GET['area'];
                    if ($area != 'home') {
                        echo "<div style='margin-top:1.5%;'></div>";
                    }
                    if (substr($area, -8) == "Controle") {
                        $area = "controle/" . $area . ".php";
                    } else {
                        $area = "visao/" . $area . ".php";
                    }

                    if (file_exists($area)) {
                        include($area);
                    } else {
                        if ($_GET['area'] == 'logar.php') {
                            include 'logar.php';
                        } else
                            echo "Página não encontrada.";
                    }
                }
                ?>

            </div>
        </div>
        <footer class="footer" style="padding-top:20px;">
            <div class="container-fluid background-default" style="padding-bottom:15px">
                <br>
                <div class="row-fluid">
                    <div class="col-md-6">
                        <div class="col-md-12 cor">
                            <p>HOSPITAL GERAL DO VALE DO JAGUARIBE</p>
                        </div>
                        <div class="col-md-12 cor">
                            Endereço: Av. Dom Aureliano Matos, 1228
                        </div>
                        <div class="col-md-12 cor">
                            CNPJ: 17.457.992/0001-83
                        </div>
                        <div class="col-md-12 cor">
                            Fone: (88)99818-0007
                        </div>
                        <label>&nbsp</label>
                        <div class="col-md-12 cor">
                            <p class="cor text-left">Todos os direitos reservados.<br></p>
                        </div>
                    </div>
                    <div class="col-md-offset-3 col-md-3">
                        <div class="row-fluid text-center">
                            <div class="col-md-10">
                                <img src="img/unimed.png" style="width: 100px">
                            </div>
                        </div>
                        <div class="col-md-10 text-center">
                            <p class="cor text-center">Acesse Também:</p>
                            <div class="btn-group text-right" role="group" aria-label="Basic example">
                                <button type="button" class="btn button-color"><a href="#" class="cor"><img class="img-responsive img-rounded" src="imagens/social_facebook_box_blue.png" width="30" height="30" alt="Facebook" title="Facebook"></a></button>
                                <button type="button" class="btn button-color"><a href="#" class="cor"><img class="img-responsive img-rounded" src="imagens/icone-twitter.png" width="30" height="30" alt="Twitter" title="Twitter"></a></button>
                                <button type="button" class="btn button-color"><a href="#" class="cor"><img class="img-responsive img-rounded" src="imagens/icone-youtube.png" width="30" height="30" alt="YouTube" title="YouTube"></a></button>
                            </div>
                            <div class="col-md-12 tex-left" style="margin-top:20px">
                                <p class="cor text-center">Produzido por: Linkdesign.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </footer>
        <a href="#0" class="cd-top">Top</a>
        <script src="js/bootstrap.min.js"></script>
        <script src="js/main.js"></script>
        <script src="js/modernizr.js"></script>
		
		<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-2875634-24', 'auto');
  ga('send', 'pageview');

</script>
    </body>
</html>

<?php
//} ?>