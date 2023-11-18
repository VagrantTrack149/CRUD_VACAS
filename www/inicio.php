<?php 
    session_start();
    include 'Template/header.php'; 
    if (!isset($_SESSION['usuario'])) {
        header("location:index.php");
    }
?>    
<link rel="stylesheet" href="style/Principal.css">
<div class="Titulo card">
    <h1>Sistema de control de ganado, alimentación, venta y compra de ganado</h1>
</div>
<?php include 'Template/footer.php'; ?>