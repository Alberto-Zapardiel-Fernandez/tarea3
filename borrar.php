<?php
//Requerimos la conexión
require 'conexion.php';
//Incluímos la cabecera al inicio
include "cabecera.php";
$conectado = $conexion === false ? false : true;
$borrar = false;
$id = 0;
//Identificamos cual es el id
if (isset($_GET['id2'])) {
  $id = $_GET['id2'];
}
//Si el id es distinto de 0 borramos
if ($id != 0) {
  echo $id;
  $resultado = $conexion->exec("DELETE FROM incidencias WHERE id = '$id'");
  //Según el resultado de la consulta enviamos un código u otro para pintarlo
  if ($resultado == 1) {
    header('Location:listado.php?insertado=2');
  } else {
    header('Location:listado.php?insertado=3');

  }

}
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
    <h4>Borrar Registro</h4>
    <p>¿Estás seguro que deseas borrar el registro?</p>
    <form action="<?php echo $_SERVER['PHP_SELF']; ?>">
      <!--Hago el set del id en un campo oculto para pasarlo de vuelta a borrar-->
      <input type="hidden" name="id2" value="<?php if (isset($_GET['id'])) {
        echo $_GET['id'];
      } ?>">
      <button type="submit" class="btn btn-outline-warning text-dark">Si</button>
      <a href="listado.php" class="btn btn-outline-warning text-dark">No</a>
    </form>
  </div>

</body>

</html>