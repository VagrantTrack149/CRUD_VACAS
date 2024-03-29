<?php 
    session_start();
    if (!isset($_SESSION['usuario'])) {
        header("location:../index.php");
    }else{
        $conn= mysqli_connect('db','root','clave',"Granja");
    }
?>    
<!doctype html>
<html lang="es">
<head>
    <title>Granja</title>
    <link rel="icon" href="images/imagen2.png" type="image/png">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <script src="https://kit.fontawesome.com/2dad747e84.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="../Style/header.css">  
</head>

<body>
    <header>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark static-top">
        <div class="container">
            <a href="../inicio.php" class="navbar-brand">
                <img src="../images/imagen2.png" style="width: 30px;" class="rounded-circle">
                Granja el rosario
            </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">
        <li class="nav-item">
            <a class="nav-link" href="../Ganado.php" aria-current="page">Ganado(Lotes)</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="../srv/Compra_venta_psg.php" aria-current="page">Compra y Venta</a>
        </li>
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                Almacen
            </a>
            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                <a class="dropdown-item" href="../Medicamento.php">Medicamento</a>
                <a class="dropdown-item" href="../Comida.php">Comida</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="../Ganadero.php">Ganaderos</a>
        </li>
        <li class="nav-item">
            <a href="../Ganancias.php" class="nav-link">Ganancias</a>
        </li>
        </ul>
        <li class="nav-item usuario_identificador">
            <a ><?php echo $_SESSION['usuario'];?></a>
        </li>
        <li class="nav-item">
            <a href="../srv/logout.php" class="btn btn-danger btn-lg" role="button" aria-disabled="true">Salir</a>
        </li>
</div>
  </div>
</nav>
</header>
