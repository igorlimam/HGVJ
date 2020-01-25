<?php
        
        require_once "../modelo/ExameCategoria.class.php";
        require_once "../modelo/Exame.class.php";
        require_once "../dao/ExameDAO.class.php";
        
        $exameCategoria = new ExameCategoria();
        $exameDAO = new ExameDAO();
        
        $exameCategoria = $exameDAO->buscarPorCategoria($_REQUEST['id']);
        
        echo '<option selected="selected" value="">Selecione</option>';
        foreach($exameCategoria as $exame){
            ?>
        
        <option value="<?= $exame->getId() ?>"><?= $exame->getNome() ?></option>  
        <?php }
        ?>
            