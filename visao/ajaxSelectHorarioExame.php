<?php
        
        require_once "../Loader.class.php";
        
        $agendaExameDAO = new AgendaExameDAO();
        
        $agendaHorarios = $agendaExameDAO->buscarHorarioPaciente($_GET['diaMesAgendaId']);
        ?> <option selected="selected" value="">Selecione</option> <?php
        foreach($agendaHorarios as $horario){
            ?> <option value="<?php echo $horario->getId() ?>"><?php echo date('H:i',strtotime($horario->getHorario())) ?></option> <?php
        }
        
        
?>
