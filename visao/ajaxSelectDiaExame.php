<?php
        
        require_once "../Loader.class.php";
        
        $agendaExameDAO = new AgendaExameDAO();
        
        $agendaHorarios = $agendaExameDAO->exibirAgendaPaciente($_GET['exame_id']);
        $mes = date('m',$_GET['timeMes']);
        $ano = date('Y',$_GET['timeMes']);
        $arraySemana = Array('Monday'=>'Segunda-feira','Tuesday'=>'Terça-feira','Wednesday'=>'Quarta-feira','Thursday'=>'Quinta-feira','Friday'=>'Sexta-feira','Saturday'=>'Sábado');
        $arrayDias = Array();
        date_default_timezone_set ('America/Sao_Paulo');
        //echo strtotime($ano."-".$mes."-01");
        foreach($agendaHorarios as $agenda){
            $arrayPiece = $agenda->getOAgenda();
            if($arrayPiece['dia_semana'] == 1){
                $dia = 'Monday';
            }else if($arrayPiece['dia_semana'] == 2){
                $dia = 'Tuesday';
            }else if($arrayPiece['dia_semana'] == 3){
                $dia = 'Wednesday';
            }else if($arrayPiece['dia_semana'] == 4){
                $dia = 'Thursday';
            }else if($arrayPiece['dia_semana'] == 5){
                $dia = 'Friday';
            }else if($arrayPiece['dia_semana'] == 6){
                $dia = 'Saturday';
            }
            $time = strtotime('first '.$dia.' of '.$ano."-".$mes."-01");
            //echo date("d",$time)."<br>";
            while(date("d",$time) <= 31 && date('m',$time) == $mes){
                $arrayDias[] = Array('date'=>date("d",$time),'dia'=>$arraySemana[$dia],'agenda_id'=>$agenda->getAgenda_id());
                $dateTime = date('Y-m-d',$time);
                $time = strtotime($dateTime."next ".$dia);
            }
        }
        sort($arrayDias);
        ?> <option selected="selected" value="">Selecione</option> <?php
        foreach($arrayDias as $dia){
            ?> <option value="<?php echo $dia['date'].",".$dia['agenda_id'] ?>"><?php echo $dia['date']." / ".$dia['dia'] ?></option> <?php
        }
        
?>
