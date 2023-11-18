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
          </div>
        </div>
      </div>
    </div>
    <table class="table table-bordered">
      <thead>
        <tr>
          <th>Fecha</th>
          <th>Implicados(Responsable, Vendedor,Comprador,Monto,Lote)</th>
          <th>Opciones</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td>Bebiernes</td>
          <td><h8> Pedro compro un zapato a juan</h8></td>
          <td><button class="btn btn-success apply" href="./Informacion_trans.php"><i class="fa-solid fa-circle-info"></i></button></td>
        </tr>
      </tbody>
    </table>
  </div>
</div>  <?php include 'Template/footer.php'; ?>
