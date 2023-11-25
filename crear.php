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
  <h1>
    <?php echo !$conectado ?? 'No conectado' ?>
  </h1>
  <div class="container">
    <div class="d-flex justify-content-around align-items-center bg-warning">
      <h1>MiEmpresa</h1>
      <h2>Gestión de incidencias</h2>
    </div>
    <br>
    <h3>Agregar incidencia</h4>
      <p>Rellena el siguiente formulario para registrar tu incidencia:</p>
      <br>
      <form action="insertar.php" method="post" name="form">
        <label for="nombre">Nombre:</label>
        <input type="text" name="nombre" id="nombre">
        <label for="titulo">Título:</label>
        <input type="text" name="titulo" id="titulo">
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
        <div class="mb-3">
          <label for="formFile" class="form-label">Adjunta una captura si lo deseas:</label>
          <input class="form-control" type="file" id="formFile">
        </div>
        <button type="submit" class="btn btn-outline-warning text-dark">Enviar</button>
        <a href="listado.php" class="btn btn-outline-warning text-dark">Volver al inicio</a>
      </form>
  </div>

</body>

</html>