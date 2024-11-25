<?php 

require_once "../emisora/usuarios.php";

$usuario = $password = "";
$errores = "Usuario o contraseña incorrectas. Compruébalo de nuevo.";
$patron = "/^[a-zA-Z0-9]*$/";

function limpiarEntrada ($data) {
  return htmlspecialchars(stripslashes(trim($data)));
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['entrar'])) {

  $usuario = limpiarEntrada($_POST['usuario']);
  if ((empty($usuario) || !preg_match($patron, $usuario)) &&
  (empty($password))) {
    return $errores;
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
  <form method='POST' class="sign-in-form">
      <div class="form-tittle"><h2>Sign In - EMISORADB</h2></div>
      <div class="form-group">
      <fieldset class="form-datos">
        <legend>INICIO DE SESIÓN</legend>
        <input type="text" name="usuario" placeholder="Usuario o correo electrónico"><br>
        <br>
        <input type="password" name="password" placeholder="Contraseña"><br>
      
        <br>
        <input type="submit" name="entrar" value="Entrar"></fieldset>
      <br>

      <fieldset class="form-addons">
        <a href="">¿Olvidaste tu contraseña?</a>
        <span>¿No tienes una cuenta? <a href="registro.php">Regístrate</a></span>
      </fieldset>
    </div>
  </form>
</body>

</html>