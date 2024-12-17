<?php

/* este archivo sera un controlador frontal es decir el que se
   encarga de recibir las peticiones del cliente y gestiona a que
   controlador ira cada peticion, es decir aqui se centralizaran 
   todas las solicitudes y se enviaran a su controlador correspondiente

*/
// TODA URL QUE LLEGE SE TRATA COMO GET A MENOS QUE SE ESPECIFIQUE LO CONTRARIO, YA QUE LA URL SIRVE PARA QUE EL
// CLIENTE PUEDA OBTENER UN RECURSO DE LA APP
session_start();
require_once './autoload.php';
require_once './helpers/Utils.php';
require_once './config/consts.php';
require_once './views/layout/header/header.php';
require_once './views/layout/sidebar/sidebar.php';


// unset($_SESSION['user']);

// aqui detectar la url
echo "<pre/>";
// var_dump($_SESSION);
echo "<pre/>";

//session_destroy();

// primero cachar el controlador y el metodo
$controller = '';
$action = '';

// si existe el controlador y el metodo, setear las variables
if (isset($_GET['controller']) && isset($_GET['action'])) {
  $controller = $_GET['controller'] . 'controller';
  $action = $_GET['action'];

  //echo $controller . ' ' . $action;
}
// si no existe ni el controlador ni el metodo, setear las variables a su valor por defecto
elseif (!isset($_GET['controller']) && !isset($_GET['action'])) {
  $controller = 'notes' . 'controller';
  $action = 'getAllNotes';

  //echo $controller . ' ' . $action;
}
// si existe uno de ellos y el otro no mandar un error y detener la ejecucion
elseif (!isset($_GET['controller']) || !isset($_GET['action'])) {
  ErrorController::showMessage();
  // aqui debemos de matar la funcion
  exit();
}



// una vez pasado el filtro, debemos de instanciar el controlador especificado y su respectivo metodo

/* echo $controller . ' ' . $action; */
// primero corroborar si el controlador existe

if (class_exists($controller)) {
  // ahora comprobar si el metodo de dicha clase esta definido
  if (method_exists($controller, $action)) {
    //echo "existe " . $action . ' en ' . $controller;
    // luego crear la instancia y ejecutar el metod, si existe dicho metodo de la clase
    $newController = new $controller();
    $newController->$action();
    // var_export($newController);
  }
  // si el metodo no existe mandar un error
  else {
    ErrorController::showMessage();
  }
} else {
  ErrorController::showMessage();
  // exit('error');
}

// method_exists('nombreclase', 'method') => me refiero a qui que pasa si
// nombreclase(el nombre de la clase) en realiadad esta definido como NombreClase => igual lo reconoce o no ?

require_once './views/layout/footer/footer.php';
