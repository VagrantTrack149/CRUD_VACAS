<?php 
    include "../Template/header.php";
?>
<?php 
    if(isset($_GET['id'])){
        $id=$_GET['id'];
        $query= "SELECT P.Producto, S.cantidad, S.precio,P.id_producto
        FROM Granja.Producto P
        INNER JOIN Granja.Stock S ON P.id_producto = S.id_producto
        WHERE P.id_producto=$id;
        ";
        $result= mysqli_query($conn,$query);
        if (mysqli_num_rows($result)==1) { 
            $row=mysqli_fetch_array($result);
            $Descripcion= $row['Producto'];
            $Cantidad=$row['cantidad'];
            $precio=$row['precio'];
        }
        if (isset($_POST['edit'])){
            $Descripcion= $_POST['Descripcion'];
            $Cantidad=$_POST['cantidad'];
            $precio=$_POST['precio'];
            $query= " CALL `EditarProducto`($id, '$Descripcion', $Cantidad, $precio);";
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
                <form action="Editar_comida.php?id=<?php echo $_GET['id'];?>" method="POST">
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