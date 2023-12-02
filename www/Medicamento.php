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
      <h3 class="card-title">Menu de Medicamento</h3>
    </div>
    <div class="card-body">
      <div class="form-group">
        <form action="./srv/Medicamento_plus.php" method="POST">
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
    </div>
    </form>
  </div>
</div>

<div class="col-md-6 flex-fill">
  <table class="table table-bordered">
    <thead>
      <tr>
        <th>Cantidad</th>
        <th>Medicamento</th>
        <th>Precio</th>
        <TH>Lote</TH>
        <th>Opciones</th>
        
      </tr>
    </thead>
    <tbody>
    <?php
              $query = "SELECT P.Producto, S.cantidad, S.precio, P.id_producto
              FROM Granja.Producto P
              INNER JOIN Granja.Stock S ON P.id_producto = S.id_producto
              WHERE P.categoria = 2;
          ";
              $select_lotes = mysqli_query($conn, $query);
              while ($row = mysqli_fetch_array($select_lotes)) {
            ?>
      
                <tr>
                    <td><?php echo $row['cantidad'] ?></td>
                    <td><?php echo $row['Producto'] ?></td>
                    <td><?php echo $row['precio'] ?></td>
                    <td>
                      <form action="./srv/Consumir_medicina.php" method="POST">
                        <input type="hidden" name="id_producto"  value="<?php echo $row['id_producto']?>">
                        <input type="number" min="1" name="lote" max="<?php echo $ULote; ?>" class="form-control" value="1">
                    </td>
                    <td>  
                        <button class="btn btn-success" type="submit">
                          <i class="fa-solid fa-capsules"></i><i class="fa-solid fa-plus"></i>
                        </button>
                      </form>
                        <a role="button" aria-disabled="true" class="btn btn-primary apply" href="./srv/Editar_medicamento.php?id=<?php echo $row['id_producto']?>"><i class="fa-solid fa-pen-to-square"></i></a>
                        <a class="btn btn-danger delete" href="./srv/Eliminar_medicina.php?id=<?php echo $row['id_producto']?>"><i class="fa-solid fa-trash"></i></a>
                    </td>
                </tr>
                <?php }?>
    </tbody>
  </table>
</div>

</div>
<?php include 'Template/footer.php'; ?>
