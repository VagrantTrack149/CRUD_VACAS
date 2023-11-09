<?php 
    session_start();
    include 'Template/header.php'; 
    if (!isset($_SESSION['usuario'])) {
        header("location:index.php");
    }
?>    
<h1>Hola mundo</h1>
<?php include 'Template/footer.php'; ?>