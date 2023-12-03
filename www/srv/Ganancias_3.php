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
                        <th>Fecha llegada</th>
                        <th>Costes(Totales o hasta ahora)($)</th>
                        <th>Fecha salida</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    $query1 = "CALL ShowHistorial();";
                    $select_consumos = mysqli_query($conn, $query1);

                    if ($select_consumos) {
                        while ($row = mysqli_fetch_array($select_consumos)) {
                    ?>
                    <tr>
                        <td><?php echo $row['lote']?></td>
                        <td><?php echo $row['fecha_1']?></td>
                        <td><?php echo $row['dinero']?></td>
                        <td><?php echo $row['fecha_2']?></td>
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
