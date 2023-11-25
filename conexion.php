<?php
// parámetros
$host = "localhost";
$db = "tarea3";
$user = "root";
$pass = "root";
$dsn = "mysql:host=$host;dbname=$db;charset=utf8mb4";
$conexion;
//Intentamos la conexión
try {
  $conexion = new PDO($dsn, $user, $pass);
  $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $ex) {
  //Lanzamos el error
  die("Error en la conexion, mensaje de error:  " . $ex->getMessage());
}