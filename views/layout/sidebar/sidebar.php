<aside class="sidebar">
  <div>
    <!-- aqui solo mostrar el menu de registro si tenemos una session
           activa del usuario -->
    <?php if (isset($_SESSION['user'])) :   ?>

      <h2 class="message-welcome">
        welcome
        <?=
        $_SESSION['user']['name'] . " " . $_SESSION['user']['lastname'] ?>
      </h2>

      <a class="btn-close-session" href="<?= base_url ?>?controller=user&action=logout">cerrar session</a>

    <?php else : ?>


      <!-- AQUI TIENE QUE IR EL FORMULARIO DE LOGIN -->
      <section class="login-container">
        <?php if (isset($_SESSION['error_login'])) : ?>
          <h2 class="error"><?= $_SESSION['error_login'] ?></h2>
        <?php endif; ?>

        <?php Utils::deleteSession('error_login')  ?>

        <h2 class="login-title">Loguéate</h2>
        <form
          class="login-form"
          action="<?= base_url ?>?controller=user&action=login"
          method="POST">
          <div class="login-group">
            <label class="login-label" for="email">Email</label>
            <input
              class="login-input"
              type="email"
              placeholder="Email"
              id="email"
              name="email" />
          </div>

          <div class="login-group">
            <label class="login-label" for="password">Password</label>
            <input
              class="login-input"
              type="password"
              placeholder="Password"
              id="password"
              name="password" />
          </div>

          <div class="login-group">
            <input class="login-submit" type="submit" value="Enviar Datos" />
          </div>
        </form>

        <!-- ESTE ENLACE NOS TIENE QUE LLEVAR A RENDERIZAR EL FORMULARIO DE REGISTRO -->
        <a class="login-link" href="<?= base_url ?>?controller=user&action=viewRegister">
          ¿No tienes cuenta? Regístrate aquí
        </a>

      </section>


    <?php endif; ?>
  </div>
</aside>