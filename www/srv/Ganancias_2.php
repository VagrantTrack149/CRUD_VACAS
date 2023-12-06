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
    <div class="text-center mt-3">
        <a type="button" class="btn btn-primary" href="../Ganancias.php">Compra y venta resumen</a>
        <!--<a type="button" class="btn btn-secondary ml-2" href="./Ganancias_3.php">Ver Historial de lotes</a>-->
    </div>
</div>  
<?php include '../Template/footer.php'; ?>
