<?php

require_once "../emisora/usuarios.php";

session_start(); // inicio sesión

// valido si existe una cookie 'usuario'
if (isset($_COOKIE['usuario'])) {
  $token = $_COOKIE['usuario']; // si es cierto, se guarda como valor del 'token'
  $usuario = validarToken($token); // valido el token
  if ($usuario) { // si la validacion devuelve 'true' se guarda la informacion del usuario en la sesión
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

// valido el login 
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['entrar'])) {

  $usuario = trim(limpiarEntrada($_POST['usuario']));
  $password = limpiarEntrada($_POST['password']);

  // valido los campos
  if (empty($usuario) || empty($password)) {
    $errores[] = "Todos los campos son obligatorios.";
  } else if (!preg_match($patron, $usuario)) {
    $errores[] = "Nombre de usuario incorrecto.";
  }

  //si no tengo errores compruebo que la contraseña tenga la misma referencia que la guardada, en hash, en mi base de datos
  if (empty($errores)) {
    $dbPass = getUsuarioPass($usuario);
    if (!$dbPass || !password_verify($password, $dbPass)) {
      // si no es igual, no me deja hacer login
      $errores[] = "Usuario o contraseña incorrectos.";
    } else {
      // si es correcto, obtengo el id del usuario logeado
      $userId = getUsuarioById($usuario);
      // y fijo variables de sesion: nombre e id del usuario
      $_SESSION['usuario'] = $usuario;
      $_SESSION['usuarioId'] = $userId;
      //si marqué el checkbox de 'recordar' creo un token
      if (isset($_POST['remember'])) {
        $token = bin2hex(random_bytes(16));
        //creo la cookie con el token
        setcookie('usuario', $token, time() + (30 * 24 * 6 * 6), "/");
        // guardo el token en la base de datos
        guardarToken($usuario, $token);
      }
      // una vez el login es satisfactorio, me dirige a la ventana de perfil del usuario
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
        <span>Introduce tu usuario y contraseña</span>
        <input type="text" name="usuario" placeholder="Usuario"><br>
        <br>
        <input type="password" name="password" placeholder="Contraseña"><br>
        <br>
        <label><input type="checkbox" name="remember" id="remember">Mantener abierta la sesión</label>
        <br>
        <?php 
          if (!empty($errores)){
            foreach($errores as $error){
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