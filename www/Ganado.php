<?php 
    include 'Template/header.php'; 
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
          <th>Fecha de llegada</th>
          <th>Cantidad de animales</th>
          <th>Peso(KG)</th>
          <th>Opciones</th>
        </tr>
      </thead>
      <tbody>
        <?php 
          $query="SELECT Lote, Llegada,Cantidad,Peso_Lote FROM Lote";
          $select_lotes = mysqli_query($conn, $query);
          while($row=mysqli_fetch_array($select_lotes)){          
        ?>
        <tr>
          <td><?php echo $row['Lote']?></td>
          <td><?php echo $row['Llegada']?></td>
          <td><?php echo $row['Cantidad']?></td>
          <td><?php echo $row['Peso_Lote']?></td>
          <td>
            <a role="button" aria-disabled="true"class="btn btn-success apply" href="srv/Ganado_detalles.php?id=<?php echo $row['Lote'];?>">
              <i class="fa-solid fa-cow"></i>
            </a>
          </td>
        </tr>
        <?php }?>
      </tbody>
    </table>
  </div>
</div>  <?php include 'Template/footer.php'; ?>