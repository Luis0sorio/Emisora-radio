
<?php

require_once "../emisora/usuario_grupo.php";

session_start();

// verifico la sesión y cookie
if (!isset($_SESSION['usuario'])) {
	if (isset($_COOKIE['usuario'])) {
		$token = $_COOKIE['usuario'];
		$usuario = validarToken($token);
		if ($usuario) {
			//asignamos el nombre del usuario y su id a la sesión
			$_SESSION['usuario'] = $usuario['nombre']; 
			$_SESSION['usuarioId'] = $usuario['usuarioId'];
		} else {
			header("Location: login.php");
			exit;
		}
	} else {
		header("Location: login.php");
		exit;
	}
}
	$usuario = $_SESSION['usuario'];
	$usuarioId = $_SESSION['usuarioId'];
	$favoritos = mostrarGruposFavoritos($usuarioId);

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
			<li>
				<a href="./logout.php"><span>Cerrar sesión</span></a>
			</li>
			<h4>Cuenta</h4>
			<li>
				<a href="./logout.php"><span>Ajustes</span></a>
			</li>
		</ul>

		<div class="user account">
			<div class="user-profile">
				<img src="../img/dead.png" alt="pfp">
				<div class="user-details">
					<h3> <? $_SESSION['usuario'] ?> Nombre del usuario </h3>
					<span>Usuario musical</span>
				</div>
			</div>
		</div>
	</aside>


	
	<main>
	<div class="favoritos">
		<h2>Mis grupos favoritos</h2>
		<?= toTableFavoritos($favoritos); ?>
	</div>
	</main>

</body>

</html>