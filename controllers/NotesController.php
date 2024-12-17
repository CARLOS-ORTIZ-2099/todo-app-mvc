<?php

// invocar el modelo de categoria, para que me traiga todas las categorias
// y luego pasarsela al template del formulario para crear notas 
require_once 'models/Category.php';
require_once 'models/Note.php';


class NotesController
{

  // este metodo mostrara todas las notas de la app
  public function getAllNotes()
  {

    if (isset($_SESSION['user']['user_id'])) {
      $newNote = new Note();
      $newNote->setUser($_SESSION['user']['user_id']);
      $notes = $newNote->getAll();
    } else {
      $notes = false;
    }

    require_once 'views/layout/main/main.php';
  }

  // esta deberia ser una ruta protegida
  public function viewFormNote()
  {
    if (isset($_SESSION['user']['user_id'])) {
      Category::initializeDb();
      $categories =  Category::getAllCategories();
      // este metodo renderizara una vista para crear una nota
      require_once 'views/formCreateNote/formCreateNote.php';
    } else {
      // header('Location:' . base_url . '?controller=notes&action=getAllNotes');
      header('Location:' . base_url);
    }
  }

  // esta deberia ser una ruta protegida
  public function createOneNote()
  {
    // detectar las variables que llegan por post
    if (isset($_POST) && !empty($_POST) && isset($_SESSION['user']['user_id'])) {
      // comprobar que todas esten presentes
      $title = isset($_POST['title']) ? $_POST['title'] : null;
      $description = isset($_POST['description']) ? $_POST['description'] : null;
      $date_at = isset($_POST['date_at']) ? $_POST['date_at'] : null;

      $category = isset($_POST['category']) ? $_POST['category'] : null;
      echo "<br/>";

      if (!$title || !$description || !$date_at  || !$category) {
        $_SESSION['error_note'] = "todos los campos son requeridos";
        isset($_GET['id'])
          ? header("Location:" . base_url . "?controller=notes&action=editOneNote&id=" . $_GET['id'])
          : header("Location:" . base_url . "?controller=notes&action=viewFormNote");
      } else {
        // conectarse con el modelo
        $newNote = new Note();
        // setear valores
        $newNote->setTitle($title);
        $newNote->setDescription($description);
        $newNote->setDate_at($date_at);
        $newNote->setCategory($category);
        $newNote->setUser($_SESSION['user']['user_id']);


        // primero ver si estamos en modo edicion o modo creacion
        // luego hacer una query para la accion correspondiente
        if (isset($_GET['id'])) {
          // modo edicion
          $completed = isset($_POST['completed']) ? $_POST['completed'] : false;
          $newNote->setCompleted($completed);
          $newNote->setId($_GET['id']);
          $issuccess = $newNote->editOne();
          $message = 'se edito la nota correctamente';
        } else {
          // modo creacion
          $issuccess = $newNote->create();
          $message = 'se creo la nota correctamente';
        }
        if ($issuccess) {
          $_SESSION['create_note'] = $message;
        } else {
          $_SESSION['error_note'] = 'sucedio un error al editar la nota, intenta luego';
        }
        header("Location:" . base_url . "?controller=notes&action=viewFormNote");
      }
    } else {
      // header('Location:' . base_url . '?controller=notes&action=getAllNotes');
      header('Location:' . base_url);
    }
  }

  // esta deberia ser una ruta protegida
  public function editOneNote()
  {
    if (isset($_GET['id']) && isset($_SESSION['user']['user_id'])) {
      Category::initializeDb();
      $categories =  Category::getAllCategories();
      $id = $_GET['id']; // id de la nota
      $userId = $_SESSION['user']['user_id']; // id del usuario
      $edit = true;
      $newNote = new Note();
      $newNote->setId($id);
      $newNote->setUser($userId);
      $noteFound = $newNote->getOne();
      /*  var_export($noteFound); */
      require_once 'views/formCreateNote/formCreateNote.php';
    } else {
      // header('Location:' . base_url . '?controller=notes&action=getAllNotes');
      header('Location:' . base_url);
    }
  }

  // esta deberia ser una ruta protegida
  public function deleteOneNote()
  {
    if (isset($_GET['id']) && isset($_SESSION['user']['user_id'])) {
      $id = $_GET['id']; // id de la nota
      $userId = $_SESSION['user']['user_id']; // id del usuario
      $note = new Note();
      $note->setId($id);
      $note->setUser($userId);
      $result = $note->deleteOne();
      if ($result) {
        $_SESSION['delete_state'] = 'success';
      } else {
        $_SESSION['delete_state'] = 'error';
      }

      // header("Location:" . base_url . "?controller=notes&action=getAllNotes");
    } /* else {
      header('Location:' . base_url . '?controller=notes&action=getAllNotes');
    } */
    header("Location:" . base_url);
  }
}
