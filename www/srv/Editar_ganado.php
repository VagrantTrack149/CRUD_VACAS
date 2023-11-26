<?php 
    include "../Template/header.php";
?>
<?php 
    if(isset($_GET['id'])){
        $id=$_GET['id'];
        $query= "SELECT * FROM Ganado WHERE No_Arete = '$id'";
        $result= mysqli_query($conn,$query);
        if (mysqli_num_rows($result)==1) { 
            $row=mysqli_fetch_array($result);
            $sex= $row['Sexo'];
            $edad=$row['Edad'];
            $lote=$row['Lote'];
            $peso=$row['Peso'];
            $estado=$row['Estado'];
            $precio=$row['Precio'];
        }
        if (isset($_POST['edit'])){
            $id=$_GET['id'];
            $sex= $_GET['Sexo'];
            $edad=$_GET['Edad'];
            $lote=$_GET['Lote'];
            $peso=$_GET['Peso'];
            $estado=$_GET['Estado'];
            $precio=$_GET['Precio'];
            $query= "UPDATE Ganado SET No_Arete='$id',Sexo=$sex,Edad=$edad,Lote=$lote,Peso=$peso,Estado='$estado',Precio=$precio WHERE Ganado.No_Arete='$id'";
            $result= mysqli_query($conn,$query);    
            #$_SESSION['Message'] ='Registro del animal editado con exito';
            #$_SESSION['Message_type'] ='Success';
            echo "<script>window.location.href='../Ganado.php';</script>";
            #header("location:Editar_ganado.php"); #quitar
        }
    }
?>
<div class="container p-4">
    <div class="row">
        <div class="col-md-4 mx-auto">
            <div class="card card-body">
                <form action="Editar_ganado.php?id=<?php echo $_GET['No_Arete'];?>" method="POST">
                <div class="from-group">
                        <input type="text" name="Numero de arete" value="<?php   echo $id;    ?>" class="from-control" placeholder="Numero de arete">
                    </div>
                    <div class="from-group">
                        <input type="text" name="Sexo" value="<?php   echo $sex;    ?>" class="from-control" placeholder="Sexo 1-MACHO 0-HEMBRA">
                    </div>
                    <div class="from-group">
                        <input type="text" name="Edad" value="<?php   echo $edad;   ?>" class="from-control" placeholder="Edad(meses)">
                    </div>
                    <div class="from-group">
                        <input type="text" name="Lote" value="<?php   echo $lote;   ?>" class="from-control" placeholder="Edad(meses)">
                    </div>
                    <div class="from-group">
                        <input type="text" name="Peso" value="<?php   echo $peso;   ?>" class="from-control" placeholder="Peso(kg)">
                    </div>
                    <div class="from-group">
                        <input type="text" name="Estado" value="<?php   echo $estado;   ?>" class="from-control" placeholder="Engorda, Defunsión, etc">
                    </div>
                    <div class="from-group">
                        <input type="text" name="Precio" value="<?php   echo $precio;   ?>" class="from-control" placeholder="($)Precio">
                    </div>
                        <input type="submit" class="btn btn-success btn-block" name="edit" value="Actualizar ganado">
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?php include '../Template/footer.php'; ?>