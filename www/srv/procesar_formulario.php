<?php 
    include "../Template/header.php";
    // Obtener el email del usuario desde la sesión
    $email = $_SESSION['usuario'];

    // Preparar y ejecutar la consulta para obtener la id_usuario
    $query = "SELECT id_usuarios FROM usuarios WHERE email = '$email';";
    $result = mysqli_query($conn, $query);

    // Verificar si la consulta fue exitosa
    if ($result) {
        $row = mysqli_fetch_array($result);
        $id_usuario = $row['id_usuarios'];
    } else {
        // Manejar el caso en que la consulta no sea exitosa
        die("Error al obtener la id_usuario: " . mysqli_error($conn));
    }

    // Obtener otros datos del formulario
    $id_ganadero = $_POST['id_ganadero'];
    $lote = $_POST['lote'];
    $operacion = $_POST['operacion'];
    $origen = $_POST['origen'];
    $destino = $_POST['destino'];
    $especie = $_POST['especie'];
    $total = $_POST['total'];
    $comentario = $_POST['comentario'];

    // Llamar al procedimiento almacenado
    $query = "CALL RegistrarFactura('$id_ganadero', $id_usuario, '$origen', '$destino', $total, '$operacion', '$comentario', '$especie', $lote);";
    $result = mysqli_query($conn, $query); 

    // Manejar el resultado o redirigir según tus necesidades
    if ($result) {
        echo "<script>window.location.href='../Ganancias.php?especie';</script>";
    } else {
        die("Error al registrar la factura: " . mysqli_error($conn));
    }
?>
