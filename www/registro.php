<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!--link css boostrap-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <!--link js boostrap-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <!--CSS-->
    <link rel="stylesheet" href="Style/Registro.css">
    <title>Register</title>
</head>
<body>
    <div class="container">
        <div class="row">
            <div class="col-lg-10 col-xl-9 mx-auto">
                <div class="card flex-row my-5 border-0 shadow rounder-3 overflow-hidden">
                    <div class="card-img-left d-node d-md-flex">
                        <!--image css-->
                    </div>
                    <div class="card-body p-4 p-sm-5">
                        <h5 class="card-title text-center mb-5 fw-lig fs-5"> Registro</h5>
                <form action="../srv/registrar.php" method="POST">
                        <div class="form-floating mb-3">
                        <input type="text" name="Nombre" id="Nombre" class="form-control" placeholder="Nombre" required autofocus>
                        <label for="Nombre">Nombre</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="email" name="email" id="email" class="form-control" placeholder="name@Example.com" requierd>
                        <label for="email">Correo electronico</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="password" name="password" id="password" class="form-control" required placeholder="password">
                        <label for="password">Contraseña</label>
                    </div>
                    <div class="d-grid mb-2">
                        <button type="submit" class="btn btn-lg btn-outline-primary btn-login fw-bold text-uppercase">Registrate</button>
                    </div>
                    <a class="d-block text-center mt-2 small" href="index.php">Si ya tienes una cuenta, ingresa aqui</a>
                    <hr class="my-4">
                </form>
                    </div>
                    
                </div>
            </div>
        </div>
    </div>
</body>
</html>