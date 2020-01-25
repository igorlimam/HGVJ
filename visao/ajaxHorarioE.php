<?php
	$horarios = "'horariosE'";
	if(!isset($_REQUEST['id'])){
            echo "<table class='table table-stripped table-bordered'>";
        echo "<thead>";
        echo "<th>Horário</th>";
        echo "<th class='col-md-1'>Excluir</th>";
        echo "</thead>";
        echo "<tbody id=".$horarios.">";
		//Se já existir o arquivo, carrega-o, fecha e o reabre para novas gravações
		if(file_exists('horariosE.txt')){
			$id = 0;
			$leitura = fopen('horariosE.txt','r');
			$arrayHorarios = array();
			$arrayHorarios = explode(",",fgets($leitura,4096));
			while(count($arrayHorarios) > 1){
                                
				echo "<tr>";
				echo "<td>".$arrayHorarios[1]."</td>";
				echo '<td class="col-md-1">
						<button class="btn btn-danger" type="button" value="btExcluir" name="acao" onclick="excluirHorarioE('.$arrayHorarios[0].','.$horarios.')">
							 <i class="glyphicon glyphicon-trash" title="Excluir"></i>
						</button>    
					 </td>';           
				echo "</tr>";
				$id = $arrayHorarios[0];
				$arrayHorarios = explode(",",fgets($leitura,4096));
			}
			fclose($leitura);
			//unlink(filePath)
			$escrita = fopen('horariosE.txt','a');
                        --$id;
                        fwrite($escrita,$id.",".$_REQUEST['time']."\r\n");

                        echo "<tr>";
                        echo "<td>".$_REQUEST['time']."</td>";
                        echo '
                                  <td class="col-md-1">
                                        <button class="btn btn-danger" type="button" value="btExcluir" name="acao" onclick="excluirHorarioE('.$id.','.$horarios.')">
                                                 <i class="glyphicon glyphicon-trash" title="Excluir"></i>
                                        </button>    
                                 </td>';           
                        echo "</tr>";
			fclose($escrita);
		}else{
			//Caso o arquivo ainda não exista
			$id = -1;
                        $escrita = fopen('horariosE.txt','a');
                        fwrite($escrita,$id.",".$_REQUEST['time']."\r\n");
                        fclose($escrita);
                        echo "<tr>";
                        echo "<td>".$_REQUEST['time']."</td>";
                        echo '
                                  <td class="col-md-1">
                                        <button class="btn btn-danger" type="button" value="btExcluir" name="acao" onclick="excluirHorarioE('.$id.','.$horarios.')">
                                                 <i class="glyphicon glyphicon-trash" title="Excluir"></i>
                                        </button>    
                                 </td>';           
                        echo "</tr>";
                        --$id;
		}
                echo "</tbody>";
        echo "</table>";
	}else{
		$arrayArquivo = array();
		$arrayResult = array();
		$cont = 0;
		$arrayArquivo = file('horariosE.txt');
		foreach($arrayArquivo as $array){
			$arrayHorario = explode(',',$array);
			if($arrayHorario[0] == $_REQUEST['id']){
				continue;
			}
			$arrayResult[$cont] = implode(",",$arrayHorario);
			++$cont;
		}
		
		//apagando o conteudo do arquivo
		file_put_contents("horariosE.txt", "");
		//gravando no mesmo arquivo
		$escrita = fopen('horariosE.txt','a');
		foreach($arrayResult as $array){
			fwrite($escrita, $array);
		}
		fclose($escrita);
		
		//exibindo a tabela
		$leitura = fopen('horariosE.txt','r');
		$arrayHorarios = array();
		$arrayHorarios = explode(",",fgets($leitura,4096));
		while(count($arrayHorarios) > 1){
			echo "<tr>";
			echo "<td>".$arrayHorarios[1]."</td>";
			echo '	 
				  <td class="col-md-1">
					<button class="btn btn-danger" type="button" value="btExcluir" name="acao" onclick="excluirHorarioE('.$arrayHorarios[0].','.$horarios.')">
						 <i class="glyphicon glyphicon-trash" title="Excluir"></i>
					</button>    
				 </td>';           
			echo "</tr>";
			$arrayHorarios = explode(",",fgets($leitura,4096));
		}
		fclose($leitura);
	}
        
?>