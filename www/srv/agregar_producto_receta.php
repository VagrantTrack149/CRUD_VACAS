<?php 
include '../Template/header.php';
$query= "SELECT MAX(id_dieta) AS 'id_ultimo' FROM Granja.Dieta;
        ";
        $result= mysqli_query($conn,$query);
        if (mysqli_num_rows($result)==1) { 
            $row=mysqli_fetch_array($result);
            $id=$row['id_ultimo'];
    }
if(isset($_POST['cantidad_max']) && isset($_POST['id_producto'])){
    
    $cantidad = $_POST['cantidad_max'];
    $id_producto=$_POST['id_producto'];
    $query = " CALL `InsertarDetalleDieta`($id, $id_producto, $cantidad);";
    $result = mysqli_query($conn, $query);
    if (!$result) {
        $_SESSION['Message'] ='Producto no insertado';
        $_SESSION['Message_type'] ='danger';
        echo "<script>window.location.href='../comida.php?id=$query';</script>";
    } else {
        $_SESSION['Message'] ='Producto insertado con Éxito';
        $_SESSION['Message_type'] ='success';
        echo "<script>window.location.href='Receta_detalles.php?id=$id';</script>";
    }
}
?>