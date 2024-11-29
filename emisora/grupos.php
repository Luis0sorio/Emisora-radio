<?php 

require_once "../database/conexion.php";

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
function toTableGrupos($grupos = []) {
  if (empty($grupos)) {
    return "<p>No se encontraron resultados.</p>";
  }
  // $grupos = getAllGroups();
  $html = "<table border='1'>";
  $html .= "<tr>
  <th>Nombre</th>
  <th>Creación</th>
  <th>Origen</th>
  <th>Género</th>
  <th></th>
  </tr>";
  foreach ($grupos as $grupo) {
    $html .= "<tr>
    <td>{$grupo['nombre']}</td>
    <td>{$grupo['creacion']}</td>
    <td>{$grupo['origen']}</td>
    <td>{$grupo['genero']}</td>
    <td>    
      <form>
        <input type='hidden' name='' value='{$grupo['grupoId']}'>
        <input type='submit' name='añadir' value='LIKE'>
      </form>
    </td>
    </tr>";
  }
  $html .= "</table>";
  return $html;
}

/**
 * FUNCION PARA FILTRAR POR GRUPO. INTRODUCES TEXTO Y MUESTRA LOS GRUPOS COINCIDENTES
 */
function buscarGrupo($palabra){
  try{
    $conexion = conexionDB();
    $select = "SELECT * FROM grupos WHERE nombre LIKE :palabra";
    $consulta = $conexion->prepare($select);
    $consulta->bindValue(':palabra', '%' . $palabra . '%');
    $consulta->execute(); 
    return $consulta->fetchAll(PDO::FETCH_ASSOC);
  } catch (PDOException $e) {
    echo "Error en la búsqueda." . $e->getMessage();
  } finally {
    $conexion = null;
  }
}