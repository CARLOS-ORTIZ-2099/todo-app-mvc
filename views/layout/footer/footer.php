 <footer>
   hecho por <a href="#">
     <?= isset($_SESSION['user']) ? $_SESSION['user']['name'] . " " . $_SESSION['user']['lastname'] : 'user unknown' ?>
   </a> &copy; 2024
   <small>Todos los derechos reservados</small>
 </footer>


 </body>

 </html>