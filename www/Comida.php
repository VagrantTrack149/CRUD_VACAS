<?php 
    session_start();
    include 'Template/header.php'; 
    if (!isset($_SESSION['usuario'])) {
        header("location:index.php");
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
          <input type="text" class="form-control" placeholder="Buscar y añadir recetas" aria-label="Buscar">
            <div class="input-group-append">
              <button class="btn btn-primary" type="button"><i class="fa-solid fa-magnifying-glass"></i></button>
            </div>
        </div>
      </div>
    </div>
    <table class="table table-bordered">
      <thead>
                <tr>
                    <th>Cantidad</th>
                    <th>Alimento</th>
                    <th>Editar y Eliminar</th>
                </tr>
            </thead>
            <tbody>
            <?php
              $query = "SELECT * FROM `Comida`";
              $select_lotes = mysqli_query($conn, $query);
              while ($row = mysqli_fetch_array($select_lotes)) {
            ?>
      
                <tr>
                    <td><?php echo $row['cantidad'] ?></td>
                    <td><?php echo $row['Descripcion'] ?></td>
                    <td>
                        <a role="button" aria-disabled="true" class="btn btn-primary apply" href="./srv/Editar_comida.php?id=<?php echo $row['id_comida']?>"><i class="fa-solid fa-pen-to-square"></i></a>
                        <a class="btn btn-danger delete" href="./srv/Eliminar_comida.php?id=<?php echo $row['id_comida']?>"><i class="fa-solid fa-trash"></i></a>
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
        <th>Etapa</th>
        <th>Receta</th>
        <th>Opciones</th>
      </tr>
    </thead>
    <tbody>
      <?php
        $query = "SELECT
        r.id_receta_comida,
        GROUP_CONCAT(CONCAT(c.Descripcion, ' - ', r.cantidad) SEPARATOR '<br>') AS Descripcion_Cantidad
    FROM
        Granja.Comida c
    INNER JOIN
        Granja.recetas r ON c.id_comida = r.id_comida
    GROUP BY r.id_receta_comida
    LIMIT 0, 25;";
        $select_lotes = mysqli_query($conn, $query);
        while ($row = mysqli_fetch_array($select_lotes)) {
      ?>
      <tr>
        <td><?php echo $row['Etapa'] ?></td>
        <td><?php echo $row['Descripcion_Cantidad'] ?></td>
        <td>
          <button class="btn btn-success apply" href="./srv/Consumir_receta.php">
            <i class="fa-solid fa-plate-wheat"></i>
          </button>
          <a role="button" aria-disabled="true" class="btn btn-primary apply" href="srv/Editar_receta.php?id=<?php echo $row['Lote']; ?>">
            <i class="fa-solid fa-cow"></i>
          </a>
          <a role="button" aria-disabled="true" class="btn btn-danger apply" href="srv/Eliminar_receta.php?id=<?php echo $row['Lote']; ?>">
            <i class="fa-solid fa-delete-left"></i>
          </a>
        </td>
      </tr>
      <?php } ?>
    </tbody>
  </table>
  </div>


<?php include 'Template/footer.php'; ?>
