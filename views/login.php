<?php

require_once "../emisora/usuarios.php";

if (isset($_COOKIE['usuario'])) {
  $_SESSION['usuario'] = $_COOKIE['usuario'];
  header("Location: perfil-user.php");
  exit;
}

$usuario = $password = "";
$errores = [];
$patron = "/^[a-zA-Z0-9]*$/";

function limpiarEntrada($data)
{
  return htmlspecialchars(stripslashes(trim($data)));
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['entrar'])) {

  $usuario = trim(limpiarEntrada($_POST['usuario']));
  $password = limpiarEntrada($_POST['password']);

  if (empty($usuario) || empty($password)) {
    $errores[] = "Todos los campos son obligatorios.";
  } else if (!preg_match($patron, $usuario)) {
    $errores[] = "Nombre de usuario incorrecto.";
  }

  if (empty($errores)) {
    $dbPass = getUsuarioPass($usuario);
    if (!$dbPass || !password_verify($password, $dbPass)) {
      $errores[] = "Usuario o contraseña incorrectos.";
    } else {
      $_SESSION['usuario'] = $usuario;
      if (isset($_POST['recordarme'])) {
        setcookie('usuario', $usuario, time() + (30 * 24 * 60 * 60), "/");
      }
      header("Location: perfil-user.php"); // Redirige al panel principal
      exit;
    }
  }
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Inicio de Sesion</title>
  <link href="../css/login.css" rel="stylesheet" type="text/css">
</head>

<body>
  <div class="contenedor">
    <form method='POST' class="form-container">
      <div class="form-group">
        <h2>SIGN IN</h2>
        <input type="text" name="usuario" placeholder="Usuario"><br>
        <br>
        <input type="password" name="password" placeholder="Contraseña"><br>
        <br>
        <input type="checkbox" name="remember">Mantener abierta la sesión
        <br><br>
        <input type="submit" name="entrar" value="Entrar">
      </div>
      <br>
      <?php foreach ($errores as $error) {
        echo "<div class='errores style='color: crimson;'> $error </div>";
      }
      ?>
    </form>
    <div class="extras">
      <a href="./cambiar_contraseña.php">¿Olvidaste tu contraseña?</a>
      <span>¿No tienes una cuenta? <a href="registro.php">Regístrate</a></span>
    </div>
  </div>

</body>

</html>