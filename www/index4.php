<?php
include 'Model/conexion.php';
include 'Template/header.php';
$message = isset($_SESSION['Message']) ? $_SESSION['Message'] : '';
$messageType = isset($_SESSION['Message_type']) ? $_SESSION['Message_type'] : '';

unset($_SESSION['Message']);
unset($_SESSION['Message_type']);
?>

<div class="text-center"><h1>Venta</h1></div>
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
                <h2 class="table-title">Búsqueda</h2>
                <form method="GET" action="buscar.php">
                    <div class="input-group mb-3">
                        <input type="text" class="form-control" name="termino" placeholder="Buscar producto">
                        <button class="btn btn-outline-secondary" type="submit" id="button-addon2">
                            <i class="fa-solid fa-magnifying-glass"></i>
                        </button>
                    </div>
                </form>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Producto</th>
                            <th>Cantidad</th>
                            <th>Precio</th>
                            <th>Cantidad a comprar</th>
                            <th>Acción</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $termino = isset($_GET['termino']) ? $_GET['termino'] : '';
                        $query = "SELECT idProducto, nombreProducto, precio, cantidad FROM Productos";
                        if (!empty($termino)) {
                            $query .= " WHERE nombreProducto LIKE '%$termino%'";
                        }
                        $select_productos = mysqli_query($conn, $query);

                        while ($row = mysqli_fetch_array($select_productos)) {
                            $maxCantidad = $row['cantidad'];
                            ?>
                            <tr>
                                <td><?php echo $row['nombreProducto']; ?></td>
                                <td><?php echo $row['cantidad']; ?></td>
                                <td><?php echo $row['precio']; ?></td>
                                <td>
                                    <form action="agregar_producto_venta.php" method="POST">
                                        <input type="number" min="1" name="cantidad_venta" max="<?php echo $maxCantidad; ?>" class="form-control" value="1">
                                        <input type="hidden" name="id" value="<?php echo $row['idProducto']; ?>">
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

        <div class="col-md-6">
            <!-- Tabla de productos compra -->
            <div class="table-container">
                <h2 class="table-title">Productos a comprar</h2>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Producto</th>
                            <th>Cantidad</th>
                            <th>Precio</th>
                            <th>Acción</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $query = "SELECT p.idProducto, p.nombreProducto, p.precio, p.cantidad, DV.idDetalleVenta, DV.cantidad_venta
                            FROM Productos AS p
                            INNER JOIN DetallesVentas AS DV ON p.idProducto = DV.idProducto;";
                        $select_productos = mysqli_query($conn, $query);

                        while ($row = mysqli_fetch_array($select_productos)) {
                            ?>
                            <tr>
                                <td><?php echo $row['nombreProducto']; ?></td>
                                <td><?php echo $row['cantidad_venta']; ?></td>
                                <td><?php echo $row['precio']; ?></td>
                                <td>
                                    <a href="delete_venta.php?id=<?php echo $row['idProducto']; ?>">
                                        <i class="fa-solid fa-eraser"></i>
                                    </a>
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
        <input type="text" name="Numero_empleado" class="form-control form-control-sm mx-auto d-block" placeholder="NUMERO DE EMPLEADO" maxlength="10" style="width: 200px;" required>
        <div class="m-2">
        <input type="submit" class="btn btn-success btn-block" name="Venta_r" value="Confirmar venta">
        </div>
    </div>
    </form>
    <div class="text-center">
        <div class="m-2">
    <a class="btn btn-primary btn-block" href="index5.php">Historial de ventas</a>
        </div>
    </div>
</div>
<?php include 'Template/footer.php'; ?>
