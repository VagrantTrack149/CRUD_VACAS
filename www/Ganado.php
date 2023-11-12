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
            <button class="btn btn-success" type="button"><i class="fa-solid fa-cow"></i><i class="fa-solid fa-plus"></i></button>
          </div>
        </div>
      </div>
    </div>
    <table class="table table-bordered">
      <thead>
        <tr>
          <th>Lote</th>
          <th>Cantidad de animales</th>
          <th>Opciones</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td>1</td>
          <td><h8> Contador</h8></td>
          <td><button class="btn btn-success apply"><i class="fa-solid fa-cow"></i></button></td>
        </tr>
      </tbody>
    </table>
  </div>
</div>  <?php include 'Template/footer.php'; ?>
