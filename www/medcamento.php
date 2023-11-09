<?php 
    session_start();
    include 'Template/header.php'; 
    if (!isset($_SESSION['usuario'])) {
        header("location:index.php");
    }
?>    
    <h1>Hola medicamento</h1>
<?php include 'template/footer.php'; ?>