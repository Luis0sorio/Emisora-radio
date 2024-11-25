
<?php 

require_once "../config.php";

function conexionDB() {
  try {
    $conexion = new PDO (DSN, USER, PASS);
    $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    return $conexion;
  } catch (PDOException $e) {
    echo "Error al establecer la conexion con la base de datos. " . $e->getMessage();
  }
}