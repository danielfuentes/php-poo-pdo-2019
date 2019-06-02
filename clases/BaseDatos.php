<?php
abstract class BaseDatos{
    abstract public function guardar(array $registro);
    abstract public function leer();
    abstract public function borrar();
    abstract public function actualizar();
}