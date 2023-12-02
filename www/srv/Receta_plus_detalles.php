<?php 
    include "../Template/header.php";
    if(isset($_POST['Dieta'])){
        $Dieta=$_POST['Dieta'];
        $query = "CALL InsertarDieta('$Dieta')";
        $result= mysqli_query($conn, $query);
        if (!$result) {
            #$_SESSION['Message'] ='Producto No eliminado';
            #$_SESSION['Message_type'] ='danger';
            #header("location:../Ganado.php");
            echo "<script>window.location.href='../Comida.php';</script>";
        }elseif(mysqli_num_rows($result)==1) { 
                $row=mysqli_fetch_array($result);
                $id=$row['UltimoIDGenerado'];
                echo "<script>window.location.href='Receta_detalles.php?id=$id';</script>";
            }
        #$_SESSION['Message'] ='Producto eliminado con Exito';
        #$_SESSION['Message_type'] ='danger';
        #header("location: ../Ganado.php");
    }
?>
