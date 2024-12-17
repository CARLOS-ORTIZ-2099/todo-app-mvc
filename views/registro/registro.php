<div>

  <?php if (isset($_SESSION['user']) && isset($editProfile) && is_array($userFound)) : ?>
    <h2>edita tu perfil</h2>
    <?php $urlMain = base_url . "?controller=user&action=register&id=" . $userFound['user_id'] ?>
  <?php else : ?>
    <h2>registrate</h2>
    <?php $urlMain = base_url . "?controller=user&action=register" ?>
  <?php endif; ?>

  <?php if (isset($_SESSION['register'])): ?>
    <h2 class="<?= $_SESSION['register']['status'] ?>"><?= $_SESSION['register']['message'] ?></h2>
  <?php endif; ?>

  <?php Utils::deleteSession('register'); ?>

  <form
    class="form"
    novalidate
    action=<?= $urlMain ?>
    method="POST"
    enctype="multipart/form-data">
    <div class="form-group">
      <label class="form-label" for="name">Name</label>
      <input
        value="<?= isset($userFound) ? $userFound['name'] : '' ?>"
        class="form-input"
        type="text"
        placeholder="Name"
        id="name"
        name="name" />
    </div>

    <div class="form-group">
      <label class="form-label" for="lastname">Lastname</label>
      <input
        value="<?= isset($userFound) ? $userFound['lastname'] : '' ?>"
        class="form-input"
        type="text"
        placeholder="Lastname"
        id="lastname"
        name="lastname" />
    </div>

    <div class="form-group">
      <label class="form-label" for="email">Email</label>
      <input
        value="<?= isset($userFound) ? $userFound['email'] : '' ?>"
        class="form-input"
        type="email"
        placeholder="Email"
        id="email"
        name="email" />
    </div>

    <div class="form-group">
      <label class="form-label" for="password">Password</label>
      <input
        class="form-input"
        type="password"
        placeholder="Password"
        id="password"
        name="password" />
    </div>


    <?php if (isset($userFound)) : ?>
      <label for="bio">bio</label>
      <textarea name="bio" id="bio"><?= $userFound['bio'] ? $userFound['bio'] : '' ?></textarea>

      <div class="avatar-container">
        <img
          class="avatar"
          src="<?= isset($userFound['avatar']) ? base_url . 'uploads/' . $userFound['avatar'] : base_url . 'assets/img/default.svg' ?>"
          alt="avatar">
      </div>


      <input type="file" name="avatar">


    <?php endif; ?>


    <div class="form-group">
      <input class="form-submit" type="submit" value="Send Data" />
    </div>
  </form>


  <!-- ESTE ENLACE NOS TIENE QUE LLEVAR A LA HOME DE LA APLICACION -->
  <!-- ESTE ENÑACE SOLO DEBE APARECER EN EL REGOSTRO DE USUARIO NO AL EDITAR PERFIL -->
  <?php if (!isset($_SESSION['user']) && !isset($editProfile)) : ?>
    <a class="form-link" href="<?= base_url ?>?controller=user&action=login">
      Ya tienes una cuenta? Loguéate aquí
    </a>
  <?php endif; ?>
</div>




</div>