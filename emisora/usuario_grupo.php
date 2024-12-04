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
    $select = "SELECT ug.id, g.nombre, g.genero FROM usuarios_grupos ug
    JOIN grupos g ON ug.grupoId = g.grupoId
    WHERE ug.usuarioId = :usuarioId";
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
  $html = "<table class='tabla'>";
  $html .= "<tr class='bordes'>
  <th>Nombre</th>
  <th>Género</th>
  <th></th>
  </tr>";
  foreach($favoritos as $fav){
    $html .= "<tr class='tuplas'>
    <td>{$fav['nombre']}</td>
    <td>{$fav['genero']}</td>
    <td class='delete'>
      <form method='POST'>
        <input type='hidden' name='id' value='{$fav['id']}'>
        <input type='submit' name='delete' value='Quitar'>
      </form>
    </td>
    </tr>";
  }
  $html .= "</table>";
  return $html;
}

/**
 * 
 * FUNCION QUE RECOGE EL ID DE LA RELACION (GRUPOS FAVORITOS-USUARIOS_GRUPOS) EN EL FORMULARIO DE ENVIO
 * @return int - el valor correspondiente al id de cada campo
 * @return null - no devuelve nada si no hacemos nada 
 */
function obtenerFavoritoById(){
  if (isset($_POST['id'])) {
    return $_POST['id']; 
  }
  return null;
}

function borrarFavorito($id) {
  try {
    $conexion = conexionDB();
    $delete = "DELETE FROM usuarios_grupos WHERE id = :id";
    $consulta = $conexion->prepare($delete);
    $consulta->bindValue(':id', $id);
    $consulta->execute();
  } catch (PDOException $e) {
    echo "Error al eliminar el favorito: " . $e->getMessage();
  } finally {
    $conexion = null;
  }
}