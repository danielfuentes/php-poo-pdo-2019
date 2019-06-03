<!DOCTYPE html>

<?php
require_once("autoload.php");
if (isset($_GET["id"])) {
  $id_usuario=$_GET["id"];
  $usuarioSeleccionado = Query::mostrarUsuario($pdo,'users',$id_usuario);
}

//esto se ejecuta si el usuario indica que desea borrar el usuario
if (isset($_POST["borrar"])) {
  Query::borrarUsuario($pdo,'users',$id_usuario);
  header('Location:listadoUsuariosAdmin.php');
  exit;
//var_dump($_POST);
}
elseif (isset ($_POST["no"])) {
  header("Location:listadoUsuariosAdmin.php");
  exit;
}
 ?>
<html lang="es" dir="ltr">
  <head>
      <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <meta charset="utf-8">
    <title></title>
  </head>
  <body>
<div class="container">


    <form class="" action="" method="post">
      <p>Esta seguro que quiere eliminar este usuario?</p>
      <input type="submit" name="borrar" value="si">
      <input type="submit" name="no" value="no">
      <input type="hidden" name="id" value="<?=$id_usuario;?>">
   </form>

    <?php foreach ($usuarioSeleccionado as $key => $value):?>
      <h1><?= $value["name"] ;?></h1>
    <?php endforeach;?>
    <ul>
    <?php foreach ($usuarioSeleccionado as $index => $attributes) : ?>
      <?php foreach($attributes as $key => $value): ?>
        <li><?= $key." : ".$value ?> </li>
      <?php endforeach;?>
    <?php endforeach;?>
    </ul>
</div>
  </body>
  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</html>
