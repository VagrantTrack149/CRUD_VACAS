<?php 
    session_start();
    include '../Template/header.php'; 
    if (!isset($_SESSION['usuario'])) {
        header("location:index.php");
    }
?>   
<link rel="stylesheet" href="style/Control.css">
<div class="container mx-auto text-center Taco">
    <div class="flex-fill">
        <div class="row">
            <div class="col-md-12">
                <div class="input-group mb-3">
                    <input type="text" class="form-control" placeholder="Buscar" aria-label="Buscar">
                    <div class="input-group-append">
                        <button class="btn btn-primary" type="button"><i class="fa-solid fa-magnifying-glass"></i></button>
                    </div>
                </div>
            </div>
        </div>
        
<div class="container mx-auto text-center taco">
            <table class="table table-bordered">
                <thead>
                    <h4>Consumos por lote resumen</h4>
                    <tr>
                        <th>Lote</th>
                        <th>Dieta</th>
                        <th>Fecha</th>
                        <th>Inversion($)</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    $query1 = "CALL MostrarConsumos();";
                    $select_consumos = mysqli_query($conn, $query1);

                    if ($select_consumos) {
                        while ($row = mysqli_fetch_array($select_consumos)) {
                    ?>
                    <tr>
                        <td><?php echo $row['lote']?></td>
                        <td><?php echo $row['Dieta']?></td>
                        <td><?php echo $row['fecha']?></td>
                        <td><?php echo $row['inversion']?></td>
                    </tr>
                    <?php 
                        }
                    } else {
                        echo "Error en la consulta:";
                    }
                    ?>
                </tbody>
            </table>
        </div>
            </tbody>
        </table>
    </div>
</div>  
<?php include '../Template/footer.php'; ?>
