<?php 

require_once "../emisora/usuarios.php";
/*
Puntos clave a ajustar:
Encriptación de contraseñas:
- Usa la función password_hash() de PHP para encriptar las contraseñas antes de almacenarlas. password_verify();

Valores predeterminados para admin y fecha_creacion:
- admin: evitar pasarlo como parámetro en la consulta, está definido con valor predeterminado (DEFAULT 0) en la tabla.
- fecha_creacion: valor predeterminado (CURRENT_TIMESTAMP), no necesito gestionarlo en la consulta.

Validación y sanitización de datos:
- validar que sean correctos (longitudes, formato de correo, etc.) y sanitiza las entradas para prevenir inyección SQL.

Inserción en la base de datos:
- Usa consultas parametrizadas para evitar inyecciones SQL.
 */
$nombre = $apellido = $usuario = $email = $password = "";
$regEx = "/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]*$/";
$regExU = "/^[a-zA-Z0-9]*$/"; // para el usuario: letras y numeros sin espacios
$errores = [];
function limpiarEntrada ($data) {
  return htmlspecialchars(stripslashes(trim($data)));
}

function mostrarErrores() {
  if (!empty($errores)) {
    foreach($errores as $error){
      echo "<span>" . $error . "</span>";
    }
  }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['registro'])) {

  $nombre = limpiarEntrada($_POST['nombre']);
  $apellido = limpiarEntrada($_POST['apellido']);
  $usuario = trim(limpiarEntrada($_POST['usuario']));

  if (empty($nombre) || !preg_match($regEx, $nombre)) {
    $errores[] = "Nombre no válido.";
  }
  if (empty($apellido) || !preg_match($regEx, $apellido)) {
    $errores[] = "Apellido no válido";
  }
  if (empty($usuario) || !preg_match($regExU, $apellido)) {
    $errores[] = "Nombre de usuario no válido";
  } else if (getUsuarioUser($usuario)) {
    $errores[] = "Nombre de usuario ya registrado.";
  }

  $email = limpiarEntrada($_POST['email']);
  if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $errores[] = "Correo electrónico no válido.";
  }

  $password = limpiarEntrada($_POST['password']);
  if (empty($password) || strlen($password) < 8) {
    $errores[] = "La contraseña debe tener al menos 8 caracteres.";
  } else {
    $hash_pass = password_hash($password, PASSWORD_BCRYPT); //encriptado de la contraseña
  }

  if (empty($errores)) {
    insertarUsuario($nombre, $apellido, $email, $usuario, $hash_pass);
    //aquí hay que llamar a la funcion que inserta un nuevo usuario a la base de datos
    echo "<span style='color:green;'>Usuario registrado exitosamente.</span>";
  } else {
    foreach ($errores as $error) {
      echo "<div class='errores'>
        <span style='color:crimson;'>$error</span><br>
      </div>";
    }
  }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="../css/registro.css" rel="stylesheet" type="text/css">
  <title>Document</title>
</head>
<body>
  <div class="sign-up-container">
  <form method="POST" class="sign-up-form">
    <div class="sign-up-tittle">
      <h1>SIGN UP</h1>
    </div>
    <div class="datos">
      <fieldset>
        <legend>DATOS PERSONALES</legend>
        <input type="text" name="nombre" placeholder="Nombre"><br><br>
        <input type="text" name="apellido" placeholder="Apellido"><br><br>
      </fieldset>
    </div>
    <div class="regis">
    <fieldset>
      <legend>DATOS DE REGISTRO</legend>
      <input type="text" name="usuario" placeholder="Usuario"><br><br>
      <input type="email" name="email" placeholder="Correo electrónico"><br><br>
      <input type="password" name="password" placeholder="Contraseña"><br><br>
    </fieldset>
    </div>
    <br>
    <input id="put" type="submit" name="registro" value="Registrarse">
  </form>
  </div>
  <br>
    <?php mostrarErrores();?>

  <div class="log">
      <span>¿Tienes una cuenta? <a href="login.php">Entrar</a></span>
  </div>

</body>
</html>