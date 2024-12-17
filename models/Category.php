<?php

require_once 'database/Db.php';
class  Category
{
  // definicion de propiedades y su tipado
  private $id;
  private $name;
  private static $db;

  // aqui tenemos que tener en cuenta que si instanciamos multiples veces la clase
  // Category lo que haremos sera sobreescribir el valor(conexion) de la propiedad
  // db esto ya que al ser una estatica se comparte para todas las instancias

    /*   public function __construct()
    {
      //$this->db = Database::connect();

      if (self::$db === null) {
          self::$db = Database::connect();
      }
    }
  */

    public static function initializeDb() {
        if (self::$db === null) {
            self::$db = Database::connect();
        }
    }

  // consultas a la db

  public static function getAllCategories() {
    $search = "SELECT * FROM categories";
    $categoriesFound =  self::$db->query($search);
    //$categoriesFound = $this->db->query($search);
    if($categoriesFound && $categoriesFound->num_rows > 0) {
      // retornar la data transformada en un array asociativo
      return $categoriesFound ; 
    }else {
      return [];
    }
  }
  public function createCategory() {}
  public function deleteCategory() {}
  public function editCategory() {}
}
