<?php

// cierro sesión
session_start();
session_unset();
session_destroy();

// elimino la cookie
if (isset($_COOKIE['usuario'])) {
  setcookie('usuario', '', time() - 3600, "/"); // Expira la cookie
}

header("Location: login.php");
exit;

