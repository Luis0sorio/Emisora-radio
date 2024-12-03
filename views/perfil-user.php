
<?php
/*
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
*/
?>

<!DOCTYPE html>
<html lang="es">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Perfil de Usuario</title>
	<link href="../css/perfil-user.css" rel="stylesheet" type="text/css">
</head>

<body>
	<nav>
		<div class="profile">
			<div class="perfil-container">
				<h1><?= htmlspecialchars($usuario); ?></h1>
				<p>Aquí puede ir el correo y algo más.</p>
			</div>
			<form action="logout.php" method="POST">
				<button type="submit" class="btn-logout">Cerrar Sesión</button>
			</form>
		</div>

		<div class="to-do">
			<p>Aquí iran los enlaces para ver las tablas</p>
			<a href="./grupos_musica.php">Ver grupos musicales</a>
			<a href="">Ver conciertos/eventos</a>
			<a href="">Ver </a>
			<a href="">cuatro</a>
		</div>

		<div class="my-groups">
			<p>Aquí van los conciertos de los grupos que deseo añadir a mi lista</p>
		</div>
	</nav>
	
	<main>
	<div class="favoritos">
		<h2>Mis grupos favoritos</h2>
		<?= toTableFavoritos($favoritos); ?>
	</div>
	</main>

</body>

</html>