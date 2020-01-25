<?php if(isset($_SESSION['permissao']) && $_SESSION['permissao'] == 'Administrador'){ ?>
<form action="?area=<?php echo $_GET['area']; ?>" method="post">		
    <div class="col-md-8 form-group">
        <input autocomplete="off" class="form-control" name="busca" type="text">
    </div>
    <div class="col-md-4 form-group">
        <button class="btn button-color btn-block" name="acao" value="btBuscar" type="submit" title="Buscar">
            <span class="glyphicon glyphicon-search"></span> 
             Pesquisar
        </button>
    </div>
    
</form>
<?php } ?>