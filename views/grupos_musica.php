<?php 

require_once "../emisora/grupos.php";

$resultados = getAllGroups();
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['buscar'])) {
  $palabra = htmlspecialchars(trim($_POST['search'])); 
  $resultados = buscarGrupo($palabra);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['todos'])) {
  $_SESSION['resultados'] = $resultados; // Redirige a la misma página para evitar reenvío del formulario
  header('Location: ' . $_SERVER['PHP_SELF']);
  exit;
}


?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Grupos musicales</title>
</head>
<body>
  <div class="atras">
    <a href='./perfil-user.php'>volver atrás</a>
  </div>
  <br>
  <div class="buscador">
    <form method="POST">
      <label>Buscador de grupos:</label>
      <input type="text" name="search" placeholder="Nombre del grupo">
      <input type="submit" name="buscar" value="BUSCAR">
      <input type="submit" name="todos" value="TODOS">
    </form>
  </div>
  <br>
  <!-- LA TABLA DEBE ACTUALIZARSE Y MOSTRAR SOLOS EL GRUPO O GRUPOS CON ALGUNA COINCIDENCIA -->
  <div class="grupos">
    <?= toTableGrupos($resultados)?>
  </div>

</body>
</html>