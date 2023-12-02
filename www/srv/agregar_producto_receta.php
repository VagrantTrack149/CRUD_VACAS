<?php 
include '../Template/header.php';
if(isset($_POST['cantidad_max']) && isset($_POST['id_producto']) && isset($_POST['id_dieta'])){
    $id_dieta = $_POST['id_dieta'];
    $cantidad = $_POST['cantidad_max'];
    $id_producto=$_POST['id_producto'];
    $query = " CALL `InsertarDetalleDieta`($id_dieta, $id_producto, $cantidad);";
    $result = mysqli_query($conn, $query);
    if (!$result) {
        $_SESSION['Message'] ='Producto no insertado';
        $_SESSION['Message_type'] ='danger';
        echo "<script>window.location.href='../comida.php?id=$query';</script>";
    } else {
        $_SESSION['Message'] ='Producto insertado con Éxito';
        $_SESSION['Message_type'] ='success';
        echo "<script>window.location.href='Receta_detalles.php?id=$id_dieta';</script>";
    }
}
?>