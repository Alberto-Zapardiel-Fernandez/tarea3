<?php
//Archivo para hacer la inserción o el update según el parámetro que le mandemos y luego redireccionar
//Requerimos la conexión
require 'conexion.php';
$nombre = $_POST['nombre'];
$titulo = $_POST['titulo'];
$descripcion = $_POST['descripcion'];
$prioridad = $_POST['prioridades'];
$captura = "error_404.png";

if (isset($_POST['id'])) {

  $id = $_POST['id'];
  try {
    switch ($prioridad) {
      case 'Baja':
        $prioridad = 1;
        break;
      case 'Media':
        $prioridad = 2;
        break;
      case 'Alta':
        $prioridad = 3;
        break;
      case 'Crítica':
        $prioridad = 4;
        break;
    }
    //Si viene el id es xq vamos por el update, entonces usamos update
    $stmt = $conexion->prepare("UPDATE incidencias SET nombre = ?, titulo = ?, descripcion = ?, prioridad = ?,captura = ? WHERE id = ?", );

    $resultado = $stmt->execute([$nombre, $titulo, $descripcion, $prioridad, $captura, $id]);
    header('Location:listado.php?insertado=4');
  } catch (\Throwable $th) {
    header('Location:listado.php?insertado=5');
    echo $th->getMessage();
  }
} else {
  //Si no viene id entonces es una incidencia nueva, autogenerada la id autoincremental
  try {
    switch ($prioridad) {
      case 'Baja':
        $prioridad = 1;
        break;
      case 'Media':
        $prioridad = 2;
        break;
      case 'Alta':
        $prioridad = 3;
        break;
      case 'Crítica':
        $prioridad = 4;
        break;
    }
    //Preparamos 
    $stmt = $conexion->prepare("INSERT INTO incidencias (nombre,titulo,descripcion,prioridad,captura) VALUES (?,?,?,?,?)");

    $resultado = $stmt->execute(array($nombre, $titulo, $descripcion, $prioridad, $captura));

    header('Location:listado.php?insertado=1');
  } catch (\Throwable $th) {
    header('Location:listado.php?insertado=0');
  }
}