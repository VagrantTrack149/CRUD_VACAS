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
        <label for="campo1">Descripción</label>
        <input type="text" class="form-control" id="campo1" name="campo1">
      </div>
      <div class="form-group">
        <label for="campo2">Cantidad</label>
        <input type="text" class="form-control" id="campo2" name="campo2">
      </div>
      <div class="form-group">
        <label for="campo3">Precio</label>
        <input type="text" class="form-control" id="campo3" name="campo3">
      </div>
      <button type="submit" class="btn btn-primary">Añadir</button>
      <button class="btn btn-secondary" href="Almacen_comida.php">Almacen de comida</button>
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
            <button class="btn btn-success" type="button" href="./srv/Receta_plus.php"><i class="fa-solid fa-utensils"></i><i class="fa-solid fa-plus"></i></button>
          </div>
        </div>
      </div>
    </div>
  <table class="table table-bordered">
    <thead>
      <tr>
        <th>Etapa</th>
        <th>Recetas</th>
        <th>Consumir, Editar y Eliminar</th>
        
      </tr>
    </thead>
    <tbody>
      <tr>
        <td>1</td>
        <td><h8> Receta</h4></td>
        <td><button class="btn btn-success apply" href="./srv/Consumir_comida.php"><i class="fa-solid fa-plate-wheat"></i></i>
        <button class="btn btn-primary edit" href="./srv/Editar_comida.php"><i class="fa-solid fa-pen-to-square"></i></button>
        <button class="btn btn-danger delete" href="./srv/Eliminar_comida.php"><i class="fa-solid fa-trash"></i></button></button></td>
      </tr>
      
    </tbody>
  </table>
</div>

</div>
  <?php include 'Template/footer.php'; ?>
