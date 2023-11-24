<?php 
    include 'Template/header.php'; 
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
      <a class="btn btn-secondary" role="button" aria-disabled="true" href="Almacen_medicina.php">Lista de Medicamento</a>
    </div>
  </div>
</div>

<div class="col-md-6 flex-fill">
<div class="row">
      <div class="col-md-12">
        <div class="input-group mb-3">
          <input type="text" class="form-control" placeholder="Buscar" aria-label="Buscar">
          <div class="input-group-append">
            <button class="btn btn-primary" type="button"><i class="fa-solid fa-magnifying-glass"></i></button>
            <a class="btn btn-success" role="button" aria-disabled="true" href="./srv/Medicamento_plus.php"><i class="fa-solid fa-capsules"></i><i class="fa-solid fa-plus"></i></a>
          </div>
        </div>
      </div>
    </div>
  <table class="table table-bordered">
    <thead>
      <tr>
        <th>cantidad</th>
        <th>Medicamento</th>
        <th>Opciones</th>
        
      </tr>
    </thead>
    <tbody>
      <tr>
        <td>1</td>
        <td>Medicamento_1</td>
        <td>
        <a class="btn btn-primary edit" role="button" aria-disabled="true" href="./srv/Editar_medicamento.php"><i class="fa-solid fa-pen-to-square"></i></a>
        <a class="btn btn-danger delete" role="button" aria-disabled="true"href="./srv/Eliminar_medicamento.php"><i class="fa-solid fa-trash"></i></button></button></td>
      </tr>
      
    </tbody>
  </table>
</div>

</div>
<?php include 'Template/footer.php'; ?>
