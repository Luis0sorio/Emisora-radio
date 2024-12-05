<?php
require_once "../emisora/usuarios.php";

session_start(); // Inicio sesión

// Valido si existe una cookie 'usuario'
if (isset($_COOKIE['usuario'])) {
  $token = $_COOKIE['usuario']; // Si es cierto, se guarda como valor del 'token'
  $usuario = validarToken($token); // Valido el token
  if ($usuario) { // Si la validación devuelve 'true', se guarda la información del usuario en la sesión
    $_SESSION['usuario'] = $usuario;
    header("Location: perfil-user.php");
    exit;
  }
}

$usuario = $password = "";
$errores = [];
$patron = "/^[a-zA-Z0-9]*$/";

function limpiarEntrada($data)
{
  return htmlspecialchars(stripslashes(trim($data)));
}

// Valido el login
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['entrar'])) {

  $usuario = trim(limpiarEntrada($_POST['usuario']));
  $password = limpiarEntrada($_POST['password']);

  // Valido los campos
  if (empty($usuario) || empty($password)) {
    $errores[] = "Todos los campos son obligatorios.";
  } elseif (!preg_match($patron, $usuario)) {
    $errores[] = "Nombre de usuario incorrecto.";
  }

  // Si no tengo errores, compruebo la contraseña
  if (empty($errores)) {
    $dbPass = getUsuarioPass($usuario);
    if (!$dbPass || !password_verify($password, $dbPass)) {
      $errores[] = "Usuario o contraseña incorrectos.";
    } else {
      // Obtengo los datos del usuario (incluyendo el campo 'admin')
      $userData = getUsuario($usuario);

      if ($userData) {
        $_SESSION['usuario'] = $usuario;
        $_SESSION['usuarioId'] = $userData['usuarioId'];
        $_SESSION['admin'] = $userData['admin'];

        // Creo un token si marqué el check de recordar
        if (isset($_POST['remember'])) {
          $token = bin2hex(random_bytes(16));
          setcookie('usuario', $token, time() + 30 * 24 * 60 * 60, "/");
          guardarToken($usuario, $token);
        }

        // redireccionamos según el tipo de usuario
        if ($userData['admin'] == 1) {
          header("Location: home-admin.php"); // Administrador
        } else {
          header("Location: perfil-user.php"); // Usuario normal
        }
        exit;
      } else {
        $errores[] = "Error al obtener los datos del usuario.";
      }
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
        <span>Introduce tu usuario y contraseña</span>
        <input type="text" name="usuario" placeholder="Usuario"><br>
        <br>
        <input type="password" name="password" placeholder="Contraseña"><br>
        <br>
        <label><input type="checkbox" name="remember" id="remember">Mantener abierta la sesión</label>
        <br>
        <?php
        if (!empty($errores)) {
          foreach ($errores as $error) {
            echo "<span style='color:red;'>" . $error . "</span><br>";
          }
        }
        ?>
        <br>
        <input type="submit" name="entrar" value="Acceder">
      </div>
      <br>
    </form>
    <div class="extras">
      <a href="./cambiar_contraseña.php">¿Olvidaste tu contraseña?</a>
      <span>¿No tienes una cuenta? <a href="registro.php">Regístrate</a></span>
    </div>
  </div>
</body>

</html>