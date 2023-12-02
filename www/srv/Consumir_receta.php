<?php 
    include "../Template/header.php";
    if(isset($_POST['id_dieta']) && isset($_POST['lote'])){
        $id=$_POST['id_dieta'];
        $lote=$_POST['lote'];
        $query = "CALL RegistrarConsumo($id,$lote)";
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
        echo "<script>window.location.href='../Comida.php';</script>";
        }
    }
?>

