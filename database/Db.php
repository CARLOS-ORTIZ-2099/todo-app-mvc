<?php

class Database
{
  // hay dos formas de conectarnos a una base de datos la primera en con mysqli y la otra con pdo
  // la diferencia radica en que pdio es 100% orientado a objetos y se puede usar con multiples sgdb mientras que mysqli es un hibrido que permite la conexion tanto procedimenta(funciones) como poo, el problema es que solo permite conexiones con el sgbd mysql 
  static function connect()
  {
    // conexion poo
    $db = new mysqli('localhost', 'root', '', 'notes');
    // si la query fue erronea devolvera false si fue exitosa devolvera la data o true dependiendo del tipo de query
    $db->query("SET NAMES 'utf8'");
    return $db;
  }

  static function procedimental() {
    // conexion procedimental (funciones)
    $mysqli = mysqli_connect('localhost', 'root', '', 'notes');
    // validacion de error de manera procedimental
    if (mysqli_connect_errno($mysqli)) {
      echo "Fallo al conectar a MySQL: " . mysqli_connect_error();
    }
    // query de manera procedimental
    $resultado = mysqli_query($mysqli, "SELECT 'Un mundo lleno de ' AS _msg FROM DUAL");

    // procesando la data devuelta de la query de manera procedimental
    $fila = mysqli_fetch_assoc($resultado);
  }

  static function poo() {
    // conexion de forma poo
    $mysqli = new mysqli("ejemplo.com", "usuario", "contraseña", "basedatos");
    // validacion de error de manera poo
    if ($mysqli->connect_errno) {
        echo "Fallo al conectar a MySQL: " . $mysqli->connect_error;
    }
    // query de manera poo
    $resultado = $mysqli->query("SELECT 'elecciones para complacer a todos.' AS _msg FROM DUAL");

    // procesando la data devuelta de la query de manera poo
    $fila = $resultado->fetch_assoc();
  }

}
