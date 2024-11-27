<?php
require_once "../database/conexion.php";

/**
 * FUNCION QUE INSERTA UN NUEVO USUARIO EN LA TABLA
 */
function insertarUsuario($nombre, $apellido, $email, $usuario, $password) {
  try {
    $conexion = conexionDB();
    $insert = "INSERT INTO usuarios (nombre, apellido, email, usuario, password)
    VALUES (:nombre, :apellido, :email, :usuario, :password)";
    $consulta = $conexion->prepare($insert);
    $consulta->bindValue(':nombre', $nombre);
    $consulta->bindValue(':apellido', $apellido);
    $consulta->bindValue(':email', $email);
    $consulta->bindValue(':usuario', $usuario);
    $consulta->bindValue(':password', $password);
    $consulta->execute();
  } catch (PDOException $e) {  
    echo "Error al realizar la inserción. " . $e->getMessage();
  } finally {
    $conexion = null;
  }
}

/**
 * FUNCION QUE MUESTRA TODAS LAS FILAS DE LA TABLA ALUMNOS
 */
function getUsuarios() {
  try {
    $conexion = conexionDB();
    $select = "SELECT * FROM usuarios";
    $consulta = $conexion->prepare($select);
    $consulta->execute();
    $resultado = $consulta->fetchAll(PDO::FETCH_ASSOC);
    return $resultado;
  } catch (PDOException $e) {  
    echo "Error al realizar la consulta. " . $e->getMessage();
  } finally {
    $conexion = null;
  }
}

/**
 * FUNCION QUE MUESTRA UN REGISTRO 'usuario' DE LA TABLA 
 */
function getUsuarioUser($usuario) {
  try{
    $conexion = conexionDB();
    $select = "SELECT usuario FROM usuarios WHERE usuario = :usuario";
    $consulta = $conexion->prepare($select);
    $consulta->bindValue(':usuario', $usuario);
    $consulta->execute();
    return $consulta->fetchColumn();
  } catch (PDOException $e) {
    echo "Error al realizar la consulta. ". $e->getMessage();
    return false;
  }
}


/**
 * FUNCION QUE MUESTRA UN REGISTRO 'password' DE LA TABLA 
 */
function getUsuarioPass($usuario) {
  try{
    $conexion = conexionDB();
    $select = "SELECT password FROM usuarios WHERE usuario = :usuario"; //recuperamos la contraseña
    $consulta = $conexion->prepare($select);
    $consulta->bindValue(':usuario', $usuario);
    $consulta->execute();
    return $consulta->fetchColumn();
  } catch (PDOException $e) {
    echo "Error al realizar la consulta. ". $e->getMessage();
    return false;
  }
}