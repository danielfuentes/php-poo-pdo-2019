<?php
function dd($valor){
    echo "<pre>";
        var_dump($valor);
        exit;
    echo "</pre>";
}
function inputUsuario($campo){
    if(isset($_POST[$campo])){
        return $_POST[$campo];
    }
}
function redirect($destino){
    header("location:".$destino);
    exit;
}




 ?>