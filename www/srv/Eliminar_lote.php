<?php 
        $conn= mysqli_connect('db','root','clave',"Granja");
    if(isset($_GET['id'])){
        $id=$_GET['id'];
        $query = "DELETE FROM Lote where Lote =$id";
        $result= mysqli_query($conn, $query);
        if (!$result) {
            #$_SESSION['Message'] ='Producto No eliminado';
            #$_SESSION['Message_type'] ='danger';
            header("location:../Ganado.php");
        }else{
        #$_SESSION['Message'] ='Producto eliminado con Exito';
        #$_SESSION['Message_type'] ='danger';
        header("location: ../Ganado.php");}
    }
?>