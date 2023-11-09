<?php 
    include "../class/Auth.php";
    $nombre =$_POST['Nombre'];
    $email =$_POST['email'];
    $password=password_hash($_POST['password'], PASSWORD_DEFAULT);
    $Auth = new Auth();
    if ($Auth->register($nombre,$email,$password)) {
        header("location:../index.php");
    }else{
        echo "No se logro realizar el registro";
    }
?>