<?php 
include '../Template/header.php';

if(isset($_POST['cantidad_venta']) && isset($_POST['id']) && isset($_POST['receta_comida'])){
    $id = $_POST['id'];
    $cantidad = $_POST['cantidad_venta'];
    $receta_comida=$_POST['receta_comida'];
    $query = "CALL InsertarDetalleReceta($id, $cantidad,$receta_comida);";
    $result = mysqli_query($conn, $query);
    if (!$result) {
        $_SESSION['Message'] ='Producto no insertado';
        $_SESSION['Message_type'] ='danger';
        echo "<script>window.location.href='Receta_plus.php';</script>";
    } else {
        $_SESSION['Message'] ='Producto insertado con Éxito';
        $_SESSION['Message_type'] ='success';
        echo "<script>window.location.href='Receta_plus.php';</script>";
    }
}
?>
