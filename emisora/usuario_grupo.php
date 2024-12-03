<?php

require_once "../database/conexion.php";

function addGrupoFavorito($usuarioId, $grupoId) {
  try{
    $conexion = conexionDB();
    $insert = "INSERT INTO usuarios_grupos (usuarioId, grupoId)
    VALUES (:usuarioId, :grupoId) ";
    $consulta = $conexion->prepare($insert);
    $consulta->bindValue(':usuarioId', $usuarioId);
    $consulta->bindValue(':grupoId', $grupoId);
    $consulta->execute();
  } catch (PDOException $e) {
    echo "Error al realizar la inserción. " . $e->getMessage();
  } finally {
    $conexion = null;
  }
} 

function mostrarGruposFavoritos($usuarioId) {
  try{
    $conexion = conexionDB();
    $select = "SELECT g.* FROM grupos g WHERE g.grupoId IN 
    (SELECT ug.grupoId FROM usuarios_grupos ug
    WHERE ug.usuarioId = :usuarioId)";
    $consulta = $conexion->prepare($select);
    $consulta->bindValue(':usuarioId', $usuarioId);
    $consulta->execute();
    return $consulta->fetchAll(PDO::FETCH_ASSOC);
  } catch (PDOException $e) {
    echo "Error al mostrar los favoritos. " . $e->getMessage();
  } finally {
    $conexion = null;
  }
}

function toTableFavoritos($favoritos = []) {
  if (empty($favoritos)) {
    return "<span>No tienes seleccionado ningún grupo.</span>";
  }
  $html = "<table border='1'>";
  $html .= "<tr>
  <th>Nombre</th>
  <th>Género</th>
  </tr>";
  foreach($favoritos as $fav){
    $html .= "<tr>
    <td>{$fav['nombre']}</td>
    <td>{$fav['genero']}</td>
    </tr>";
  }
  $html .= "</table>";
  return $html;
}