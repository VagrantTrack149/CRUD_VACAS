<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    header("location:../index.php");
}else{
    $conn= mysqli_connect('db','root','clave',"Granja");
}
if (isset($_GET['termino'])) {
    $termino = $_GET['termino'];
    $query = "SELECT Lote, Llegada,Cantidad,Peso_Lote FROM Lote WHERE Lote LIKE '$termino'";
    $result = mysqli_query($conn, $query);

    if (!$result) {
        session_start();
        #$_SESSION['Message'] = 'No se encontraron coincidencias';
        #$_SESSION['Message_type'] = 'warning';
    } else {
        header("Location: ../Ganado.php?termino=$termino");
        exit();
    }
} else {
    header("Location: ../Ganado.php");
    exit();
}
?>
