<?php session_start();
    include "../class/Auth.php";
    $email=$_POST['email'];
    $password=$_POST['password'];
    $Auth= new Auth();
    if ($Auth->login($email,$password)) {
        header("location:../inicio.php");
    }else{
        echo "DATOS INCORRECTOS";
    }
?>