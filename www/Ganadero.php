<?php include '../Template/header.php'; ?>
<main class="container p-4">
    <div class="row">
        <div class="col-md-4">
            <!--Mensaje -->
            <?php 
                if (isset($_SESSION['message'])) {
                    ?>
                    <div class="alert alert-<?=$_SESSION['message_type']?> alert-dismissible fade show" role="alert">
                        <?= $_SESSION['message']?>
                        <button data-dismiss type="button" class="close"></button>
                    </div>
                    
                }
            ?>
        </div>
    </div>
</main>
<?php include '../Template/footer.php'; ?>