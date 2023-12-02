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
        <form action="./srv/Ganadero_plus.php" method="POST">
        <label for="campo1">PSG</label>
        <input type="text" class="form-control" id="campo1" name="PSG">
      </div>
      <div class="form-group">
        <label for="campo2">Nombre Completo</label>
        <input type="text" class="form-control" id="campo2" name="NAME">
      </div>
      <div class="form-group">
        <label for="campo3">Rancho</label>
        <input type="text" class="form-control" id="campo3" name="RANCH">
      </div>
      <div class="form-group">
        <label for="campo3">Domicilio</label>
        <input type="text" class="form-control" id="campo3" name="ADRESS">
      </div>
      <div class="form-group">
        <label for="campo3">Localidad</label>
        <input type="text" class="form-control" id="campo3" name="LOCATION">
      </div>
      <div class="form-group">
        <label for="campo3">Municipio</label>
        <input type="text" class="form-control" id="campo3" name="MUNI">
      </div>
      <div class="form-group">
        <label for="campo3">Estado</label>
        <input type="text" class="form-control" id="campo3" name="STATE">
      </div>
      <div class="form-group">
      <select class="form-select" aria-label="Default select example">
          <option selected>Externo</option>
          <option selected>Trabajador(interno)</option>
        </select>
      </div>
      <button type="submit" class="btn btn-success">Añadir <i class="fa-solid fa-hat-cowboy"></i><i class="fa-solid fa-plus"></i></button>
    </div>
    </form>
  </div>
</div>

<div class="col-md-12 flex-fill">
<div class="row">
      <div class="col-md-12">
        <div class="input-group mb-3">
          <input type="text" class="form-control" placeholder="Buscar" aria-label="Buscar">
          <div class="input-group-append">
            <button class="btn btn-primary" type="button"><i class="fa-solid fa-magnifying-glass"></i></button>
            <button class="btn btn-success" type="button"><i class="fa-solid fa-hat-cowboy"></i><i class="fa-solid fa-plus"></i></button>
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
    <?php
              $query = "SELECT * FROM Ganadero;
          ";
              $select_lotes = mysqli_query($conn, $query);
              while ($row = mysqli_fetch_array($select_lotes)) {
            ?>
      <tr>
        <td><?php echo $row['psg']?></td>
        <td><?php echo $row['nombre']?></td>
        <td><?php echo $row['razonsocial']?></td>
        <td><?php echo $row['domicilio']?></td>
        <td><?php echo $row['localidad']?></td>
        <td><?php echo $row['Municipio']?></td>
        <td><?php echo $row['Estado']?></td>
        <td>
        <a role="button" aria-disabled="true" class="btn btn-primary apply" href="srv/Editar_ganadero.php?id=<?php echo $row['psg']; ?>">
          <i class="fa-solid fa-pen-to-square"></i>
        </a>
        <a role="button" aria-disabled="true" class="btn btn-danger apply" href="srv/Eliminar_ganadero.php?id=<?php echo $row['psg']; ?>">
          <i class="fa-solid fa-trash"></i>
        </a>
      </td>
      </tr>
      <?php } ?>
    </tbody>
  </table>
</div>

</div>
  <?php include 'Template/footer.php'; ?>
