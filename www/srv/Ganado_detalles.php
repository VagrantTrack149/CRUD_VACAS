<?php 
    include '../Template/header.php'; 
    if(isset($_GET['id'])){
        $id=$_GET['id'];
        $termino = isset($_GET['termino']) ? $_GET['termino']:'';
        $query="SELECT No_Arete, Sexo,Edad,Peso,Estado,Precio FROM Ganado WHERE $id=Ganado.Lote";
        if(!empty($termino)){
          $query.= " ,Lote LIKE '$termino'";
        }
        $select_ganado = mysqli_query($conn, $query);   
    }
?>   
<link rel="stylesheet" href="style/Control.css">
<div class="container mx-auto text-center Taco">
  <div class="flex-fill">
    <div class="row">
      <div class="col-md-12">
        <div class="input-group mb-3">
            <a class="btn btn-success" type="button" href="Ganado_plus.php?Lote=<?php echo $id?>">
              <i class="fa-solid fa-cow"></i><i class="fa-solid fa-plus"></i>
            </a>
        </div>
      </div>
    </div>
    <table class="table table-bordered">
      <thead>
        <tr>
          <th>Numero de arete</th>
          <th>Sexo</th>
          <th>Edad(Meses)</th>
          <th>Peso(KG)</th>
          <th>Estado</th>
          <th>Precio($)</th>
          <th>Opciones</th>
        </tr>
      </thead>
      <tbody>
        <?php 
        
          while($row=mysqli_fetch_array($select_ganado)){          
        ?>
        <tr>
          <td><?php echo $row['No_Arete']?></td>
          <td><?php echo $row['Sexo']?></td>
          <td><?php echo $row['Edad']?></td>
          <td><?php echo $row['Peso']?></td>
          <td><?php echo $row['Estado']?></td>
          <td><?php echo $row['Precio']?></td>
          <td>
            <a role="button" aria-disabled="true"class="btn btn-success apply" href="Editar_ganado.php?id=<?php echo $row['No_Arete'];?>">
              <i class="fa-solid fa-pen-to-square"></i>
            </a>
            <a href="Eliminar_ganado.php?id=<?php echo $row['No_Arete'];?>" role="button" aria-disabled="true" class="btn btn-danger apply">
                <i class="fa-solid fa-trash"></i>
            </a>
          </td>
        </tr>
        <?php }?>
      </tbody>
    </table>
  </div>

</div>  
<?php include '../Template/footer.php'; ?>