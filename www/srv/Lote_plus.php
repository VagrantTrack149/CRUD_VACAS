<?php 
     session_start();
     if (!isset($_SESSION['usuario'])) {
         header("location:../index.php");
     }else{
         $conn= mysqli_connect('db','root','clave',"Granja");
     }
    $query= "INSERT INTO Lote(Lote, Peso_Lote, Estado, Llegada,Cantidad) VALUES (2,0,'En camino',NOW(),0)";
    $result= mysqli_query($conn,$query);  
    header("location:../Ganado.php");
?>