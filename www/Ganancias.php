<?php 
    session_start();
    include 'Template/header.php'; 
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
        <table class="table table-bordered">
            <thead>
                <h4>Compra y venta resumen</h4>
                <tr>
                    <th>Fecha</th>
                    <th>Ganadero</th>
                    <th>Tipo</th>
                    <th>Total($)</th>
                    <th>Lote</th>
                    <th>Origen</th>
                    <th>Destino</th>
                    <th>Comentario</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                $query = "CALL MostrarFacturas();";
                $select_lotes = mysqli_query($conn, $query);

                if ($select_lotes) {
                    while ($row = mysqli_fetch_array($select_lotes)) {
                ?>
                <tr>
                    <td><?php echo $row['Fecha']?></td>
                    <td><?php echo $row['Ganadero']?></td>
                    <td><?php echo $row['Tipo_VC']?></td>
                    <td><?php echo $row['Total']?></td>
                    <td><?php echo $row['Lote']?></td>
                    <td><?php echo $row['Origen']?></td>
                    <td><?php echo $row['Destino']?></td>
                    <td><?php echo $row['Comentario']?></td>
                </tr>
                <?php 
                    }
                } else {
                    echo "Error en la consulta: " . mysqli_error($conn);
                }
                ?>
            </tbody>
        </table>
    </div>
    <div class="text-center mt-3">
        <a type="button" class="btn btn-primary" href="./srv/Ganancias_2.php">Ver consumos por lote</a>
        <a type="button" class="btn btn-secondary ml-2" href="./srv/Ganancias_3.php">Ver el historial de los lotes</a>
    </div>
</div>  
<?php include 'Template/footer.php'; ?>
