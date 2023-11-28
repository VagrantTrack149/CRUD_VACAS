<?php 
    include "../Template/header.php";
?>
<?php 
    if(isset($_GET['id'])){
        $id=$_GET['id'];
        $query= "SELECT * FROM Comida WHERE id_comida = '$id'";
        $result= mysqli_query($conn,$query);
        if (mysqli_num_rows($result)==1) { 
            $row=mysqli_fetch_array($result);
            $Descripcion= $row['Descripcion'];
            $Cantidad=$row['cantidad'];
            $precio=$row['precio'];
        }
        if (isset($_POST['edit'])){
            $id=$_POST['id_comida']; // Nombre de campo corregido
            $Descripcion= $_POST['Descripcion'];
            $Cantidad=$_POST['cantidad'];
            $precio=$_POST['precio'];
            $query= "UPDATE Comida SET id_comida='$id', Descripcion='$Descripcion', cantidad=$Cantidad, precio=$precio WHERE Comida.id_comida='$id'";
            $result= mysqli_query($conn,$query);    
            #$_SESSION['Message'] ='Registro del animal editado con exito';
            #$_SESSION['Message_type'] ='Success';
            echo "<script>window.location.href='../Comida.php';</script>";
            #header("location:Editar_ganado.php"); #quitar
        }
    }
?>
<div class="container p-4">
    <div class="row">
        <div class="col-md-4 mx-auto">
            <div class="card card-body">
                <form action="Editar_comida.php?id=<?php echo $_GET['id_comida'];?>" method="POST">
                <div class="from-group">
                        <input type="text" name="id_comida" value="<?php   echo $id;    ?>" class="from-control" placeholder="Id comida">
                    </div>
                    <div class="from-group">
                        <input type="text" name="Descripcion" value="<?php   echo $Descripcion;    ?>" class="from-control" placeholder="Descripcion">
                    </div>
                    <div class="from-group">
                        <input type="text" name="cantidad" value="<?php   echo $Cantidad;   ?>" class="from-control" placeholder="Cantidad">
                    </div>
                    <div class="from-group">
                        <input type="text" name="precio" value="<?php   echo $precio;   ?>" class="from-control" placeholder="($)Precio">
                    </div>
                        <input type="submit" class="btn btn-success btn-block" name="edit" value="Actualizar comida">
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?php include '../Template/footer.php'; ?>