<?php 
    include "../Template/header.php";
    if(isset($_POST['id_dieta']) && isset($_POST['id_producto'])){
        $id_dieta=$_POST['id_dieta'];
        $id_producto=$_POST['id_producto'];
        $query = "CALL EliminarDetalleDieta($id_dieta,$id_producto)";
        $result= mysqli_query($conn, $query);
        if (!$result) {
            #$_SESSION['Message'] ='Producto No eliminado';
            #$_SESSION['Message_type'] ='danger';
            #header("location:../Ganado.php");
            echo "<script>window.location.href='../Ganado.php';</script>";
        }else{
        #$_SESSION['Message'] ='Producto eliminado con Exito';
        #$_SESSION['Message_type'] ='danger';
        #header("location: ../Ganado.php");
        echo "<script>history.back();</script>";
        }
    }
?>

