<style>
    #inscricao{
        font-size: 16px;
        font-family: arial;
        color: #000;
    }
</style>
<script>
    $(document).ready(function(){
        window.print();
});
</script>

<div class="container" id="inscricao">
    <div class="row">

        <div class="col-md-12">
            <div class="mensagem text-center">
                <button type="button" class="btn btn-success" onclick="window.print()">
                    <i class="glyphicon glyphicon-print"></i>
                    Imprimir
                </button>
                <br />
                <br />
                <?php if(!isset($mensagem)){ ?>
                <div class="alert alert-success alert-dismissible" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <strong>Inscrição Realizada com Sucesso!</strong> Lembre-se de imprimir a sua Ficha de Inscrição.
                </div>
                <?php } ?>
            </div>
            <div class="text-right"><img height="60" src="imagens/logo_topo.jpg" /></div>
            <div class="panel-body">
                <h3 class="text-center">ANEXO V</h3>
                <h3 class="text-center">FICHA DE INSCRIÇÃO</h3>

                <br />
                <br />
                    <div class="row">
                        <div class="col-md-12">
                            <table class="table">
                                <tr>
                                    <td colspan="6"><label for="nome">Nome: </label>
                                        <?php echo $oCurriculo->getOPessoa()->getNome() ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="6">
                                        <label for="pai">Filiação: Pai: </label>
                                        <?php echo $oCurriculo->getOPessoa()->getPai(); ?>                                                                   
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="6">
                                        <label for="mae">Mãe: </label>
                                        <?php echo $oCurriculo->getOPessoa()->getMae(); ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="6">
                                        <label for="nascimento">Data de Nascimento: </label>
                                        <?php echo date('d/m/Y', strtotime($oCurriculo->getOPessoa()->getNascimento())); ?>
                                    </td>
                                </tr>

                                <tr>
                                    <td colspan="4">
                                        <label for="logradouro">Endereço: </label>
                                        <?php echo $oCurriculo->getOPessoa()->getLogradouro() ?>
                                    </td>
                                    <td colspan="2">
                                        <label for="numero">Número: </label>
                                        <?php echo $oCurriculo->getOPessoa()->getNumero() ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="1">
                                        <label for="complemento">Complemento: </label>
                                        <?php echo $oCurriculo->getOPessoa()->getComplemento(); ?>
                                    </td>
                                    <td colspan="4">
                                        <label for="bairro">Bairro: </label>
                                        <?php echo $oCurriculo->getOPessoa()->getBairro(); ?>
                                    </td>
                                    <td colspan="1">
                                        <label for="cep">CEP: </label>
                                        <?php echo $oCurriculo->getOPessoa()->getCep(); ?>
                                    </td>
                                </tr>

                                <tr>
                                    <td colspan="2">
                                        <label for="cidade">Cidade: </label>
                                        <?php echo $oCurriculo->getOPessoa()->getCidade(); ?>
                                    </td>
                                    <td colspan="2">
                                        <label for="uf">UF: </label>
                                        <?php echo $oCurriculo->getOPessoa()->getEstado(); ?>
                                    </td>
                                    <td colspan="2">
                                        <label for="nacionalidade">Nacionalidade: </label>
                                        <?php echo $oCurriculo->getOPessoa()->getNacionalidade(); ?>
                                    </td>
                                </tr>

                                <tr>
                                    <td colspan="6">
                                        <label for="civil">Estado Civil: </label>
                                        <?php echo $oCurriculo->getOPessoa()->getEstado_civil(); ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="6">
                                        <label for="telefone">Telefones :</label>
                                        <?php echo $oCurriculo->getOPessoa()->getTelefone(); ?> | <?php echo $oCurriculo->getOPessoa()->getCelular1(); ?> |
                                        <?php echo $oCurriculo->getOPessoa()->getCelular2(); ?> | <?php echo $oCurriculo->getOPessoa()->getCelular3(); ?>                                            
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="6">
                                        <label for="email">Email:</label>
                                        <?php echo $oCurriculo->getOPessoa()->getEmail() ?>
                                    </td>
                                </tr>

                            </table>
                        </div>
                    </div>
               

                <fieldset>
                    <legend>DOCUMENTAÇÃO APRESENTADA</legend>
                    <div class="row">
                        <div class="col-md-12">
                            <table class="table">
                                <tr>
                                    <td colspan="2">
                                        <label for="rg">RG: </label>
                                        <?php echo $oCurriculo->getOPessoa()->getRg(); ?>
                                    </td> 
                                    <td colspan="2">
                                        <label for="dataemissao">Data de Emissão: </label>
                                        <?php echo date('d/m/Y', strtotime($oCurriculo->getOPessoa()->getData_emissao())); ?>
                                    </td>
                                    <td colspan="2">
                                        <label for="oe">Órgão Emissor: </label>
                                        <?php echo $oCurriculo->getOPessoa()->getOrgao_emissor(); ?>
                                    </td>
                                </tr>

                                <tr>
                                    <td colspan="3">
                                        <label for="cpf">CPF: </label>
                                        <?php echo $oCurriculo->getOPessoa()->getCpf(); ?>
                                    </td> 
                                    <td colspan="3">
                                        <label for="resevista">Resevista:</label>
                                        <?php echo $oCurriculo->getOPessoa()->getReservista(); ?>
                                    </td>                                        
                                </tr>

                                <tr>
                                    <td colspan="3">
                                        <label for="conselho">Conselho: </label>
                                        <?php echo $oCurriculo->getOPessoa()->getConselho(); ?>
                                    </td> 
                                    <td colspan="3">
                                        <label for="nconselho">Número: </label>
                                        <?php echo $oCurriculo->getOPessoa()->getConselho_numero(); ?>
                                    </td>                                        
                                </tr>

                                <tr>
                                    <td colspan="2">
                                        <label for="ctps">CTPS: </label>
                                        <?php echo $oCurriculo->getOPessoa()->getCtps(); ?>
                                    </td> 
                                    <td colspan="2">
                                        <label for="serie">Série: </label>
                                        <?php echo $oCurriculo->getOPessoa()->getSerie(); ?>
                                    </td>
                                    <td colspan="2">
                                        <label for="emissor">Emissor: </label>
                                        <?php echo $oCurriculo->getOPessoa()->getEmissor_ctps(); ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="6">
                                        <label><h3>Cargo Escolhido: </h3></label> <?php echo utf8_encode($oCurriculo->getOArea_cargo()->getNome()); ?>                                              
                                    </td>

                                </tr>
                            </table>

                        </div>
                    </div>
                </fieldset>


                <div class="row text-center">
                    <div class="col-md-12 text-center"><br /><br /><br />
                        LIMOEIRO DO NORTE, ________ DE ________________ DE 2017.<br /><br /><br /><br /><br />

                        ______________________________________<br />
                        Assinatura do candidato (a) 

                    </div>
                    <br /><br /><br /><br /><br />                    
                    <div class="col-md-12 text-center"><br /><br /><br />
                        <img height="60" src="imagens/rodape.jpg" />
                        <br />
                        <br />
                        <br />
                    </div>

                    <div class="mensagem text-center">                        
                        <button type="button" class="btn btn-success" onclick="window.print()">
                            <i class="glyphicon glyphicon-print"></i>
                            Imprimir
                        </button>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>