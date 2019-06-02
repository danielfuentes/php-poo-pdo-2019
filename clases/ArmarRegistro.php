<?php
class ArmarRegistro{
    public function armarAvatar($imagen){
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
            
    public function armarUsuario($registro,$avatar){
        
        $usuario = [
            "name"=>$registro->getNombre(),
            "email"=>$registro->getEmail(),
            "password"=> Encriptar::hashPassword($registro->getPassword()),
            "avatar"=>$avatar,
            "role"=>1
        ];
    
        return $usuario;
    }
}