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
/**
 * FUNCION QUE MUESTRA LA TABLA DE LOS GRUPOS MUSICALES.
 * 
 * @param mixed $grupos - recibe el array con los datos de los grupos de la funcion anterior.
 * @return string - devuelve el código HTML de la tabla.
 */
function toTableGrupos($grupos = []) {
  if (empty($grupos)) {
    return "<p>No se encontraron resultados.</p>";
  }
  // $grupos = getAllGroups();
  $html = "<table class='tabla'>";
  $html .= "<tr class='bordes'>
  <th>Nombre</th>
  <th>Creación</th>
  <th>Origen</th>
  <th>Género</th>
  <th></th>
  </tr>";
  foreach ($grupos as $grupo) {
    $html .= "<tr class='tuplas'>
    <td>{$grupo['nombre']}</td>
    <td>{$grupo['creacion']}</td>
    <td>{$grupo['origen']}</td>
    <td>{$grupo['genero']}</td>
    <td class='like'>    
      <form method='POST'>
        <input type='hidden' name='grupoId' value='{$grupo['grupoId']}'>
        <input type='submit' name='like' value='LIKE'>
      </form>
    </td>
    </tr>";
  }
  $html .= "</table>";
  return $html;
}


/**
 * FUNCION PARA FILTRAR POR GRUPO.
 * @param string $palabra - recibe una palabra introducida por el usuario.
 * @return array - devuelve un array asociativo con los resultados.
 * @return - 
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