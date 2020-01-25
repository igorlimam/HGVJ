<style>
    #inscricao{
        font-size: 14px;
        font-family: arial;
        color: #000;
    }
</style>

<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading text-center">
                    <h4>Processo Seletivo - Edital 001/2017</h4>
                    <h4>Relatório de Inscritos</h4>
                </div>
                <div class="panel-body">
                    <div class="mensagem text-center">
                        <button type="button" class="btn btn-success" onclick="window.print()">
                            <i class="glyphicon glyphicon-print"></i>
                            Imprimir
                        </button>
                        <br />
                        <br />
                    </div>
                    <table class="table table-striped">                       



                        <tbody>

                            <?php
                            if (count($oCurriculos) > 0) {
                                $total = 0;
                                foreach ($oCurriculos as $key => $vCargos) {
                                    if (count($vCargos) >= 1) {
                                        ?>
                                        <tr>
                                            <th><h4>CIDADE:</h4></th> 
                                            <th colspan="3">
                                                <h4><?php echo $key . "<br>"; ?></h4>
                                                <?php //echo $key . "<br>"; ?>
                                            </th>
                                        </tr>
                                        <?php
                                        $subTotal = 0;
                                        foreach ($vCargos as $key2 => $vCidades) {
                                            if (count($vCidades) > 0) {
                                                ?>
                                                <tr>

                                                    <th></th>
                                                    <th colspan="2">
                                                        <h5><strong>CARGO: <?php echo utf8_encode($key2) . "<br>"; ?></strong></h5>
                                                    </th>
                                                    <th><h5><strong>QTDE.: <?php
                                                        $total += count($vCidades);
                                                        $subTotal += count($vCidades);
                                                        echo count($vCidades);
                                                        ?></strong></h5>
                                                    </th>
                                                </tr>
                                                <tr>
                                                    <th>N&ordm;</th>
                                                    <th style="width:15%">Data de Inscrição</th>                                                              
                                                    <th>Nome</th>
                                                    <th>CPF</th>         
                                                    <!--<th>Cargo</th>-->
                                                </tr>
                                                <?php
                                            }
                                            foreach ($vCidades as $oCurriculo) {
                                                ?>

                                                <tr>
                                                    <td><?php echo $oCurriculo->getId(); ?></td>
                                                    <td class="text-center"><?php echo date('d/m/Y', strtotime($oCurriculo->getData_submissao())); ?></td>                                               
                                                    <td><?php echo strtoupper($oCurriculo->getOPessoa()->getNome()); ?></td>
                                                    <td><?php echo $oCurriculo->getOPessoa()->getCpf(); ?></td>
                                                   <!-- <td><?php
                                                    //echo utf8_encode($oCurriculo->getOArea_cargo()->getNome()) . "<br>";                                                    
                                                    ?></td>-->
                                                </tr>
                                                <?php
                                            }
                                        }
                                        ?>

                                        <tr>
                                            <th colspan = "3" class = "text-right"><h5><strong>SUBTOTAL DE INSCRITOS:</strong></h5></th>
                                            <th>
                                               <h5><strong><?php echo $subTotal; ?></strong></h5>
                                            </th>

                                        </tr> <?php
                                    }
                                }
                                ?>
                                <tr>
                                    <th colspan="3" class="text-right"><h4>TOTAL DE INSCRITOS:</h4></th>
                                    <th>
                                        <h4><?php echo $total; ?></h4>
                                    </th>

                                </tr> <?php
                            } else {
                                echo "Nenhum resultado encontrado.";
                            }
                            ?>
                        </tbody>
                    </table>
                    <div class="mensagem text-center">
                        <br />
                        <br />
                        <button type="button" class="btn btn-success" onclick="window.print()">
                            <i class="glyphicon glyphicon-print"></i>
                            Imprimir
                        </button>
                        <br />
                        <br />
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>