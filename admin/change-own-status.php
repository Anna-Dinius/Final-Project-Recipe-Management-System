<?php
session_start();

if (!isset($_SESSION['admin'])) {
  alert();
  die('You do not have permission to access this page');
} else {
  include_once('../utils/functions.php');

  $title = 'Change Admin Status';

  // if (count($_POST) > 0 && isset($_SESSION['user_id']) && isset($_POST['confirm'])) {
  //   require_once('../db.php');

  //   header('location: change-status.php?user_ID=' . $_SESSION["user_id"] . '&target=current');
  //   exit();
  // }
  ?>

  <!doctype html>
  <html lang="en">

  <head>
    <?= getHead($title); ?>
  </head>

  <body>
    <nav class="navbar navbar-expand-lg navbar-light mb-2 turqoise">
      <?= getNav(); ?>
    </nav>

    <main>
      <div class="container delete-all-container">
        <div class="row">
          <div id="btns">
            <a href="../entity/index.php" class="btn btn-secondary update-btn">
              <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-arrow-left"
                viewBox="0 0 16 16">
                <path fill-rule="evenodd"
                  d="M15 8a.5.5 0 0 0-.5-.5H2.707l3.147-3.146a.5.5 0 1 0-.708-.708l-4 4a.5.5 0 0 0 0 .708l4 4a.5.5 0 0 0 .708-.708L2.707 8.5H14.5A.5.5 0 0 0 15 8" />
              </svg>
              Back to Index
            </a>
            <br><br><br>
          </div>

          <h2>Are you sure you want to remove the Admin status of your account?</h2>
          <p>This action will take effect immediately.</p>

          <div class="d-flex btns">
            <form method="POST" action="change-status.php?user_ID=<?= $_SESSION['user_id'] ?>&target=current"
              class="delete-all-form">
              <a href="admin.php" class="btn btn-secondary">Cancel</a>
              <button type="submit" name="confirm" class="btn btn-danger btn-delete">Remove Admin Status</button>
            </form>
          </div>
        </div>
      </div>
    </main>
  </body>

  </html>
  <?php
}