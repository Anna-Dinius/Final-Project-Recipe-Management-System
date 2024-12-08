<?php
session_start();
require_once("../utils/functions.php");

if (!isset($_SESSION['admin'])) {
  alert();
  die('You do not have permission to access this page');
} else {

  include_once('../db.php');

  $title = "Manage Users";
  $query = $db->query('SELECT user_ID,name,email,is_admin FROM users');

  $num_users = $db->prepare('SELECT COUNT(*) AS num_users FROM users WHERE is_admin=?');
  $num_users->execute([0]);
  $num_users = $num_users->fetch();

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

    <main class="admin">
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

      <h1>Manage Users</h1>

      <div>
        <!-- Displays Create btn if Create form is not visible -->
        <?php if (!(isset($_GET['action']) && $_GET['action'] == "create")) { ?>
          <a href="admin.php?action=create" class="btn btn-primary admin-create-user-btn create-btn">Create a User</a>

        <?php } else { ?>
          <form class="admin-create-user-form" method="POST" action="create-user.php">
            <h2>Create a User</h2>
            <?php getSignUpForm($_POST) ?>

            <div class="form-group m-3">
              <label for="Status">Status</label><span class="required">*</span>
              <br />

              <label>
                <input type="radio" name="status" value="user" required />
                User
              </label>
              <br />

              <label>
                <input type="radio" name="status" value="admin" required />
                Admin
              </label>
            </div>

            <div class="buttons">
              <a href="admin.php" class="btn btn-secondary">
                Cancel
              </a>

              <button class="btn btn-primary admin-create-user-btn create-btn">
                Add User
              </button>
            </div>
          </form>
        <?php } ?>

        <h2 class="user-list">User List</h2>

        <div class="table-container">
          <table class="admin-table">
            <thead>
              <tr>
                <th class="name">Name</th>
                <th class="email">Email</th>
                <th class="status">Status</th>
                <th></th>
                <th></th>
              </tr>
            </thead>

            <tbody>
              <?php
              if ($query) {
                $users = $query->fetchAll();
                displayUserRows($users);
              }
              ?>
            </tbody>
          </table>
        </div>

        <?php if ($num_users['num_users'] > 0) { ?>
          <form method="POST" action="delete-all.php?target=user">
            <button class="btn btn-danger">Delete All Users</button>
          </form>
        <?php } ?>
      </div>
    </main>
  </body>

  </html>

<?php } ?>