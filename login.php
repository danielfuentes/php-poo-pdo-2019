<?php
require_once("autoload.php");
if($_POST){
  $tipoConexion = "MYSQL";
  if($tipoConexion=="JSON"){
      $usuario = new Usuario($_POST["email"],$_POST["password"]);
      $errores= $validar->validacionLogin($usuario);
      if(count($errores)==0){
      
        $usuarioEncontrado = $json->buscarPorEmail($usuario->getEmail());
        if($usuarioEncontrado == null){
          $errores["email"]="Usuario no existe";
        }else{
          if(Autenticador::verificarPassword($usuario->getPassword(),$usuarioEncontrado["password"] )!=true){
            $errores["password"]="Error en los datos verifique";
          }else{
            Autenticador::seteoSesion($usuarioEncontrado);
            if(isset($_POST["recordar"])){
              Autenticador::seteoCookie($usuarioEncontrado);
            }
            if(Autenticador::validarUsuario()){
              redirect("perfil.php");
            }else{
              redirect("registro.php");
            }
          }
        }
      }
  }else{
    
      $usuario = new Usuario($_POST["email"],$_POST["password"]);
      $errores= $validar->validacionLogin($usuario);
      if(count($errores)==0){
        $usuarioEncontrado = BaseMYSQL::buscarPorEmail($usuario->getEmail(),$pdo,'users');
        if($usuarioEncontrado == false){
          $errores["email"]="Usuario no registrado";
        }else{
          if(Autenticador::verificarPassword($usuario->getPassword(),$usuarioEncontrado["password"] )!=true){
            $errores["password"]="Error en los datos verifique";
          }else{
            Autenticador::seteoSesion($usuarioEncontrado);
            if(isset($_POST["recordar"])){
              Autenticador::seteoCookie($usuarioEncontrado);
            }
            if(Autenticador::validarUsuario()){
              redirect("perfil.php");
            }else{
              redirect("registro.php");
            }
          }
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
  <title>Login</title>
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
          <h2>Inicio de sesión</h2>
          <form action="" method="POST"   >
            <label>Email:</label>
            <input name="email" type="text" id="email"   value="<?=isset($errores["email"])? "":inputUsuario("email") ;?>" placeholder="Correo electrónico"/>
            <br>
            <label>Contraseña:</label>
          
            <input name="password" type="password" id="password"  value="" placeholder="Contraseña..." />
            <br>
            
            
            <input name="recordar" type="checkbox" id="recordarme" value="recordar"/> 
            <label>Recuerdarme </label>
            <a href="olvidePassword.php">Olvide mi Contraseña</a>
            <br>
            
            <button class="btn-buttom btn-primary" type="submit">Entrar</button>
          </form>
        
      </article> 
    </section>

    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
  </div>
</body>

</html>
