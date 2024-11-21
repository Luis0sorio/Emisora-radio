
<?php 

require_once "./database/conexion.php";

function getAllUsers() {
  $conexion = conexionDB();
  try {
    $select = "SELECT nombre, apellido, email, usuario, admin FROM usuarios";
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
  $usuarios = getAllUsers();
  $html = "<table border='1'>";
  $html .= "<tr>
  <th>Nombre</th>
  <th>Apellido</th>
  <th>Email</th>
  <th>Usuario</th>
  <th>Admin</th>
  </tr>";
  foreach ($usuarios as $user) {
    $html .= "<tr>
    <td>{$user['nombre']}</td>
    <td>{$user['apellido']}</td>
    <td>{$user['email']}</td>
    <td>{$user['usuario']}</td>
    <td>{$user['admin']}</td>
    </tr>";
  }
  $html .= "</table>";
  return $html;
}