<div class="container" style="margin-top: 6%;padding-bottom: 10%">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-md-12 text-center">
                            <h4>Hospital Geral do Vale do Jaguaribe</h4>
                        </div>
                        <div class="col-md-12 text-center">
                            <span class="glyphicon glyphicon-user" aria-hidden="true"></span>
                        </div>
                        <div class="col-md-12 text-center">
                            <h5>Sistema Online de Gerenciamento</h5>
                        </div>
                    </div>
                </div>
                <div class="panel-body">
                    <?php
                    if (isset($_GET['codMensagem'])) {
                        if ($_GET['codMensagem'] == '101') {
                            ?> <div class="alert alert-danger" role="alert">CPF bloqueado. Por favor contacte um dos Administradores para mais informações</div> <?php
                        } else if ($_GET['codMensagem'] == '100') {
                            ?> <div class="alert alert-danger" role="alert">CPF ou senha errados. Por favor tente novamente</div> <?php
                        }
                    }
                    ?>
                    <form id="form1" name="form1" method="post" action="login.php">                                                               
                        <div class="form-group">
                            <label for="usuario">CPF:</label>
                            <input autocomplete="off" name="usuario" value="" onkeypress="MascaraCPF(form.usuario)" maxlength="14" type="text" id="usuario" required="True" class="form-control"/>
                        </div>
                        <div class="form-group">
                            <label for="senha">Senha:</label>
                            <input name="senha" value="" type="password" maxlength="20" id="senha" required="True" class="form-control"/>
                        </div>
                        <div class="row">
                            <div class="col-md-offset-4 col-md-4">
                                <input name="enviar" type="submit" id="enviar" value="Entrar" class="btn button-color btn-block" />
                            </div>
                        </div>
                    </form><br>
                </div>
            </div>
        </div>
    </div>
</div>