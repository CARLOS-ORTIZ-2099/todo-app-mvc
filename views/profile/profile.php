  <?php if (isset($_SESSION['edit_profile'])): ?>
    <h2 class="<?= $_SESSION['edit_profile']['status'] ?>"><?= $_SESSION['edit_profile']['message'] ?></h2>
    <?php Utils::deleteSession('edit_profile'); ?>
  <?php endif; ?>



  <div>
    <h2>my profile</h2>
    <h2>name : <?= $user['name'] ?></h2>
    <h2>lastname : <?= $user['lastname'] ?></h2>
    <p>email : <?= $user['email'] ?></p>
    <p>bio : <?= isset($user['bio']) ? $user['bio'] : 'sin bio' ?></p>
    <div class="avatar-container">
      <img
        class="avatar"
        src="<?= isset($user['avatar']) ? base_url . 'uploads/' . $user['avatar'] : base_url . 'assets/img/default.svg' ?>"
        alt="avatar">
    </div>

    <a class="form-submit" href="<?= base_url . '?controller=user&action=showFormEdit' ?>">editar perfil</a>
  </div>

  </div>