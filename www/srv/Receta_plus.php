<?php
include '../Template/header.php';
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
                <h2 class="table-title">Comida disponible</h2>
                <div class="input-group mb-3">
                    <div class="dropdown">
                        <form action="agregar_comida_receta.php" method="POST">
                        <select class="form-select" aria-label="Default select example" name="receta_comida">
                            <option selected value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="4">4</option>
                            <option value="5">5</option>
                            <option value="6">6</option>
                            <option value="7">7</option>
                            <option value="8">8</option>
                            <option value="9">9</option>
                            <option value="10">10</option>
                            <option value="11">11</option>
                            <option value="12">12</option>
                            <option value="13">13</option>
                            <option value="14">14</option>
                            <option value="15">15</option>
                        </select>
                    </div>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Alimento</th>
                            <th>Cantidad</th>
                            <th>Precio</th>
                            <th>Cantidad a comprar</th>
                            <th>Accion</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $query = "SELECT * FROM `Comida`";
                        $select_productos = mysqli_query($conn, $query);

                        while ($row = mysqli_fetch_array($select_productos)) {
                            $maxCantidad = $row['cantidad'];
                            ?>
                            <tr>
                                <td><?php echo $row['Descripcion']; ?></td>
                                <td><?php echo $row['cantidad']; ?></td>
                                <td><?php echo $row['precio']; ?></td>
                                <td>
                                        <input type="number" min="1" name="cantidad_venta" max="<?php echo $maxCantidad; ?>" class="form-control" value="1">
                                        <input type="hidden" name="id" value="<?php echo $row['id_comida']; ?>">
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

        <div class="col-md-6 salsa" style="margin-right: 20px;">
            <!-- Tabla de productos compra -->
            <div class="table-container">
                <h2 class="table-title">Receta</h2>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Alimento</th>
                            <th>Cantidad</th>
                            <th>Precio</th>
                            <th>Acción</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $query = "SELECT
                        dr.cantidad AS Cantidad_Receta,
                        c.precio AS Precio_Comida,
                        c.Descripcion AS Descripcion_Comida
                    FROM
                        Granja.detallerecetas dr
                    JOIN
                        Granja.Comida c ON dr.id_comida = c.id_comida
                    WHERE id_receta_comida =";
                        $select_productos = mysqli_query($conn, $query);
                        while ($row = mysqli_fetch_array($select_productos)) {
                            ?>
                            <tr>
                                <td><?php echo $row['Descripcion_Comida']; ?></td>
                                <td><?php echo $row['Cantidad_Receta']; ?></td>
                                <td><?php echo $row['Precio_Comida']; ?></td>
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
    <a href="Registrar_receta.php">
        :D
    </a>
</div>
<?php include '../Template/footer.php'; ?>
