<?php 
    include "../Template/header.php";
    if(isset($_POST['psg'])){
        $psg=$_POST['psg'];
        $query = "SELECT * FROM `ganadero` WHERE psg='$psg'";
        $result= mysqli_query($conn, $query);
        if (!$result) {
            #$_SESSION['Message'] ='Producto No eliminado';
            #$_SESSION['Message_type'] ='danger';
            #header("location:../Ganado.php");
            echo "<script>window.location.href='../Compra_venta.php';</script>";
        }elseif(mysqli_num_rows($result)==1) { 
                $row=mysqli_fetch_array($result);
                echo "<script>window.location.href='Compra_venta_lote.php?psg=$psg';</script>";
            }
        #$_SESSION['Message'] ='Producto eliminado con Exito';
        #$_SESSION['Message_type'] ='danger';
        #header("location: ../Ganado.php");
    }
?>
