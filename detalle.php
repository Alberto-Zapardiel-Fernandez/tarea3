<?php
//Requerimos la conexión
require 'conexion.php';
$conectado = $conexion === false ? false : true;
$id;
$nombre;
$titulo;
$descripcion;
$prioridad;
$captura;
//Identificamos si viene el parámetro id
if (isset($_GET['id']) != null) {
  $id = $_GET['id'];
  try {
    //Obtenemos los datos de la incidencia según el id que llega y lo guardamos en variables
    $query = $conexion->query("SELECT * from incidencias where id = $id");
    $respuesta = $query->fetch();
    $nombre = $respuesta['nombre'];
    $descripcion = $respuesta['descripcion'];
    $titulo = $respuesta['titulo'];
    $prioridad = $respuesta['prioridad'];
    $captura = $respuesta['captura'];
  } catch (Exception $exception) {
    die("Error en la query, mensaje de error:  " . $ex->getMessage());
  }
} else {
  header('Location:listado.php');
}
//Incluímos la cabecera al inicio
include "cabecera.php";
?>

<body>
  <h1>
    <?php echo !$conectado ?? 'No conectado' ?>
  </h1>
  <div class="container">
    <div class="d-flex justify-content-around align-items-center bg-warning">
      <h1>MiEmpresa</h1>
      <h2>Gestión de incidencias</h2>
    </div>
    <br>
    <h4>Detalles incidencias:</h4>
    <!-- Pintamos los datos en la tabla -->
    <table class="table table-striped text-center w-75">
      <tr>
        <td class="bg-warning">
          Nombre:
        </td>
      </tr>
      <tr>
        <?php echo "<td>$nombre</td>" ?>
      </tr>
      <tr>
        <td class="bg-warning">
          Título:
        </td>
      </tr>
      <tr>
        <?php echo "<td>$titulo</td>" ?>
      </tr>
      <tr>
        <td class="bg-warning">
          Descripción:
        </td>
      </tr>
      <tr>
        <?php echo "<td>$descripcion</td>" ?>
      </tr>
      <tr>
        <td class="bg-warning">
          Prioridad:
        </td>
      </tr>
      <tr>
        <?php
        try {
          //Obtenemos el nombre de la prioridad que tiene la incidencia
          $query = $conexion->query("SELECT prioridad from prioridades where id = $prioridad");
          $respuesta = $query->fetch();
          $prioridad = $respuesta['prioridad'];
          echo "<td>$prioridad</td>";
        } catch (PDOException $exception) {
          echo "</br>";
          echo "<a href=\"listado.php\" class=\"btn btn-outline-warning text-dark\">Volver</a>";
          die("Error en la query, mensaje de error: " . $ex->getMessage());
        } ?>
      </tr>
      <tr>
        <td class="bg-warning">
          Archivo:
        </td>
      </tr>
      <tr>
        <?php echo "<td><img src='images/$captura' alt=\"Captura del error\"></td>" ?>
      </tr>
      <tr>
        <td class="bg-warning">
          Estado:
        </td>
      </tr>
      <tr>
        <td>Pendiente</td>
      </tr>
    </table>

    <a href="listado.php" class="btn btn-outline-warning text-dark">Volver</a>
    <br>
    <br>
    <br>
  </div>

</body>

</html>