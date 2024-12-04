<?php 

require_once "../emisora/usuarios.php";

$usuario = $new = $confirm = "";
$patronU = "/^[a-zA-Z0-9]*$/";
$errores = [];

function limpiarEntrada($data){
  return htmlspecialchars(stripslashes(trim($data)));
}

/**
 * FUNCION QUE CAMBIA LA CONTRASEÑA HASHEADA DE UN USUARIO
 * @param string $usuario - nombre del usuario
 * @param string $password - contraseña del usuario
 * @return bool - booleana que devuelve 'true' si el cambio es correcto
 */
function updatePassword($usuario, $password) {
  try{
    $conexion = conexionDB();
    $update = "UPDATE usuarios SET password = :password WHERE usuario = :usuario";
    $consulta = $conexion->prepare($update);
    $consulta->bindValue(':usuario', $usuario);
    $consulta->bindValue(':password', $password);
    $consulta->execute();
    return true;
  } catch (PDOException $e) {
    echo "Error al realizar la modificación. ". $e->getMessage();
    return false;
  }
}

// valido el formulario de cambio de contraseña

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['confirmar'])) {

  // inicializo las variables con los valores de los campos
  $usuario = limpiarEntrada($_POST['user']);
  $new = limpiarEntrada($_POST['new-pass']);
  $confirm = limpiarEntrada($_POST['confirm-pass']);
  $usuarioDB = getUsuarioUser($usuario);

  //compruebo y valido los campos para el usuario
  if (empty($usuario)) {
    $errores[] = "El nombre de usuario es obligatorio.";
  } else if (!preg_match($patronU, $usuario)) {
    $errores[] = "Nombre de usuario no válido";
  }else if (!$usuarioDB) { // $usuario != $usuarioDB (?)
    $errores[] = "El usuario no existe."; 
  }

  //compruebo y valido los campos para la contraseña
  if (empty($new) || empty($confirm)) {
    $errores[] = "Introduzca una contraseña.";
  } else if (strlen($new) < 8) {
    $errores[] = "La contraseña debe tener mínimo 8 caracteres.";
  } else if ($new !== $confirm) {
    $errores[] = "Las contraseñas deben ser iguales.";
  }

  if (empty($errores)) {
    $newHash = password_hash($confirm, PASSWORD_BCRYPT); // hasheo la nueva contraseña
    if (updatePassword($usuario, $newHash)){ //la guardo en la base de datos
      echo "<span style='color:green;'>Actualización de contraseña completada.</span>";
    }else {
      echo "<span style='color:crimson;'>$error</span><br>";
    }
  } /*else {
    foreach ($errores as $error) {
      echo "<div class='errores'>
        <span style='color:crimson;'>$error</span><br>
      </div>";
    }
  }*/
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="../css/new_pass.css" rel="stylesheet" type="text/css">
  <title>Document</title>
</head>
<body>
<div class="contenedor">
  <form method='POST' class="new-container">
    <div class="new-group">
      <h2>RESTABLECER CONTRASEÑA</h2>
      <span>Introduce tu usuario y tu nueva contraseña</span>
      <input type="text" name="user" placeholder="Usuario"><br>
      <br>
      <input type="password" name="new-pass" placeholder="Nueva contraseña"><br>
      <br>
      <input type="password" name="confirm-pass" placeholder="Confirmar contraseña"><br>
      <br>
      <input type="submit" name="confirmar" value="Confirmar">
    </div>
  </form>
  <?php foreach ($errores as $error): ?>
    <div class='errores' style='color: crimson;'><?= $error ?></div>
  <?php endforeach; ?>
  <div class="atras">
    <a href="./login.php">Formulario de inicio de sesión</a>
</div>
</div>

</body>
</html>