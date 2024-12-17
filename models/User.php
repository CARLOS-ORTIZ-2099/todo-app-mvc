<?php

// el modelo es el que deberia de conectarse con la db
require_once 'database/Db.php';
class  User
{
  // definicion de propiedades y su tipado
  private $id;
  private $name;
  private $lastname;
  private $email;
  private $password;
  private $bio;
  private $avatar;
  private $db;

  // apenas se haga la instancia de esta clase se ejecutara la logica inicial 
  // del constructor, esta sera la conexion a la db
  public function __construct()
  {
    $this->db = Database::connect();
  }

  // getter

  public function getPassword()
  {
    return $this->password;
  }

  // seter
  public function setId($id)
  {
    $this->id = $id;
  }

  public function setName($name)
  {
    $this->name = $this->db->real_escape_string($name);
  }

  public function setLastname($lastname)
  {
    $this->lastname = $this->db->real_escape_string($lastname);
  }

  public function setEmail($email)
  {
    $this->email = $this->db->real_escape_string($email);
  }

  public function setBio($bio)
  {
    $this->bio = $this->db->real_escape_string($bio);
  }
  public function setAvatar($avatar)
  {
    $this->avatar = $avatar;
  }


  // aqui hashear el password
  public function setPassword($password, $shouldHash = false)
  {
    $this->password = $this->db->real_escape_string($password);
    $shouldHash ? $this->password = password_hash($this->password, PASSWORD_BCRYPT, ['coast' => 5]) : '';
  }


  // funcion que determina que campo se deben actualizar
  private function setFields()
  {
    $data =
      [
        'name' => $this->name,
        'email' =>  $this->email,
        'password' =>  $this->password,
        'lastname' => $this->lastname,
        'bio' =>  $this->bio,
        'avatar' => $this->avatar
      ];
    $superQuery = "";
    foreach ($data as $key => $value) {
      $value && $superQuery .= "$key  =   '$value' " . ",";
    }
    return  substr($superQuery, 0, -1);
  }


  // consultas a la db

  // registrar usuario
  public function register()
  {

    // primero verificamos si ya existe un usuario registrado con el mismo
    // email que se intenta crear ahora

    $search = "SELECT * FROM users WHERE email = '{$this->email}';";
    $insert = "INSERT INTO users (name, lastname, email, password) VALUES 
    ('{$this->name}', '{$this->lastname}', '{$this->email}', '{$this->password}'); ";

    // retorna objeto de mysql
    $userFound =  $this->db->query($search);

    if ($userFound->num_rows > 0) {
      return false;
    }
    // hacemos la query de insercion
    else {
      $insertUser = $this->db->query($insert);
      $response = $insertUser ? true : false;
      return $response;
    }
  }

  public function login()
  {
    // verificamos si hay un usuario con el email dado
    $search = "SELECT * FROM users WHERE email = '{$this->email}';";
    $userFound =  $this->db->query($search);

    if ($userFound->num_rows === 1) {
      // echo 'existe el usuario con el email'.$this->email ;
      // luego corroboramos el password
      $user = $userFound->fetch_assoc();
      // luego corroboramos si el password mandado coincide con el de la db
      $isValid = password_verify($this->password, $user['password']);
      return $isValid ? $user : false;
    } else {
      return false;
    }
  }


  public function getUser()
  {
    $query = "SELECT user_id, name, email, lastname, avatar, bio FROM users WHERE user_id = '{$this->id}';";
    $result = $this->db->query($query);
    return $result->fetch_assoc();
  }


  public function editProfile()
  {
    try {
      $query = "UPDATE users SET " . $this->setFields();
      $query .= " WHERE user_id = '{$this->id}' ; ";
      $result = $this->db->query($query);
      return $result;
    } catch (Exception $e) {
      return $e->getMessage();
      die();
    }
  }
}
