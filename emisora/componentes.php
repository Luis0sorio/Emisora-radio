<?php 

require_once "./database/conexion.php";

function getAllComponents() {
  $conexion = conexionDB();
  try {
    $select = "SELECT * FROM usuarios";
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
  $usuarios = getAllComponents();
  $html = "<table border='1'>";
  $html .= "<tr>
  <th>Nombre</th>
  <th>Grupo</th>
  <th>Instrumento</th>
  </tr>";
  foreach ($usuarios as $user) {
    $html .= "<tr>
    <td>{$user['nombre']}</td>
    <td>{$user['grupo']}</td>
    <td>{$user['instrumento']}</td>
    </tr>";
  }
  $html .= "</table>";
  return $html;
}