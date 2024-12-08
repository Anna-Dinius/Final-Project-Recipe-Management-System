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
  $user_added = false;
  $showForm = false;

  $num_users = $db->prepare('SELECT COUNT(*) AS num_users FROM users WHERE is_admin=?');
  $num_users->execute([0]);
  $num_users = $num_users->fetch();

  if (count($_POST) > 0) {
    if (isset($_POST['show-form'])) {
      $showForm = true;
    } else {
      $showForm = false;
    }
  }

  if (count($_POST) > 0 && isset($_POST['add-user'])) {
    //Grab data from $_POST.
    $name = $_POST['firstName'] . " " . $_POST['lastName'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $is_admin = 0;

    if ($_POST['status'] == "admin") {
      $is_admin = 1;
    }

    $valid_email = validateEmail($_POST['email']);
    $valid_password = validatePassword($_POST['password']);

    // Add data to db if email isn't already being used.
    if ($valid_email && $valid_password && !checkEmailExists($_POST['email'], $db)) {
      $add_user = $db->prepare('INSERT INTO users(name,email,password,is_admin) VALUES(?,?,?,?)');
      $add_user->execute([$name, $email, $password, $is_admin]);

      $user_added = true;
      header('location: admin.php');
    }
  }
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
        <?php if (!$showForm) { ?>
          <form method="POST">
            <button type="submit" name="show-form" class="btn btn-primary admin-create-user-btn create-btn">Create a
              User</button>
          </form>
          <!-- Displays Create form if Create btn is not visible -->
        <?php } else { ?>
          <form class="admin-create-user-form" method="POST">
            <h2>Create a User</h2>
            <?php getSignUpForm($_POST, $db) ?>

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

              <button type="submit" name="add-user" class="btn btn-primary admin-create-user-btn create-btn">
                Add User
              </button>
            </div>
          </form>
        <?php } ?>

        <h2 class="user-list">User List</h2>

        <div>
          <?= $user_added ? 'User added successfully.' : '' ?>
        </div>

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