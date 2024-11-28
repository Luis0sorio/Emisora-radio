<?php
session_start();

// Verificar si el usuario está logeado
if (!isset($_SESSION['usuario'])) {
    header("Location: ./login.php"); // Redirige al login si no hay sesión activa
    exit;
}

// Obtener el usuario de la sesión
$usuario = $_SESSION['usuario'];

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil de Usuario</title>
    <link href="../css/perfil.css" rel="stylesheet" type="text/css">
</head>
<body>
    <div class="perfil-container">
        <h1>Bienvenido, <?= htmlspecialchars($usuario); ?>!</h1>
        <p>Este es tu panel de usuario.</p>
        <!-- Enlace o botón para cerrar sesión -->
        <form action="logout.php" method="POST">
            <button type="submit" class="btn-logout">Cerrar Sesión</button>
        </form>
    </div>
</body>
</html>
