<?php
class Usuario{
    private $nombre;
    private $email;
    private $password;
    private $repassword;
    private $avatar;
    public function __construct($email,$password,$repassword=null, $nombre=null,$avatar=null){
        $this->nombre = $nombre;
        $this->email = $email;
        $this->password = $password;
        $this->repassword = $repassword;
        $this->avatar = $avatar;
    }
    public function getNombre(){
        return $this->nombre;
    }
    public function setNombre($nombre){
        $this->nombre = $nombre;
    }
    public function getEmail(){
        return $this->email;
    }
    public function setEmail($email){
        $this->email = $email;
    }
    public function getPassword(){
        return $this->password;
    }
    public function setPassword($password){
        $this->password = $password;
    }
    public function getRepassword(){
        return $this->repassword;
    }
    public function setRepassword($password){
        $this->repassword = $repassword;
    }

    public function getAvatar(){
       return $this->avatar;
    }
    public function setAvatar($avatar){
        $this->avatar = $avatar;
    }
    
}
?>