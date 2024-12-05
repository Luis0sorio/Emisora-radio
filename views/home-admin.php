<?php 
session_start();



?>


<!DOCTYPE html>
<html lang="es">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Home admin</title>
	<link href="../css/perfil-user.css" rel="stylesheet" type="text/css">
</head>

<body>

	<aside class="sidebar">
		<div class="sidebar-header">
			<h2>EmisoraDB</h2>
		</div>

		<ul class="sidebar-links">
			<h4>General</h4>

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
	
	<br>
  <?= "<h1>VENTANA DEL ADMINISTRADOR</h1>"; ?>
  <br>
	<!--
	<div class="canciones-favoritos">
		<h2>Mis canciones favoritas</h2>
		<br>
		
	</div>
-->
	</main>

</body>

</html>