
<?php

require_once "../emisora/usuario_grupo.php";

session_start();

// verifico la sesión y la cookie
if (!isset($_SESSION['usuario'])) {
	if (isset($_COOKIE['usuario'])) {
		$token = $_COOKIE['usuario'];
		$usuario = validarToken($token);
		if ($usuario) {
			//asignamos el nombre del usuario y su id a la sesión
			$_SESSION['usuario'] = $usuario['nombre']; 
			$_SESSION['usuarioId'] = $usuario['usuarioId'];
		} else {
			exit;
		}
	}
}
	$usuario = $_SESSION['usuario'];
	$usuarioId = $_SESSION['usuarioId'];
	$favoritos = mostrarGruposFavoritos($usuarioId);

	if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['delete'])) {
		//funcion que quita de la tabla 'usuarios_grupos' el grupo favorito
		// id de la tabla 'usuarios_grupos' = id
		$id = obtenerFavoritoById();
		if ($id) {
			borrarFavorito($id);
			header("Location: perfil-user.php");
      exit;
		}
	}
?>

<!DOCTYPE html>
<html lang="es">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Home usuario</title>
	<link href="../css/perfil-user.css" rel="stylesheet" type="text/css">
</head>

<body>

	<aside class="sidebar">
		<div class="sidebar-header">
			<img src="../img/vinilo.png" alt="logo">
			<h2>EmisoraDB</h2>
		</div>

		<ul class="sidebar-links">
			<h4>General</h4>
			<li>
				<a href="../views/grupos_musica.php"><span>Grupos de música</span></a>
			</li>
				<!--
			<li>
				<a href="../views/artistas.php"><span>Artistas</span></a>
			</li>
			-->
			<li>
				<a href="./logout.php"><span>Cerrar sesión</span></a>
			</li>
		</ul>

		<div class="user-account">
			<h3>USUARIO: <?= $_SESSION['usuario'] ?> </h3>
		</div>
	</aside>

	<main>
	<div class="grupos-favoritos">
		<h2>Mis grupos/artistas favoritos</h2>
		<br>
		<?= toTableFavoritos($favoritos); ?>
	</div>
	<br><br>
	<!--
	<div class="canciones-favoritos">
		<h2>Mis canciones favoritas</h2>
		<br>
		
	</div>
-->
	</main>

</body>

</html>