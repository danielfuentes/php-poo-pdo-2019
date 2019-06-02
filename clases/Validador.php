<?php
class Validador{

    public function validacionUsuario($usuario){
        
        $errores=array();
        $nombre = trim($usuario->getNombre());
        if(isset($nombre)) {
            if(empty($nombre)){
                $errores["nombre"]= "El campo nombre no debe estar vacio";
            }
        }
    
        $email = trim($usuario->getEmail());
        if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
            $errores["email"]="Email invalido !!!!!";
        }
        $password= trim($usuario->getPassword());
   
        $repassword = trim($usuario->getRepassword());
        

        if(empty($password)){
            $errores["password"]= "Hermano querido el campo password no lo podés dejar en blanco";
        }elseif (strlen($password)<6) {
            $errores["password"]="La contraseña debe tener como mínimo 6 caracteres";
        }
        if(isset($repassword)){
            if ($password != $repassword) {
                $errores["repassword"]="Las contraseñas no coinciden";
            }
        }
        if($usuario->getAvatar()!=null){
            if($_FILES["avatar"]["error"]!=0){
                $errores["avatar"]="Error debe subir imagen";
            }else{
                $nombre = $_FILES["avatar"]["name"];
                $ext = pathinfo($nombre,PATHINFO_EXTENSION);
                if($ext != "png" && $ext != "jpg"){
                    $errores["avatar"]="Debe seleccionar archivo png ó jpg";
                }
            }
        }
    
        return $errores;
    }
    //Metodo creado para validar el login del usuario
    public function validacionLogin($usuario){
        $errores=array();
    
        $email = trim($usuario->getEmail());
        if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
            $errores["email"]="Email invalido !!!!!";
        }
        $password= trim($usuario->getPassword());
       
        if(empty($password)){
            $errores["password"]= "Hermano querido el campo password no lo podés dejar en blanco";
        }elseif (strlen($password)<6) {
            $errores["password"]="La contraseña debe tener como mínimo 6 caracteres";
        }
    
        return $errores;
    }
    //Método para validar si el usuario desea recuperar su contraseña
    public function validacionOlvide($usuario){
        
        $errores=array();
    
        $email = trim($usuario->getEmail());
        if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
            $errores["email"]="Email invalido !!!!!";
        }
        $password= trim($usuario->getPassword());
   
        $repassword = trim($usuario->getRepassword());
        

        if(empty($password)){
            $errores["password"]= "Hermano querido el campo password no lo podés dejar en blanco";
        }elseif (strlen($password)<6) {
            $errores["password"]="La contraseña debe tener como mínimo 6 caracteres";
        }
        if(empty($repassword)){
            $errores["repassword"]= "Hermano querido el campo confirmar nuevo password no lo podés dejar en blanco";
        }
    
        return $errores;
    }


}

