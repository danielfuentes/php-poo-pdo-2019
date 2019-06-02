<?php
//Aquí de entrada activo la session
session_start();
//Aquí llamo a mis helpers, los cuales son como pequeñas funciones particulares que se pueden usar en todo el sistema
require_once("helpers.php");
//Aquí comienzo a programar las funciones generales de mi sistema
function validar($datos,$bandera){
    $errores=[];
    if(isset($datos["nombre"])){
        $nombre = trim($datos["nombre"]);
        if(empty($nombre)){
            $errores["nombre"]= "El campo nombre no debe estar vacio";
        }
    }

    $email = trim($datos["email"]);
    if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
        $errores["email"]="Email invalido !!!!!";
    }
    $password= trim($datos["password"]);
    if(isset($datos["repassword"])){
        $repassword = trim($datos["repassword"]);
    }
    
    if(empty($password)){
        $errores["password"]= "Hermano mio el campo password no lo podés dejar en blanco";
    }elseif (strlen($password)<6) {
        $errores["password"]="La contraseña debe tener como mínimo 6 caracteres";
    }
    if(isset($datos["repassword"])){
        if ($password != $repassword) {
            $errores["repassword"]="Las contraseñas no coinciden";
        }
    }
    
    //Esta condición me ayuda a identificar de que proceso vengo, es decir de Registro, Login o de Olvide mi Contraseña, para registro manejo la bandera "registro" y para Olvide mi contraseña uso la bandera "olvide"
    if($bandera == "registro"){
        if($_FILES["avatar"]["error"]!=0){
            $errores["avatar"]="Error debe subir imagen";
        }
        $nombre = $_FILES["avatar"]["name"];
        $ext = pathinfo($nombre,PATHINFO_EXTENSION);
        if($ext != "png" && $ext != "jpg"){
            $errores["avatar"]="Debe seleccionar archivo png ó jpg";
        }
    
    }

    return $errores;
}
//Esta función me ayuda para la persistencia de los datos en el formulario, sólo si los datos dispuestos por el ususrio estan correctos, es decir si ese campo pasa nuestras validaciones
function inputUsuario($campo){
    if(isset($_POST[$campo])){
        return $_POST[$campo];
    }
}

//Esta función nos permite armar el registro cuando el usuario selecciona el avatar
function armarAvatar($imagen){
    $nombre = $imagen["avatar"]["name"];
    $ext = pathinfo($nombre,PATHINFO_EXTENSION);
    $archivoOrigen = $imagen["avatar"]["tmp_name"];
    $archivoDestino = dirname(__DIR__);
    $archivoDestino = $archivoDestino."/imagenes/";
    $avatar = uniqid();
    $archivoDestino = $archivoDestino.$avatar;
    $archivoDestino = $archivoDestino.".".$ext;
    move_uploaded_file($archivoOrigen,$archivoDestino);
    $avatar = $avatar.".".$ext;
    return $avatar;
}

//Esta función nos ayuda a preparar el array asociativo de mi registro
function armarRegistro($datos,$imagen){
    $usuario = [
        "nombre"=>$datos["nombre"],
        "email"=>$datos["email"],
        "password"=> password_hash($datos["password"],PASSWORD_DEFAULT),
        "avatar"=>$imagen,
        "perfil"=>1
    ];
    return $usuario;
}
//Función que nos permite guardar los datos en nuestro archivo json y de esa forma persistir los datos dispuestos por el usuario en el formulario
function guardarUsuario($usuario){
    $jsusuario = json_encode($usuario);
    file_put_contents('usuarios.json',$jsusuario. PHP_EOL, FILE_APPEND);
}

//Función que nos permite buscar por email, a ver si el usuario existe o no en nuestra base de datos, que ahorita es un archivo json.
function buscarEmail($email){
    $usuarios = abrirBaseDatos();
    if($usuarios!==null){
        foreach ($usuarios as $usuario) {
            if($email === $usuario["email"]){
                return $usuario;
            }
        }
    }
    
    return null;
}

//Esta función abre nuestro archivo json y lo prepara para eliminar el último registro en blanco y además, fijese que además genero el array asociativo del mismo. Convierto de json a array asociativo para mas adelante con la funcion "bucarEmail" poder recorrerlo y verificar si el usuario existe o no en mi base de datos.
function abrirBaseDatos(){
    if(file_exists("usuarios.json")){
        $baseDatosJson= file_get_contents("usuarios.json");
        $baseDatosJson = explode(PHP_EOL,$baseDatosJson);
        //Aquí saco el ultimo registro, el cual está en blanco
        array_pop($baseDatosJson);
        //Aquí recooro el array y creo mi array con todos los usuarios 
        foreach ($baseDatosJson as  $usuarios) {
            $arrayUsuarios[]= json_decode($usuarios,true);
        }
        //Aquí retorno el array de usuarios con todos sus datos
        return $arrayUsuarios;
    }else{
        return null;
    }    
}

//Esta función la cree para lograr determinar la creación del archivo json, pero ahora con la nueva clave del usuario, ya que el usuairo se le habia olvidado la misma, lo puedo hacer en una sóla función, sin embargo lo realice por separado, para que ustedes lo comprendieran mejor, trabajando todo por parte
function armarRegistroOlvide($datos){
    $usuarios = abrirBaseDatos();
    
    foreach ($usuarios as $key=>$usuario) {
        
        if($datos["email"]==$usuario["email"]){
            //Esta línea se las comente para que a futuro puedan probar si la clave nueva la van a grabar correctamente, la idea es verla antes de hashearla. le pueden aplicar un dd() y verificar que les trae
            //$usuario["password"]= $datos["password"];
            $usuario["password"]= password_hash($datos["password"],PASSWORD_DEFAULT);
            //Aquí guardamos el registro del usuario, pero con el password hasheado
            $usuarios[$key] = $usuario;    
        }
        //Si no es el usuario, entonces va de igual forma a guardar todo los usuarios
        $usuarios[$key] = $usuario;    
    }
    
    //Esto se los coloque para que sepan que con esta función podemos borrar un archivo
    unlink("usuarios.json");
    //Aquí vuelvo a recorrer el array para poder guardar un registro bajo el otro, haciendo uso de la constante de php PHP_EOL
    foreach ($usuarios as  $usuario) {
        $jsusuario = json_encode($usuario);
        file_put_contents('usuarios.json',$jsusuario. PHP_EOL,FILE_APPEND);
    }
 
//Esta función no retorna nada, ya que su  responsabilidad es guardar al usuario, pero con su nueva contraseña
}

//Aqui creo los las variables de session y de cookie de mi usuario que se está loguendo
function seteoUsuario($user,$dato){
    $_SESSION["nombre"]=$user["nombre"];
    $_SESSION["email"] = $user["email"];
    $_SESSION["perfil"]= $user["perfil"];
    $_SESSION["avatar"]= $user["avatar"];
    if(isset($dato["recordar"]) ){
        setcookie("email",$dato["email"],time()+3600);
        setcookie("password",$dato["password"],time()+3600);
    }
}
//Con esta función controlo si el usuario se logueo o ya tenemos las cookie en la máquina
function validarUsuario(){
    if($_SESSION["email"]){
        return true;
    }elseif ($_COOKIE["email"]) {
        $_SESSION["email"]=$_COOKIE["email"];
        return true;
    }else{
        return false;
    }
    
}