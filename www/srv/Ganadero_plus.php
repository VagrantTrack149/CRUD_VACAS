<?php 
    include "../Template/header.php";
    $PSG =$_POST['PSG'];
    $Name =$_POST['NAME'];
    $Rancho=$_POST['RANCH'];
    $Domicilio=$_POST['ADRESS'];
    $Localidad=$_POST['LOCATION'];
    $Municipio=$_POST['MUNI'];
    $Estado=$_POST['STATE'];
    $query= "CALL InsertarGanadero('$PSG','$Name','$Rancho','$Domicilio','$Localidad','$Municipio','$Estado' );";
    $result= mysqli_query($conn,$query); 
    echo "<script>window.location.href='../Ganadero.php';</script>";
?>