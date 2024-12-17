<?php
require_once 'database/Db.php';
class  Note
{
  // definicion de propiedades y su tipado
  private $id;
  private $title;
  private $description;
  private $date_at;
  private $completed;
  private $category;
  private $user;
  private $db;

  public function __construct()
  {
    $this->db = Database::connect();
  }

  // geters
  public function getId()
  {
    return $this->id;
  }
  public function getTitle()
  {
    return $this->title;
  }
  public function getDescription()
  {
    return $this->description;
  }
  public function getDate_at()
  {
    return $this->date_at;
  }
  public function getCompleted()
  {
    return $this->completed;
  }
  public function getCategory()
  {
    return $this->category;
  }
  public function getUser()
  {
    return $this->user;
  }
  // seters

  public function setId($id)
  {
    $this->id = $id;
  }
  public function setTitle($title)
  {
    $this->title = $this->db->real_escape_string($title);
  }
  public function setDescription($description)
  {
    $this->description = $this->db->real_escape_string($description);
  }
  public function setDate_at($date_at)
  {
    $this->date_at = $date_at;
  }
  public function setCompleted($completed)
  {
    $this->completed = $completed;
  }
  public function setCategory($category)
  {
    $this->category = $category;
  }
  public function setUser($user)
  {
    $this->user = $user;
  }


  // consultas a la db

  // metodo que crea una nota
  public function create() {
    $query = "INSERT INTO notes (title, description, date_at, completed, category, user)
    VALUES ('{$this->title}', '{$this->description}', '{$this->date_at}', '{$this->completed}',
    '{$this->category}', '{$this->user}');";
    $result =  $this->db->query($query);
    // si todo sale bien
    if($result) {
      return true ; 
    }
    return false ; 

  }

  // traer todas las notas del usuario autenticado
  public function getAll() {
    $query = "SELECT notes.*, categories.name AS name_category FROM notes  INNER JOIN categories 
    ON notes.category = categories.category_id WHERE notes.user = $this->user;";
    $notes = $this->db->query($query);
    return $notes;
  }

  // buscar una nota en especifico siempre y cuando el dueño sea el usuario autenticado
  public function getOne() {
    $query = "SELECT * FROM notes WHERE user = '{$this->user}' AND note_id = '{$this->id}';";
    $note =  $this->db->query($query);
    return $note->fetch_object();
  }

  public function editOne() {
    $query = "UPDATE notes SET title = '{$this->title}', description = '{$this->description}', date_at = '{$this->date_at}', completed = '{$this->completed}', category = '{$this->category}' WHERE note_id = '{$this->id}' AND user = '{$this->user}';";
    $result = $this->db->query($query);
    if($result){
      return true ; 
    }
    return false ; 
  } 

  
 
  public function deleteOne() {
    $query = "DELETE FROM notes WHERE note_id = '{$this->id}' AND user = '{$this->user}';";
    
    $result = $this->db->query($query);
    if($result){
      return true ; 
    }
    return false ; 
  }
  
}
