<?php 
    include "../Template/header.php";
    $descripcion =$_POST['Descripcion'];
    $cantidad =$_POST['Cantidad'];
    $precio=$_POST['Precio'];
    $query= "INSERT INTO Comida(Descripcion, cantidad, precio) VALUES ('$descripcion',$cantidad,$precio)";
    $result= mysqli_query($conn,$query); 
    echo "<script>window.location.href='../Comida.php';</script>";
?>