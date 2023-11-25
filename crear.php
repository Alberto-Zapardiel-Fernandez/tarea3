<?php
//Requerimos la conexión
require 'conexion.php';
$conectado = $conexion === false ? false : true;
//Obtenemos las prioridades
$prioridadesList = $conexion->query("SELECT * FROM prioridades");
$prioridades = array();
//Las metemos en el array
while ($registro = $prioridadesList->fetch()) {
  array_push($prioridades, $registro['prioridad']);
}

//Incluímos la cabecera al inicio
include "cabecera.php";
?>

<body>
  <div class="container">
    <div class="d-flex justify-content-around align-items-center bg-warning">
      <h1>MiEmpresa</h1>
      <h2>Gestión de incidencias</h2>
    </div>
    <h1>
      <?php
      if (isset($_GET['error']) == 1) {
        echo "<h3 class=\"text-center text-danger\">El archivo debe ser una imagen</h3>";
      }
      echo !$conectado ?? 'No conectado' ?>
    </h1>
    <br>
    <h3>Agregar incidencia</h4>
      <p>Rellena el siguiente formulario para registrar tu incidencia:</p>
      <br>
      <form action="insertar.php" method="POST" enctype="multipart/form-data">
        <label for="nombre">Nombre:</label>
        <input type="text" name="nombre" id="nombre" required />
        <label for="titulo">Título:</label>
        <input type="text" name="titulo" id="titulo" required />
        <br>
        <br>
        <label for="descripcion">Descripción:</label>
        <br>
        <textarea name="descripcion" id="descripcion" cols="100" rows="10"></textarea>
        <br>
        <label for="prioridades">Prioridad</label>
        <select name="prioridades" id="prioridades">
          <?php
          //Pintamos dentro del select las prioridades
          foreach ($prioridades as $prioridad) {
            echo "<option value='$prioridad'>$prioridad</option>";
          }
          ?>
        </select>
        <br>
        <br>
        <label for="file" class="form-label">Adjunta una captura si lo deseas:</label>
        <input class="form-control" type="file" name="file" required />
        <br>
        <button type="submit" class="btn btn-outline-warning text-dark">Enviar</button>
        <a href="listado.php" class="btn btn-outline-warning text-dark">Volver al inicio</a>
      </form>
      <p>Nota: Pulsar ⬆️ para volver, por más que trato de redireccionar en insertar.php a listado.php no lo hace</p>
  </div>

</body>

</html>