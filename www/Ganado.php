<?php 
    include 'Template/header.php'; 
?>   
<link rel="stylesheet" href="style/Control.css">
<div class="container mx-auto text-center Taco">
  <div class="flex-fill">
    <div class="row">
      <div class="col-md-12">
        <div class="input-group mb-3">
          <form action="srv/busqueda_lote.php" method="GET">
          <input type="text" class="form-control" name="termino" placeholder="Buscar" aria-label="Buscar">
          <div class="input-group-append">
            <button class="btn btn-outline-primary" type="submit">
              <i class="fa-solid fa-magnifying-glass"></i>
            </button>
            <a role="button" aria-disabled="true"class="btn btn-success apply" href="srv/Lote_plus.php">
              <i class="fa-solid fa-cow"></i><i class="fa-solid fa-plus"></i>
            </a>
          </div>
          </form>
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
        $termino = isset($_GET['termino']) ? $_GET['termino']:'';
          $query="SELECT Lote, Llegada,Cantidad,Peso_Lote FROM Lote";
          if(!empty($termino)){
            $query.= " WHERE Lote LIKE '$termino'";
          }
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