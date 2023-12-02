<?php include "../Template/header.php";?>
<?php 
        $query= "SELECT MAX(id_dieta) AS 'id_ultimo' FROM Granja.Dieta;
        ";
        $result= mysqli_query($conn,$query);
        if (mysqli_num_rows($result)==1) { 
            $row=mysqli_fetch_array($result);
            $id=$row['id_ultimo'];
    }
?>
<div class="text-center"><h1>EDITOR DE DIETAS</h1></div>
<div class="container p-4">
    <div class="row">
        <!-- MESSAGES -->
        <?php if (!empty($message) && !empty($messageType)) : ?>
            <div class="alert alert-<?php echo $messageType; ?> alert-dismissible fade show" role="alert">
                <strong><?php echo $message; ?></strong>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        <?php endif; ?>
        <div class="col-md-6">
            <!-- Tabla de productos búsqueda -->
            <div class="table-container">
                <h2 class="table-title">Alimentos en existencia</h2>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Stock</th>
                            <th>Alimento</th>
                            <th>Precio por unidad</th>
                            <th>Cantidad a añadir</th>
                            <th>Acción</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $query = "SELECT P.Producto, S.cantidad, S.precio, P.id_producto
                        FROM Granja.Producto P
                        INNER JOIN Granja.Stock S ON P.id_producto = S.id_producto
                        WHERE P.categoria = 1;";
                        $select_productos = mysqli_query($conn, $query);
                        while ($row = mysqli_fetch_array($select_productos)) {
                            $maxCantidad = $row['cantidad'];
                            ?>
                            <tr>
                                <td><?php echo $row['cantidad']; ?></td>
                                <td><?php echo $row['Producto']; ?></td>
                                <td><?php echo $row['precio']; ?></td>
                                <td>
                                    <form action="agregar_producto_receta.php?id=<?php echo $id ?>" method="POST">
                                        <input type="number" min="1" name="cantidad_max" max="<?php echo $maxCantidad; ?>" class="form-control" value="1">
                                        <input type="hidden" name="id_producto" value="<?php echo $row['id_producto']; ?>">
                                        <input type="hidden" name="id_dieta" value="<?php $id ?>">
                                </td>
                                <td>
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fa-solid fa-circle-plus"></i>
                                    </button>
                                    </form>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
        <?php 
if (isset($_GET['id'])) {
        $id=$_GET['id'];
    }
?>
        <div class="col-md-6">
            <!-- Tabla de productos compra -->
            <div class="table-container">
                <h2 class="table-title">Alimentos de la dieta</h2>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Alimento</th>
                            <th>Cantidad</th>
                            <th>Precio por unidad</th>
                            <th>Acción</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $query = "CALL `ObtenerDetallesDieta`($id);";
                        $select_dieta = mysqli_query($conn, $query);   
                        echo $query;                   
                        while ($row = mysqli_fetch_array($select_dieta)) {
                            ?>
                            <tr>
                                <td><?php echo $row['Producto']; ?></td>
                                <td><?php echo $row['cantidad']; ?></td>
                                <td><?php echo $row['precio']; ?></td>
                                <td>
                                    <form action="delete_venta.php" method="POST">
                                    <button type="submit" class="btn btn-danger">
                                        <i class="fa-solid fa-eraser"></i>
                                    </button>
                                    <a href="?id=<?php echo $row['id_producto']; ?>">
                                        
                                    </form>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<div>
    <form action="venta_realizada.php" method="POST">
    <div class="text-center">
        <div class="m-2">
        <a href="../comida.php"> xd</a>
    </div>
</div>

<?php include '../Template/footer.php'; ?>