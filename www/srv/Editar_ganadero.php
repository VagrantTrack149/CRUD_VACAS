<?php 
    include "../Template/header.php";
?>
<?php 
    if(isset($_GET['id'])){
        $id=$_GET['id'];
        $query= "SELECT * FROM ganadero WHERE psg = '$id'";
        $result= mysqli_query($conn,$query);
        if (mysqli_num_rows($result)==1) { 
            $row=mysqli_fetch_array($result);
            $id =$row['psg'];
            $Name =$row['nombre'];
            $Rancho=$row['razonsocial'];
            $Domicilio=$row['domicilio'];
            $Localidad=$row['localidad'];
            $Municipio=$row['Municipio'];
            $Estado=$row['Estado'];
        }
        if (isset($_POST['edit'])){
            $id =$_POST['PSG'];
            $Name =$_POST['NAME'];
            $Rancho=$_POST['RANCH'];
            $Domicilio=$_POST['ADRESS'];
            $Localidad=$_POST['LOCATION'];
            $Municipio=$_POST['MUNI'];
            $Estado=$_POST['STATE'];
            $query= "UPDATE `ganadero` 
            SET `psg`=$id,`nombre`='$Name',`razonsocial`='$Rancho',
            `domicilio`='$Domicilio',`localidad`='$Localidad',`Municipio`='$Municipio',`Estado`='$Estado' 
            WHERE ganadero.psg=$id;";
            $result= mysqli_query($conn,$query);    
            #$_SESSION['Message'] ='Registro del animal editado con exito';
            #$_SESSION['Message_type'] ='Success';
            echo "<script>window.location.href='../Ganadero.php';</script>";
            #header("location:Editar_ganado.php"); #quitar
        }
    }
?>
<div class="container p-4">
    <div class="row">
        <div class="col-md-4 mx-auto">
            <div class="card card-body">
                <form action="Editar_ganadero.php?id=<?php echo $_GET['psg'];?>" method="POST">
                <div class="from-group">
                        <input type="text" name="PSG" value="<?php   echo $id;    ?>" class="from-control" placeholder="Numero ranchero">
                    </div>
                    <div class="from-group">
                        <input type="text" name="NAME" value="<?php   echo $Name;    ?>" class="from-control" placeholder="Nombre">
                    </div>
                    <div class="from-group">
                        <input type="text" name="RANCH" value="<?php   echo $Rancho;   ?>" class="from-control" placeholder="Rancho">
                    </div>
                    <div class="from-group">
                        <input type="text" name="ADRESS" value="<?php   echo $Domicilio;   ?>" class="from-control" placeholder="Dirección">
                    </div>
                    <div class="from-group">
                        <input type="text" name="LOCATION" value="<?php   echo $Localidad;   ?>" class="from-control" placeholder="Locacion">
                    </div>
                    <div class="from-group">
                        <input type="text" name="MUNI" value="<?php   echo $Municipio;   ?>" class="from-control" placeholder="Municipio">
                    </div>
                    <div class="from-group">
                        <input type="text" name="STATE" value="<?php   echo $Estado;   ?>" class="from-control" placeholder="Estado">
                    </div>
                        <input type="submit" class="btn btn-success btn-block" name="edit" value="Actualizar ganadero">
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?php include '../Template/footer.php'; ?>