<?php 
    session_start();
    include 'Template/header.php'; 
    if (!isset($_SESSION['usuario'])) {
        header("location:index.php");
    }
    $query= " SELECT MAX(Lote) AS 'ULote' FROM Granja.Lote; ";
        $result= mysqli_query($conn,$query);
        if (mysqli_num_rows($result)==1) { 
            $row=mysqli_fetch_array($result);
            $ULote=$row['ULote'];
    }
?>   
<link rel="stylesheet" href="style/Control.css">
<div class="container d-flex">
  <div class="col-md-6 flex-fill">
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Menu de Comida</h3>
       </div>
      <div class="card-body">
        <div class="form-group">
          <form action="srv/comida_plus.php" method="POST">
          <label for="campo1">Descripción</label>
            <input type="text" class="form-control" id="campo1" name="Descripcion">
        </div>
        <div class="form-group">
          <label for="campo2">Cantidad</label>
            <input type="text" class="form-control" id="campo2" name="Cantidad">
        </div>
        <div class="form-group">
          <label for="campo3">Precio</label>
            <input type="text" class="form-control" id="campo3" name="Precio">
        </div>
          <button type="submit" class="btn btn-primary">Añadir</button>
        </form>
          <a class="btn btn-success" type="button" href="./srv/Receta_plus.php">Añadir receta <i class="fa-solid fa-utensils"></i><i class="fa-solid fa-plus"></i></a>
        </div>
      </div>
  </div>

  <div class="col-md-6 flex-fill">
    <div class="row">
      <div class="col-md-12">
        <div class="input-group mb-3">
          
        </div>
      </div>
    </div>
    <table class="table table-bordered">
      <thead>
                <tr>
                    <th>Cantidad</th>
                    <th>Alimento</th>
                    <th>Precio por unidad</th>
                    <th>Editar y Eliminar</th>
                </tr>
            </thead>
            <tbody>
            <?php
              $query = "SELECT P.Producto, S.cantidad, S.precio, P.id_producto
              FROM Granja.Producto P
              INNER JOIN Granja.Stock S ON P.id_producto = S.id_producto
              WHERE P.categoria = 1;
          ";
              $select_lotes = mysqli_query($conn, $query);
              while ($row = mysqli_fetch_array($select_lotes)) {
            ?>
      
                <tr>
                    <td><?php echo $row['cantidad'] ?></td>
                    <td><?php echo $row['Producto'] ?></td>
                    <td><?php echo $row['precio'] ?></td>
                    <td>
                        <a role="button" aria-disabled="true" class="btn btn-primary apply" href="./srv/Editar_comida.php?id=<?php echo $row['id_producto']?>"><i class="fa-solid fa-pen-to-square"></i></a>
                        <a class="btn btn-danger delete" href="./srv/Eliminar_comida.php?id=<?php echo $row['id_producto']?>"><i class="fa-solid fa-trash"></i></a>
                    </td>
                </tr>
                <?php }?>
            </tbody>
        </table>
    </div>
</div>
    
<div class="col-md-8 mx-auto">
  <table class="table table-bordered Taco">
    <thead>
      <tr>
        <th>Dieta</th>
        <th>Receta</th>
        <th>Lote</th>
        <th>Opciones</th>
      </tr>
    </thead>
    <tbody>
      <?php
        $query = "CALL `MostrarDetallesDieta_General`();";
        $select_lotes = mysqli_query($conn, $query);
        while ($row = mysqli_fetch_array($select_lotes)) {
      ?>
      <tr>
        <td><?php echo $row['NombreDieta'] ?></td>
        <td><?php echo $row['DetalleProducto'] ?></td>
        <form action="./srv/Consumir_receta.php" method="POST">
        <td><input type="number" min="1" name="lote" max="<?php echo $ULote; ?>" class="form-control" value="1"></td>
            <input type="hidden" name="id_dieta" id="id_dieta" value="<?php echo $row['id_dieta']; ?>"> 
        <td>
          <button class="btn btn-success apply" type="submit">
            <i class="fa-solid fa-plate-wheat"></i>
          </button>
        </form>
          <a role="button" aria-disabled="true" class="btn btn-primary apply" href="srv/Receta_detalles.php?id=<?php echo $row['id_dieta']; ?>">
            <i class="fa-solid fa-cow"></i>
          </a>
          <a role="button" aria-disabled="true" class="btn btn-danger apply" href="srv/Eliminar_receta.php?id=<?php echo $row['id_dieta']; ?>">
            <i class="fa-solid fa-delete-left"></i>
          </a>
        </td>
      </tr>
      <?php } ?>
    </tbody>
  </table>
  </div>


<?php include 'Template/footer.php'; ?>
