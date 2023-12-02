<?php 
    session_start();
    include 'Template/header.php'; 
    if (!isset($_SESSION['usuario'])) {
        header("location:index.php");
    }
?>
<?php 
    if(isset($_GET['id'])){
        $id=$_GET['id'];
        $query= "SELECT * FROM ganadero WHERE psg = '$id'";
        $result= mysqli_query($conn,$query);
        if (mysqli_num_rows($result)==1) { 
            $row=mysqli_fetch_array($result);
            $id =$row['psg'];
            $Name =$row['nombre'];
            $Rancho=$row['razonsocial'];
            $Domicilio=$row['domicilio'];
            $Localidad=$row['localidad'];
            $Municipio=$row['Municipio'];
            $Estado=$row['Estado'];
        }}?>
<link rel="stylesheet" href="style/Compra_venta.css">
<div class="container-sm card-group">
    <div class="card">
        <h4>Ganadero (PSG)</h4>
        <div class="card-body">
      <div class="form-group">
        <form action="./srv/Ganadero_plus.php" method="POST">
        <label for="campo1">PSG</label>
        <input type="text" class="form-control" id="campo1" name="PSG" value="<?php echo $id ?>">
      </div>
      <div class="form-group">
        <label for="campo2">Nombre Completo</label>
        <input type="text" class="form-control" id="campo2" name="NAME" value="<?php echo $Name ?>">
      </div>
      <div class="form-group">
        <label for="campo3">Rancho</label>
        <input type="text" class="form-control" id="campo3" name="RANCH" value="<?php echo $Rancho ?>">
      </div>
      <div class="form-group">
        <label for="campo3">Domicilio</label>
        <input type="text" class="form-control" id="campo3" name="ADRESS" value="<?php echo $Domicilio ?>">
      </div>
      <div class="form-group">
        <label for="campo3">Localidad</label>
        <input type="text" class="form-control" id="campo3" name="LOCATION" value="<?php echo $Localidad ?>">
      </div>
      <div class="form-group">
        <label for="campo3">Municipio</label>
        <input type="text" class="form-control" id="campo3" name="MUNI" value="<?php echo $Municipio ?>">
      </div>
      <div class="form-group">
        <label for="campo3">Estado</label>
        <input type="text" class="form-control" id="campo3" name="STATE" value="<?php echo $Estado ?>">
      </div>
      <button type="submit" class="btn btn-success">Añadir <i class="fa-solid fa-hat-cowboy"></i><i class="fa-solid fa-plus"></i></button>
    </div>
    </form>
    </div>

    <div class="card">
    <h4>Lote detalles</h4>
    <table class="table table-bordered">
        <thead>
            <tr>
                Lote informacion
            </tr>
        </thead>
        <tbody>
            <?php
            $termino = isset($_GET['termino']) ? $_GET['termino'] : '';
            $query = "SELECT Lote, Llegada, Cantidad, Peso_Lote FROM Lote";
            if (!empty($termino)) {
                $query .= " WHERE Lote LIKE '$termino'";
            }
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
            <?php } ?> <!-- Cierra el bucle while aquí -->
        </tbody>
    </table>
</div>

  <div class="card">
    <h4>Operación</h4>
    <div class="card-body">
      <h4 class="card-title">Registro de Venta o Compra</h4>
      
      <form action="procesar_formulario.php" method="post">
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
          <select class="form-control" id="especie" name="especie" disabled>
            <option value="bobino" selected>Bobino</option>
            <!-- Puedes agregar más opciones aquí si es necesario -->
          </select>
        </div>
  </div>
</div>
  <div class="card">
  <div class="card-body">
      <h4 class="card-title">Registro de Total y Fecha</h4>
      
      <form action="procesar_formulario.php" method="post">
        <div class="form-group">
          <label for="total">Total:</label>
          <input type="number" class="form-control" id="total" name="total" required>
        </div>

      </form>
    </div>
  </div>
</div>
<div class="card compra_venta">
  <button type="submit" class="btn-primary">Realizar</button>
</div>

<?php include 'Template/footer.php'; ?>