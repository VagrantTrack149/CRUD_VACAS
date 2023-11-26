<?php 
    include "../Template/header.php";
?>
<?php
if (isset($_POST['Guardar'])){
            $id=$_POST['Numero_de_arete']; // Nombre de campo corregido
            $sex= $_POST['Sexo'];
            $edad=$_POST['Edad'];
            $lote=$_POST['Lote'];
            $peso=$_POST['Peso'];
            $estado=$_POST['Estado'];
            $precio=$_POST['Precio'];
            $query= "INSERT INTO `Ganado`(`No_Arete`, `Sexo`, `Edad`, `Lote`, `Peso`, `Estado`, `Precio`) 
            VALUES ('$id',$sex,$edad,$lote,$peso,'$estado',$precio)";
            $result= mysqli_query($conn,$query);    
            #$_SESSION['Message'] ='Registro del animal editado con exito';
            #$_SESSION['Message_type'] ='Success';
            echo "<script>window.location.href='Ganado_detalles.php?id=$lote';</script>";
            #header("location:Ganado_detalles.php?id=$lote"); #quitar
}
?>