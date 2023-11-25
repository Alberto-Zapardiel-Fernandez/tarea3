<?php
//Requerimos la conexión
require 'conexion.php';
$conectado = $conexion === false ? false : true;
$insertado = "";
//Detectamos si le estamos mandando un parámetro para saber de dónde venimos y pintar el mensaje
if (isset($_GET['insertado'])) {
  if ($_GET['insertado'] == 0) {
    $insertado = 'Problema al insertar';
  } else if ($_GET['insertado'] == 1) {
    $insertado = 'Insertado';
  } else if ($_GET['insertado'] == 2) {
    $insertado = 'Borrado';
  } else if ($_GET['insertado'] == 3) {
    $insertado = 'No borrado';
  } else if ($_GET['insertado'] == 4) {
    $insertado = 'Actualizado';
  } else if ($_GET['insertado'] == 5) {
    $insertado = 'Error al actualizar';
  } else if ($_GET['insertado'] == 6) {
    $insertado = 'Error al subir el archivo al servidor';
  }
}

//Método para obtener la prioridad en texto
function getPrioridad($pri)
{
  require 'conexion.php';
  try {
    $query = $conexion->query("SELECT prioridad from prioridades where id = $pri");
    $respuesta = $query->fetch();
    return $respuesta['prioridad'];
  } catch (Exception $exception) {
    die("Error en la query, mensaje de error:  " . $ex->getMessage());
  }
}
include "cabecera.php";
?>

<body>
  <div class="container">
    <div class="d-flex justify-content-around align-items-center bg-warning">
      <h1>MiEmpresa</h1>
      <h2>Gestión de incidencias</h2>
    </div>
    <h1 class="text-center text-success">
      <?php
      //Detectamos si estamos conectados y si se ha insertado o no la incidencia
      echo !$conectado ?? 'No conectado';
      if ($insertado != "") {
        echo $insertado;
      }
      ?>
    </h1>
    <br>
    <h4>Incidencias registradas:</h4>
    <?php
    //Buscamos las incidencias
    $incidencias = $conexion->query("SELECT * FROM incidencias");
    //Si las hay pintamos la tabla
    if ($incidencias->rowCount() > 0) {
      ?>
    <table class="table table-bordered border-black">
      <thead>
        <tr>
          <th scope="col">Nombre</th>
          <th scope="col">Error</th>
          <th scope="col">Prioridad</th>
          <th scope="col">Estado</th>
          <th scope="col">Acciones</th>
        </tr>
      </thead>
      <tbody>

        <?php
          //Recorremos el array de incidencias para pintar lo que queremos de la tabla
          while ($incidencia = $incidencias->fetch()) {
            echo '<tr><td>';
            //Nombre
            echo $incidencia["nombre"];
            echo '</td><td>';
            //titulo
            echo $incidencia["titulo"];
            echo '</td><td>';
            echo getPrioridad($incidencia["prioridad"]);
            //Siempre pendiente, si no estaría borrada, no se pide actualizar este campo
            echo '</td><td>Pendiente</td><td>';
            //BOTONES
            echo "<div class=\"d-flex justify-content-around align-items-center\">";
            echo "<a href=\"detalle.php?id={$incidencia['id']}\" class=\"btn btn-outline-warning text-dark\">Ver</a>";
            echo "<a href=\"update.php?id={$incidencia['id']}\" class=\"btn btn-outline-warning text-dark\">Actualizar</a>";
            echo "<a href=\"borrar.php?id={$incidencia['id']}\" class=\"btn btn-outline-warning text-dark\">Borrar</a>";
            echo '</td></tr>';
          }
          ?>
        <!--Cerramos la tabla-->
      </tbody>
    </table>
    <?php
    } else {
      //Si no encontramos incidencias pintamos el siguiente texto
      echo "<p class=\"fst-italic\">Actualmente no tiene incidencias</p><br><br>";
    }
    ?>

    <a href="crear.php" class="btn btn-outline-warning text-dark">Agregar incidencia</a>
  </div>

</body>

</html>