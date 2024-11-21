<?php 

require_once "./database/conexion.php";

function getAllEvents() {
  $conexion = conexionDB();
  try {
    $select = "SELECT * FROM eventos";
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
  $usuarios = getAllEvents();
  $html = "<table border='1'>";
  $html .= "<tr>
  <th>Nombre</th>
  <th>Descripcion</th>
  <th>Lugar</th>
  <th>Duracion</th>
  <th>Tipo de evento</th>
  <th>Asientos</th>
  </tr>";
  foreach ($usuarios as $user) {
    $html .= "<tr>
    <td>{$user['nombre']}</td>
    <td>{$user['descripcion']}</td>
    <td>{$user['lugar']}</td>
    <td>{$user['duracion']}</td>
    <td>{$user['tipoEvento']}</td>
    <td>{$user['asientosDisp']}</td>
    </tr>";
  }
  $html .= "</table>";
  return $html;
}