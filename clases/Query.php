<?php
class Query{
    static public function listado($pdo,$tabla){
        //Aquí ejecuto la consulta deseada, para mostrar algunos campos del usuario
        $sql="select $tabla.id, $tabla.name, $tabla.email from $tabla";
        //Aquí ejecuto el prepare de la sentencia, noten que lo estoy ejecutando de forma directa haciendo uso del método query de la clase PDO, es para que vean que se puede trabajar de diferentes formas
        $consulta= $pdo->query($sql);
        //Aquí ejecuto la consulta que tengo preparada, para así traer todos los usuarios registrados y almacenarlos en la variable $listado, la cual retorno
        $listado=$consulta->fetchall(PDO::FETCH_ASSOC);
        return $listado;
    }
    static public function mostrarUsuario($pdo,$tabla,$idUsuario){
        //En esta otra consulta hago uso del statement que ofrece PDO
        $sql = "select $tabla.id, $tabla.name, $tabla.email, $tabla.avatar,$tabla.role from $tabla where $tabla.id = '$idUsuario'";
        //Aquí hago el prepare de los datos de mi consulta (Query)
        $query = $pdo->prepare($sql);
        //Aquí ejecuto la consulta
        $query->execute();
        //Aquí hago uso del método fetchAll, pero también puedo usar sólo el métodp fetch, ya que sólo voy a buscar al usuario que cumpla con la condificón indicada 
        $usuarioEncontrado=$query->fetchAll(PDO::FETCH_ASSOC);
        //Retorno el array sólo del usuario encontrado
        return $usuarioEncontrado;
    }
    static public function borrarUsuario($pdo,$tabla,$idUsuario){
        //Aquí armo el query que deseo, en este caso es el borrado de un usuario específico
        $sql="delete from $tabla where $tabla.id=:id";
        //Aquí preparo la consulta, tal como me lo indica la secuencia de trabajar con PDO
        $query=$pdo->prepare($sql);
        //Aquí vean que ejecuto el Bindeo de Parámetros - usando el bindValue
        $query->bindValue(':id',$idUsuario);
        //Aquí ejecuto el borrado del usuario
        $query->execute();
    }
    static public function usuarioModificar($pdo,$tabla,$idUsuario){
        $sql = "select $tabla.id, $tabla.name, $tabla.email, $tabla.role from $tabla where $tabla.id = '$idUsuario'";
        $query = $pdo->prepare($sql);
        $query->execute();
        $usuarioModificar=$query->fetch(PDO::FETCH_ASSOC);
        return $usuarioModificar;
    }
}