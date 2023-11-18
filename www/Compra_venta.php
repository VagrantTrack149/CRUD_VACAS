<?php 
    session_start();
    include 'Template/header.php'; 
    if (!isset($_SESSION['usuario'])) {
        header("location:index.php");
    }
?>
<link rel="stylesheet" href="style/Compra_venta.css">
<select class="form-select" aria-label="Default select example">
    <option selected>Responsable</option>
    <option value="1">Juan texas</option>
    <option value="2">Pedro gallegos</option>
</select>
<div class="container-sm card-group">
    <div class="card">
        <h4>Ganadero y sus datos</h4>
    </div>
    <div class="card">
        <h4>Lote y sus datos</h4>
    </div>
    <div class="card">
        <h4>Operación</h4>
    </div>
    <div class="card">
        <h4>Monto y detalles</h4>
    </div>
</div>

<div class="card compra_venta">
    <button type="submit" class="btn-primary">Realizar</button>
</div>

<?php include 'Template/footer.php'; ?>
