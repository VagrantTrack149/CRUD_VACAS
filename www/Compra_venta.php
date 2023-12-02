<?php 
include 'Template/header.php'; 
if (!isset($_SESSION['usuario'])) {
    header("location:index.php");
}

// Obtener PSG y Lote de la URL
if(isset($_GET['psg']) && isset($_GET['lote'])){
    $psg = $_GET['psg'];
    $lote = $_GET['lote'];

    // Obtener información del ganadero
    $query_ganadero = "SELECT * FROM ganadero WHERE psg = '$psg'";
    $result_ganadero = mysqli_query($conn, $query_ganadero);
    if(mysqli_num_rows($result_ganadero) == 1) { 
        $row_ganadero = mysqli_fetch_array($result_ganadero);
        $id = $row_ganadero['psg'];
        $Name = $row_ganadero['nombre'];
        $Rancho = $row_ganadero['razonsocial'];
        $Domicilio = $row_ganadero['domicilio'];
        $Localidad = $row_ganadero['localidad'];
        $Municipio = $row_ganadero['Municipio'];
        $Estado = $row_ganadero['Estado'];
    }
}
?>
<link rel="stylesheet" href="style/Compra_venta.css">
<div class="container-sm card-group">
    <div class="card ">
        <h4>Ganadero (PSG)</h4>
        <div class="card-body">
            <div class="form-group">
                <label for="campo1">PSG</label>
                <input type="text" class="form-control" id="campo1" name="PSG" value="<?php echo $id ?>" disabled>
            </div>
            <div class="form-group">
                <label for="campo2">Nombre Completo</label>
                <input type="text" class="form-control" id="campo2" name="NAME" value="<?php echo $Name ?>" disabled>
            </div>
            <div class="form-group">
                <label for="campo3">Rancho</label>
                <input type="text" class="form-control" id="campo3" name="RANCH" value="<?php echo $Rancho ?>" disabled>
            </div>
            <div class="form-group">
                <label for="campo3">Domicilio</label>
                <input type="text" class="form-control" id="campo3" name="ADRESS" value="<?php echo $Domicilio ?>" disabled>
            </div>
            <div class="form-group">
                <label for="campo3">Localidad</label>
                <input type="text" class="form-control" id="campo3" name="LOCATION" value="<?php echo $Localidad ?>" disabled>
            </div>
            <div class="form-group">
                <label for="campo3">Municipio</label>
                <input type="text" class="form-control" id="campo3" name="MUNI" value="<?php echo $Municipio ?>" disabled>
            </div>
            <div class="form-group">
                <label for="campo3">Estado</label>
                <input type="text" class="form-control" id="campo3" name="STATE" value="<?php echo $Estado ?>" disabled>
            </div>
        </div>
    </div>

    <div class="card">
        <h4>Lote detalles</h4>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Lote informacion</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $query = "SELECT Lote, Llegada, Cantidad, Peso_Lote FROM Lote WHERE lote=$lote";
                $select_lotes = mysqli_query($conn, $query);
                while ($row = mysqli_fetch_array($select_lotes)) {
                ?>
                <tr>
                    <td> Lote: <?php echo $row['Lote'] ?></td>
                </tr>
                <tr>
                    <td>Fecha de llegada: <?php echo $row['Llegada'] ?></td>
                </tr>
                <tr>
                    <td>Cantidad de animales: <?php echo $row['Cantidad'] ?></td>
                </tr>
                <tr>
                    <td>Peso(KG): <?php echo $row['Peso_Lote'] ?></td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
<form action="./srv/procesar_formulario.php" method="POST">
        <div class="card">
            <h4>Operación</h4>
            <div class="card-body">
                <h4 class="card-title">Registro de Venta o Compra</h4>
                    <div class="form-group">
                        <label for="operacion">Operación:</label>
                        <select class="form-control" id="operacion" name="operacion">
                            <option value="venta">Venta</option>
                            <option value="compra">Compra</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="origen">Origen:</label>
                        <input type="text" class="form-control" id="origen" name="origen" required>
                    </div>

                    <div class="form-group">
                        <label for="destino">Destino:</label>
                        <input type="text" class="form-control" id="destino" name="destino" required>
                    </div>

                    <div class="form-group">
                        <label for="especie">Especie:</label>
                            <select class="form-control" id="especie" name="especie">
                                <option value="bobino" selected>Bobino</option>
                            </select>
                    </div>
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Registro de Total y Fecha</h4>
                        <div class="form-group">
                            <label for="total">Total:</label>
                                <input type="number" class="form-control" id="total" name="total" required>
                            <label for="comentario">Comentario:</label>
                                <input type="text" name="comentario" id="comentario" class="form-control" required>
                                <input type="hidden" name="id_ganadero" value="<?php echo $psg?>">
                                <input type="hidden" name="lote" value="<?php echo $lote?>">
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn-primary">Relizar</button>
                        </div>
            </div>
        </div>
</form>
</div>
<?php include 'Template/footer.php'; ?>