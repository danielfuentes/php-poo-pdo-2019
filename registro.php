<?php
require_once("autoload.php");
if ($_POST){
  //Esta variable es quien controla si se desea guardar en archivo JSON o en MYSQL
  $tipoConexion = "MYSQL";
  // Si la función retorn false, significa que se va a guardar los datos en JSON, de lo contrario se guardará los datos en MYSQL
  if($tipoConexion=="JSON"){
    $usuario = new Usuario($_POST["email"],$_POST["password"],$_POST["repassword"],$_POST["nombre"],$_FILES );
  
    $errores = $validar->validacionUsuario($usuario, $_POST["repassword"]);
    
    if(count($errores)==0){
      $usuarioEncontrado = $json->buscarEmail($usuario->getEmail());
      
      if($usuarioEncontrado != null){
        $errores["email"]="Usuario ya registrado";
      }else{
        $avatar = $registro->armarAvatar($usuario->getAvatar());
        $registroUsuario = $registro->armarUsuario($usuario,$avatar);
      
        $json->guardar($registroUsuario);
      
        redirect ("login.php");
      }
    }
  }
 else{
   //Si arriba en la variable $tipoConexion se coloco "MYSQL", entonces genero todo el trabajo pero con MYSQL.
  //Aquí genero mi objeto usuario, partiendo de la clase Usuario 
  $usuario = new Usuario($_POST["email"],$_POST["password"],$_POST["repassword"],$_POST["nombre"],$_FILES );
  //Aquí verifico si los datos registrados por el usuario pasan las validaciones
  $errores = $validar->validacionUsuario($usuario, $_POST["repassword"]);
  //De no existir errores entonces:
  if(count($errores)==0){
    //Busco a ver si el usuario existe o no en la base de datos
    $usuarioEncontrado = BaseMYSQL::buscarPorEmail($usuario->getEmail(),$pdo,'users');
    if($usuarioEncontrado != false){
      $errores["email"]= "Usuario ya Registrado";
    }else{
      //Aquí guardo en el servidor la foto que el usuario seleccionó
      $avatar = $registro->armarAvatar($usuario->getAvatar());
      //Aquí procedo a guardar los datos del usuario en la base de datos, ,aquí le paso el objeto PDO, el objeto usuario, la tabla donde se va a guardar los datos y el nombre del archivo de la imagen del usuario.
      BaseMYSQL::guardarUsuario($pdo,$usuario,'users',$avatar);
      //Aquí redirecciono el usuario al login
      redirect ("login.php");
    }
  }

 } 
}


?>
<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
  <link rel="stylesheet" href="master.css">
  <title>Registro de Datos</title>
</head>

<body>
  <div class="container">
    <?php
      if(isset($errores)):?>
        <ul class="alert alert-danger">
          <?php
          foreach ($errores as $key => $value) :?>
            <li> <?=$value;?> </li>
            <?php endforeach;?>
        </ul>
      <?php endif;?>

  
    <section class="row  text-center ">
      <article class="col-12  " >
          <h2>Formulario de registro de datos</h2>
          <form action="" method="POST" enctype= "multipart/form-data"  >
            <label> Usuario:</label>
            
            <input name="nombre" type="text" id="nombre"  value="<?=(isset($errores["nombre"]) )? "" : inputUsuario("nombre");?>" placeholder="Nombre de usuario..." />
            <br>
            
            <label>Email:</label>
          
            <input name="email" type="text" id="email" value="<?=isset($errores["email"])? "":inputUsuario("email") ;?>" placeholder="Correo electrónico"/>
            <br>
            <label>Contraseña:</label>
          
            <input name="password" type="password" id="password" value="" placeholder="Contraseña..." />
            <br>
            <label>Confirmar contraseña:</label>
            
            <input name="repassword" type="password" id="repassword" value="" placeholder="Rectifique su contraseña" />
            <br>
            <input  type="file" name="avatar" value=""/>
            <br>
            <br>
            <button class="btn-buttom btn-primary" type="submit">Enviar</button>
            
            <button  class="btn-buttom btn-success" type="reset">Restablecer</button>
          </form>
        
      </article> 
    </section>

    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
  </div>
</body>

</html>
