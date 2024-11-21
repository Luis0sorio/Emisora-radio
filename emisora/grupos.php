<?php 

require_once "./database/conexion.php";

function getAllGroups() {
  $conexion = conexionDB();
  try {
    $select = "SELECT * FROM grupos";
    $consulta = $conexion->prepare($select);
    $consulta->execute();
    return $consulta->fetchAll(PDO::FETCH_ASSOC);
  } catch (PDOException $e) {
    echo "Error al realizar la consulta. " . $e->getMessage();
  } finally {
    $conexion = null;
  }
}
function toTable() {
  $usuarios = getAllGroups();
  $html = "<table border='1'>";
  $html .= "<tr>
  <th>Nombre</th>
  <th>Creacion</th>
  <th>Origen</th>
  <th>Genero</th>
  </tr>";
  foreach ($usuarios as $user) {
    $html .= "<tr>
    <td>{$user['nombre']}</td>
    <td>{$user['creacion']}</td>
    <td>{$user['origen']}</td>
    <td>{$user['genero']}</td>
    </tr>";
  }
  $html .= "</table>";
  return $html;
}