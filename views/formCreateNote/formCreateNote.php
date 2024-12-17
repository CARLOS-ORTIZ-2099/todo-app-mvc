<?php if (isset($edit) && isset($noteFound)) : ?>
  <h3>edita tu nota</h3>

  <?php $urlMain = base_url .
    "?controller=notes&action=createOneNote&id=" . $noteFound->note_id ?>
<?php else : ?>
  <h3>crea tu nota</h3>
  <?php $urlMain = base_url . "?controller=notes&action=createOneNote" ?>
<?php endif; ?>

<?php if (isset($_SESSION['error_note'])) : ?>
  <h2 class="error"><?= $_SESSION['error_note'] ?></h2>
<?php endif; ?>

<?php if (isset($_SESSION['create_note'])) : ?>
  <h2 class="success"><?= $_SESSION['create_note'] ?></h2>
<?php endif; ?>



<?php Utils::deleteSession('error_note') ?>
<?php Utils::deleteSession('create_note') ?>



<form class="task-form" action="<?= $urlMain ?>" method="POST">
  <!-- Campo Title -->
  <div class="task-group">
    <label class="task-label" for="title">Title:</label>
    <input
      class="task-input"
      value="<?= isset($noteFound) ? $noteFound->title : '' ?>"
      type="text"
      id="title"
      name="title"
      placeholder="Enter title" />
  </div>

  <!-- Campo Description -->
  <div class="task-group">
    <label class="task-label" for="description">Description:</label>
    <textarea
      class="task-textarea"
      id="description"
      name="description"
      rows="4"
      placeholder="Enter description"><?= isset($noteFound) ? $noteFound->description : '' ?></textarea>
  </div>

  <!-- Campo Date_at -->
  <div class="task-group">
    <label class="task-label" for="date_at">Date:</label>
    <input
      class="task-input"
      value="<?= isset($noteFound) ? $noteFound->date_at : '' ?>"
      type="date"
      id="date_at"
      name="date_at" />
  </div>

  <!-- Campo Completed -->
  <?php if (isset($_GET['id']) && isset($noteFound)): ?>
    <div class="task-group">
      <label class="task-label" for="completed">Completed:</label>
      <select class="task-select" id="completed" name="completed">
        <option value=<?= false ?>>--</option>
        <option
          <?= isset($noteFound) && $noteFound->completed == '1' ? 'selected' : '' ?>
          value=<?= true ?>>Yes</option>
        <option
          <?= isset($noteFound) && $noteFound->completed == '0' ? 'selected' : '' ?>
          value=<?= false ?>>No</option>
      </select>
    </div>
  <?php endif; ?>

  <!-- Campo Category -->
  <div class="task-group">
    <label class="task-label" for="category">Category:</label>
    <select class="task-select" name="category" id="category">
      <?php while ($row = $categories->fetch_assoc()) : ?>
        <option
          <?= isset($noteFound) && $row['category_id'] == $noteFound->category ? 'selected' : '' ?>
          value=<?= $row['category_id'] ?>>
          <?= $row['name'] ?>
        </option>
      <?php endwhile; ?>
    </select>
  </div>

  <!-- Botón de envío -->
  <div class="task-group">
    <button class="task-button" type="submit">Submit</button>
  </div>
</form>



</div>