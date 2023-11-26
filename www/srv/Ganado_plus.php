<?php 
    include "../Template/header.php";
    if (isset($_GET['Lote'])) {
        $lote=$_GET['Lote'];
    }
?>
<div class="container p-4">
    <div class="row">
        <div class="col-md-4 mx-auto">
            <div class="card card-body">
                <form action="Ganado_plus_2.php" method="POST">
                <div class="from-group">
                        <input type="text" name="Numero_de_arete" value="" class="from-control" placeholder="Numero de arete">
                    </div>
                    <div class="from-group">
                        <input type="text" name="Sexo" class="from-control" placeholder="Sexo 1-MACHO 0-HEMBRA">
                    </div>
                    <div class="from-group">
                        <input type="text" name="Edad" class="from-control" placeholder="Edad(meses)">
                    </div>
                    <div class="from-group">
                        <input type="text" name="Lote" value="<?php   echo $lote;   ?>" class="from-control" placeholder="Lote">
                    </div>
                    <div class="from-group">
                        <input type="text" name="Peso"  class="from-control" placeholder="Peso(kg)">
                    </div>
                    <div class="from-group">
                        <input type="text" name="Estado"  class="from-control" placeholder="Engorda, Defunsión, etc">
                    </div>
                    <div class="from-group">
                        <input type="text" name="Precio"  class="from-control" placeholder="($)Precio">
                    </div>
                        <input type="submit" class="btn btn-success btn-block" name="Guardar" value="Actualizar ganado">
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php include '../Template/footer.php'; ?>