<?php

// los controladores por lo general solo deberian agrupar metodos y no propiedades amenos que la situacion lo requiera
// estos se encargaran de interactuar con el modelo para luego mandar una respuesta al cliente

require_once 'models/User.php';


class UserController
{


  // aqui conectarse con el modelo user para registrar al usuario, pero antes sanitizar y validar los datos
  public function register()
  {
    // MODO EDICION
    if (isset($_SESSION['user']) && $_GET['id']) {
      $newUser = new User();
      foreach ($_POST as $key => $value) {
        $set = "set" . ucfirst($key);
        $value && $key = 'password' ?
          $newUser->$set($value, true) : $value && $newUser->$set($value);
      }
      // preguntar si existe un campo tipo file y si la imagen se subio correctamente
      if (isset($_FILES['avatar']) && $_FILES['avatar']['error'] == 0) {
        $file_name = $_FILES['avatar']['name'];
        $file_type = $_FILES['avatar']['type'];
        $file_tmp = $_FILES['avatar']['tmp_name'];
        $file_error = $_FILES['avatar']['error'];
        $file_size = $_FILES['avatar']['size'];
        $types = ['image/jpeg', 'image/png', 'image/jpg', 'image/webp'];
        $base = basename($file_tmp, '.tmp');
        $ext =  explode("/", $file_type);
        $nameFile = $base . "." . end($ext);
        $destiny = 'uploads/' . $nameFile;
        $isValidImage = false;

        // comprobar que el archivo sea del tipo indicado
        if (!in_array($file_type, $types)) {
          $_SESSION['edit_profile'] =
            [
              'message' => "la imagen no es del tipo correcto",
              'status' => 'error'
            ];
        }
        // comprobar que no supere el maximo permitido
        else if ($file_size > 2097152) {
          $_SESSION['edit_profile'] =
            [
              'message' => "inserta una imagen menor a 2mb",
              'status' => 'error'
            ];
        } else if (in_array($file_type, $types)) {
          if (!file_exists('uploads/')) {
            mkdir('uploads/', 0700);
          }
          $isValidImage = move_uploaded_file($file_tmp, $destiny);
        }

        if (!$isValidImage) {
          return  header('Location:' . base_url . "?controller=user&action=viewProfile");
        }
        $isValidImage && $newUser->setAvatar($nameFile);
      }

      $newUser->setId($_SESSION['user']['user_id']);
      $result = $newUser->editProfile();
      if ($result === true) {
        $_SESSION['edit_profile'] =
          [
            'message' => "se edito correctamente",
            'status' => 'success'
          ];
      } else {
        $_SESSION['edit_profile'] = [
          'message' => $result,
          'status' => 'error'
        ];
      }
      return header('Location:' . base_url . "?controller=user&action=viewProfile");
    }

    // MODO CREACION
    else if (isset($_POST) && !empty($_POST)) {
      // comprobar que todas esten presentes
      $name = isset($_POST['name']) ? $_POST['name'] : null;
      $lastname = isset($_POST['lastname']) ? $_POST['lastname'] : null;
      $email = isset($_POST['email']) ? $_POST['email'] : null;
      $password = isset($_POST['password']) ? $_POST['password'] : null;
      echo "<br/>";

      if (!$name || !$lastname || !$email || !$password) {
        $_SESSION['register'] =
          [
            'message' => "todos los campos son requeridos",
            'status' => 'error'
          ];
      } else {
        // conectarse con el modelo
        $newUser = new User();
        // setear valores
        $shouldHash = true; // determina si debe hashear el password
        $newUser->setName($name);
        $newUser->setLastName($lastname);
        $newUser->setEmail($email);
        $newUser->setPassword($password, $shouldHash);

        $result = $newUser->register();

        $result == true
          ? $_SESSION['register'] =
          [
            'message' => 'se creo usuario correctamente',
            'status' => 'success'
          ]
          : $_SESSION['register'] = ['message' => 'sucedio un error intenta luego', 'status' => 'error'];
      }
    }

    header("Location:" . base_url . "?controller=user&action=viewRegister");
  }

  public function viewRegister()
  {
    // validar si existe una session si es asi no mostrar el template login
    if (isset($_SESSION['user'])) {
      return  header('Location:' . base_url);
    }
    require_once 'views/registro/registro.php';
  }

  public function viewProfile()
  {
    // validar que el usuario este autenticado antes de acceder a los datos 
    // de su perfil
    if (isset($_SESSION['user'])) {
      // $user = $_SESSION['user'];
      $id = $_SESSION['user']['user_id'];
      $newUser = new User();
      $newUser->setId($id);
      $user = $newUser->getUser();
      // aqui igualar el valor de la session con lo que retorne la query
      if ($user) {
        $_SESSION['user'] = $user;
      }
      require_once 'views/profile/profile.php';
    } else {
      header('Location:' . base_url);
    }
  }

  public function showFormEdit()
  {
    if (isset($_SESSION['user'])) {
      $editProfile = true;
      $id = $_SESSION['user']['user_id'];
      // luego conectarme con el modelo para que este traiga los datos del usuario
      // podria trabajar con la data de la session pero esta puede no estar actualizada, preferiblemente hacer una query para traer datos actuales
      $newUser = new User();
      $newUser->setId($id);
      $userFound = $newUser->getUser();
      var_dump($userFound);
      require_once 'views/registro/registro.php';
    } else {
      header('Location:' . base_url);
    }
  }


  public function login()
  {

    if (isset($_POST) && !empty($_POST)) {
      /* var_dump($_POST); */
      // comprobar que todas esten presentes
      $email = isset($_POST['email']) ? $_POST['email'] : null;
      $password = isset($_POST['password']) ? $_POST['password'] : null;
      echo "<br/>";

      if (!$email || !$password) {
        $_SESSION['error_login'] = "para loguearte inserta todos los campos";
      } else {
        // conectarse con el modelo
        $newUser = new User();
        // setear valores
        $newUser->setEmail($email);
        $newUser->setPassword($password);

        $result = $newUser->login();
        if ($result && is_array($result)) {
          $_SESSION['user'] = $result;
          // eliminando password ya que este es un dato sensible y no se mostrara
          unset($_SESSION['user']['password']);
        } else {
          $_SESSION['error_login'] = 'identificacion fallida';
        }
      }
    }
    header("Location:" . base_url);
  }


  public function logout()
  {
    // aqui debemos eliminar la sesion del usuario autenticado
    if (isset($_SESSION['user'])) {
      unset($_SESSION['user']);
    }
    header('Location:' . base_url);
  }
}
