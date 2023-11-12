<?php 
    session_start();
    include 'Template/header.php'; 
    if (!isset($_SESSION['usuario'])) {
        header("location:index.php");
    }
?>   
<link rel="stylesheet" href="style/Control.css">
<div class="container d-flex">

<div class="col-md-3 justify-content-start">
  <div class="card">
    <div class="card-header">
      <h3 class="card-title">Menu de Ganaderos</h3>
    </div>
    <div class="card-body">
      <div class="form-group">
        <label for="campo1">PSG</label>
        <input type="text" class="form-control" id="campo1" name="campo1">
      </div>
      <div class="form-group">
        <label for="campo2">Nombre Completo</label>
        <input type="text" class="form-control" id="campo2" name="campo2">
      </div>
      <div class="form-group">
        <label for="campo3">Rancho</label>
        <input type="text" class="form-control" id="campo3" name="campo3">
      </div>
      <div class="form-group">
        <label for="campo3">Domicilio</label>
        <input type="text" class="form-control" id="campo3" name="campo3">
      </div>
      <div class="form-group">
        <label for="campo3">Localidad</label>
        <input type="text" class="form-control" id="campo3" name="campo3">
      </div>
      <div class="form-group">
        <label for="campo3">Municipio</label>
        <input type="text" class="form-control" id="campo3" name="campo3">
      </div>
      <div class="form-group">
        <label for="campo3">Estado</label>
        <input type="text" class="form-control" id="campo3" name="campo3">
      </div>
      <div class="form-group">
      <select class="form-select form-select-lg mb-3" aria-label="Small select example">
          <option selected>Externo</option>
          <option selected>Trabajador(interno)</option>
        </select>
      </div>
      <button type="submit" class="btn btn-primary">Añadir</button>
      <button type="submit" class="btn btn-secondary">Lista de Medicamento</button>
    </div>
  </div>
</div>

<div class="col-md-12 flex-fill">
<div class="row">
      <div class="col-md-12">
        <div class="input-group mb-3">
          <input type="text" class="form-control" placeholder="Buscar" aria-label="Buscar">
          <div class="input-group-append">
            <button class="btn btn-primary" type="button"><i class="fa-solid fa-magnifying-glass"></i></button>
            <button class="btn btn-success" type="button"><i class="fa-solid fa-capsules"></i><i class="fa-solid fa-plus"></i></button>
          </div>
        </div>
      </div>
    </div>
  <table class="table table-bordered">
    <thead>
      <tr>
        <th>PSG</th>
        <th>Nombre Completo</th>
        <th>Rancho</th>
        <th>Domicilio</th>
        <th>Localidad</th>
        <th>Municipio</th>
        <th>Estado</th>
        <th>Opciones</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td>PSG</td>
        <td><h8> NOMBRE</h4></td>
        <td>Ranchito</td>
        <td>Domicilio</td>
        <td>Localidad</td>
        <td>Municipio</td>
        <td>Estado</td>
        <td><button class="btn btn-success apply"><i class="fa-solid fa-shield-virus"></i>
        <button class="btn btn-primary edit"><i class="fa-solid fa-pen-to-square"></i></button>
        <button class="btn btn-danger delete"><i class="fa-solid fa-trash"></i></button></button></td>
      </tr>
      
    </tbody>
  </table>
</div>

</div>
  <?php include 'Template/footer.php'; ?>
