<?php 

//cargamos el archivo que contiene las funciones de los grupos.
require_once "../emisora/grupos.php";
require_once "../emisora/usuario_grupo.php";

session_start();
// variable que guarda los grupos de musica. 
$resultados = getAllGroups();

// valido el buscador de grupos
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['buscar'])) {
  $palabra = htmlspecialchars(stripslashes(trim($_POST['search']))); //limpiamos la entrada del campo
  $resultados = buscarGrupo($palabra); // filtra grupos por el valor introducido.
}

// boton para volver a ver a todos los grupos
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['todos'])) {
  $_SESSION['resultados'] = $resultados; // redirige a la misma página para evitar reenvío del formulario
  header('Location: ' . $_SERVER['PHP_SELF']);
  exit;
}

// valido la opcion de añadir un grupo a 'mis favoritos'
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['like']) && isset($_POST['grupoId'])) {

  $grupoId = $_POST['grupoId'];
  $usuarioId = $_SESSION['usuarioId'];
  if ($grupoId > 0 && $usuarioId > 1) {
    addGrupoFavorito($usuarioId, $grupoId); // Añade el grupo como favorito
  } else {
    echo "Error";
  }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="../css/grupos_musica.css" type="text/css">
  <title>Grupos musicales</title>
</head>
<body>

  <header>
    <nav class="navbar">
      <div class="navbar-header">
        <a href='./perfil-user.php' class="navbar-back">volver atrás</a>
      </div>

      <div class="buscador">
        <form method="POST">
          <label for="search">Buscador de grupos:</label>
          <input type="text" name="search" placeholder="Nombre del grupo">
          <input type="submit" name="buscar" value="BUSCAR">
          <input type="submit" name="todos" value="VER TODOS">
        </form>
      </div>
    </nav>
  </header>
  <br>
  <main>
    <h1>LISTADO DE GRUPOS MUSICALES</h1>
    <!-- LA TABLA DEBE ACTUALIZARSE Y MOSTRAR SOLO EL GRUPO O GRUPOS CON ALGUNA COINCIDENCIA -->
    <div class="grupos">
      <?= toTableGrupos($resultados)?>
    </div>
  </main>

</body>
</html>