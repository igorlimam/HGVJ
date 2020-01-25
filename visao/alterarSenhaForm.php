<div class="container">
    <div class="row">
        <div class="col-md-4 col-md-offset-4">
            <div class="panel panel-default">
                <div class="panel-heading"><h4>Alterar Senha</h4></div>
                <div class="panel-body">                                             
                        <form action="?area=alterarSenhaForm&case=1" method="post">
                            <div class="form-group">
                                <label for="novaSenha">Nova Senha: * <small>(m&iacute;nimo 6 caracteres)</small></label>
                                <input name="novaSenha" id="novaSenha" type="password" required="True" class="form-control" />                                
                            </div>
                            <div class="form-group">
                                <label for="novaSenhaR">Repita a Nova Senha: *</label>
                                <input name="novaSenhaR" type="password" required="True" class="form-control" />                                
                            </div>
                            <div class="form-group">
                                <input name="cadastrar" type="submit" value="Alterar" class="form-control btn btn-success btn-block" />
                            </div>
                            <div>*Campos Obrigat&oacute;rios</div>
                        </form>                            
                        <?php
                        if (isset($_GET['case']) && $_GET['case'] == 1) {
							require_once 'Loader.class.php';
                            $novaSenha = $_POST['novaSenha'];
                            $novaSenhaR = $_POST['novaSenhaR'];
                            $idPessoa = $_SESSION['id_pessoa'];
                            $pessoaDAO = new PessoaDAO();
							if (strlen($novaSenha) > 5) {
								if ($novaSenha == $novaSenhaR) {
									$oPessoa = new Pessoa();
									$oPessoa->setId($idPessoa);
									$oPessoa->setSenha($novaSenha);
									$_SESSION['senha'] = $pessoaDAO->alterarSenha($oPessoa);
									?>
									<script language=javascript>
										alert('Senha Alterada com sucesso!');
										location.replace('admin.php?area=home');
									</script> <?php
								} else {
									?>
									<script language=javascript>
										alert('Os campos NOVA SENHA e REPITA A NOVA SENHA devem ser iguais! Digite novamente.');
									</script><?php
								}
							} else {
								?>
								<script language=javascript>
									alert('A quantidade de caracteres da da NOVA SENHA dever ser maior que cinco!');
								</script><?php
							}
                        }
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>