<?php 
    include "../Template/header.php";
    if(isset($_GET['id'])){
        $id=$_GET['id'];
        $query = " CALL `BorrarDieta`($id)";
        $result= mysqli_query($conn, $query);
        if (!$result) {
            #$_SESSION['Message'] ='Producto No eliminado';
            #$_SESSION['Message_type'] ='danger';
            #header("location:../Ganado.php");
            echo "<script>window.location.href='../Comida.php';</script>";
        }else{
        #$_SESSION['Message'] ='Producto eliminado con Exito';
        #$_SESSION['Message_type'] ='danger';
        #header("location: ../Ganado.php");
        echo "<script>window.location.href='../Comida.php';</script>";
        }
    }
?>
