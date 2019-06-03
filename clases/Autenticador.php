<?php
class Autenticador{
    static public function iniciarSession(){
        if(!isset($_SESSION)){
            session_start();
        }
    }
    static public function  verificarPassword($password,$passwordHash){
        return password_verify($password,$passwordHash);
    }
    static public function seteoSesion($user){
        
        $_SESSION["name"]=$user["name"];
        $_SESSION["email"] = $user["email"];
        $_SESSION["role"]= $user["role"];
        $_SESSION["avatar"]= $user["avatar"];
    }
    static public function seteoCookie($user){
            setcookie("email",$dato["email"],time()+3600);
            setcookie("password",$dato["password"],time()+3600);
    }
    static public function validarUsuario(){
        if(isset($_SESSION["email"])){
            return true;
        }elseif (isset($_COOKIE["email"])) {
            $_SESSION["email"]=$_COOKIE["email"];
            return true;
        }else{
            return false;
        }
    }
}

