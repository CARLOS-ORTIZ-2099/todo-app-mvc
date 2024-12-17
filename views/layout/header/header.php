<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Document</title>
  <link rel="stylesheet" href="<?= base_url ?>assets/css/styles.css" />
</head>

<body>

  <header class="header-container">

    <div class="logo-container">
      <span>
        <img class="logo" src="<?= base_url ?>assets/img/logo.svg" alt="imagen-logo">
      </span>
    </div>

    <nav class="enlaces-container">
      <ul>
        <li>
          <!-- Las rutas relativas como ../../home.php funcionan en el front-end porque el navegador interpreta la estructura local -->

          <!-- Sin embargo, al usar un servidor, es mejor definir rutas absolutas dinámicas para que funcionen en cualquier entorno -->

          <!-- <a
            href="../../home.php">home
          </a> -->
          <a href="<?= base_url ?>">
            home
          </a>
        </li>

        <?php if (isset($_SESSION['user'])): ?>
          <li>
            <a href="<?= base_url ?>?controller=notes&action=viewFormNote">new task</a>
          </li>

          <li>
            <a href="<?= base_url ?>?controller=user&action=viewProfile">view profile</a>
          </li>
        <?php else : ?>

          <li>
            <a href="<?= base_url ?>?controller=user&action=viewRegister">registrate o logueate para ver tus notas</a>
          </li>

        <?php endif; ?>

      </ul>
    </nav>

  </header>


  <div class="data-container">


</html>