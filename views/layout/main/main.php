 <div class="main-container">

   <h1 class="title-main">home page</h1>

   <?php if (isset($_SESSION['delete_state'])) : ?>
     <h3 class="<?= $_SESSION['delete_state'] ?>"><?= $_SESSION['delete_state'] == 'success' ? 'se elimino la nota correctamente' : 'ocurrio un error al eliminar la nota' ?></h3>
   <?php endif; ?>
   <?php Utils::deleteSession('delete_state') ?>

   <div class="note-container">
     <?php if ($notes) : ?>
       <?php if ($notes->num_rows == 0): ?>
         <h2>no tienes notas aun</h2>
       <?php else : ?>
         <?php while ($row = $notes->fetch_assoc()) : ?>
           <!--  <?php
                  var_dump($row);
                  ?> -->
           <div class="note-card">
             <h3>title : <?= $row['title'] ?></h3>
             <p>description : <?= $row['description'] ?></p>
             <p> date created: <?= $row['date_at'] ?></p>
             <span class="status-<?= $row['completed'] == '1' ? 'completado' : 'pendiente' ?>">status : <?= $row['completed'] ? 'completado' : 'pendiente' ?></span>
             <strong>category : <?= $row['name_category'] ?></strong>
             <div>
               <!-- esto tiene que llevarme a un formulario de editar -->
               <a href="<?= base_url ?>?controller=notes&action=editOneNote&id=<?= $row['note_id'] ?>">edit note</a>
               <a href="<?= base_url ?>?controller=notes&action=deleteOneNote&id=<?= $row['note_id'] ?>">delete note</a>
             </div>
           </div>

         <?php endwhile; ?>
       <?php endif; ?>
     <?php else : ?>
       <h2>para ver las notas logueate antes</h2>
     <?php endif; ?>
   </div>
 </div>

 </div>