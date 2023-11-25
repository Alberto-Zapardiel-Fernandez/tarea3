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
if (isset($_GET['id']) != null) {
  $id = $_GET['id'];
  //Buscamos las incidencias
  $incidencia = $conexion->query("SELECT * FROM incidencias where id = '$id'");
  //Si las hay pintamos la tabla
  while ($i = $incidencia->fetch()) {
    $nombre = $i['nombre'];
    $titulo = $i['titulo'];
    $descripcion = $i['descripcion'];
    $prioridadNumero = $i['prioridad'];
    $captura = $i['captura'];
  }
} else {
  //Si no llega el id redireccionamos
  header('Location:listado.php');
}
$prioridadesList = $conexion->query("SELECT * FROM prioridades");
$prioridades = array();
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
    <h3>
      <?php echo !$conectado ?? 'No conectado' ?>
    </h3>
    <br>
    <h4>Detalles incidencias:</h4>
    <form action="insertar.php" method="POST" name="form" enctype="multipart/form-data">
      <input type="hidden" name="id" value="<?php echo $id ?>">
      <label for="nombre">Nombre:</label>
      <input type="text" name="nombre" id="nombre" value="<?php echo $nombre ?>" required />
      <label for="titulo">Título:</label>
      <input type="text" name="titulo" id="titulo" value="<?php echo $titulo ?>" required />
      <br>
      <br>
      <label for="descripcion">Descripción:</label>
      <br>
      <textarea name="descripcion" id="descripcion" cols="100" rows="10"><?php echo $descripcion ?></textarea>
      <br>
      <label for="prioridades">Prioridad</label>
      <select name="prioridades" id="prioridades">
        <?php
        require 'conexion.php';
        $nuevaPrioridad;
        //Traemos el nombre de la prioridad que nos llega
        try {
          $query = $conexion->query("SELECT prioridad from prioridades where id = $prioridadNumero");
          $respuesta = $query->fetch();
          $nuevaPrioridad = $respuesta['prioridad'];
          echo $nuevaPrioridad;
        } catch (PDOException $exception) {
          die("Error en la query, mensaje de error:  " . $ex->getMessage());
        }
        foreach ($prioridades as $prioridad) {
          //Si el nombre de la prioridad es igual lo ponemos en selected
          if ($nuevaPrioridad == $prioridad) {
            echo "<option value=$prioridad selected>$prioridad</option>";
          } else {
            echo "<option value=$prioridad>$prioridad</option>";
          }
        }
        ?>
      </select>
      <br>
      <br>
      <div class="mb-3">
        <label for="formFile" class="form-label">Adjunta una captura si lo deseas: </label>
        <!-- Por lo que veo no hay manera de ponerle el value por defecto a un input file
      He intentado ponerle el valor de images/$captura pero googleando parece ser que no lo acepta -->
        <input class="form-control" type="file" id="formFile" name="file" required />
      </div>
      <button type="submit" class="btn btn-outline-warning text-dark">Actualizar</button>
      <a href="listado.php" class="btn btn-outline-warning text-dark">Volver al inicio</a>
    </form>
    <p>Nota: Pulsar ⬆️ para volver, por más que trato de redireccionar en insertar.php a listado.php no lo hace</p>
  </div>

</body>

</html>