<?php include "../Template/header.php";?>


<div class="container mt-4">
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">Añadir Receta</h5>
            <form action="Receta_plus_detalles.php" method="POST">
                <div class="mb-3">
                    <label for="nombreDieta" class="form-label">Nombre de la Dieta</label>
                    <input type="text" class="form-control" id="Dieta" name="Dieta" required>
                </div>
                    <button type="submit" class="btn btn-primary">Añadir Receta</button>
            </form>
        </div>
    </div>
</div>

<!-- Agrega los enlaces a los archivos de Bootstrap JS (jQuery y Popper.js son requeridos para Bootstrap JS) -->
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>


<?php include '../Template/footer.php'; ?>