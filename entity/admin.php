<?php

require_once("../utils/functions.php");
include_once('../db.php');

$title = "Manage Users";
$query = $db->query('SELECT user_ID,name,is_admin FROM users');

if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
  $user_ID = $_GET['user_ID'];

  // $delete = $db->prepare('DELETE FROM users WHERE user_ID=?');
  // $delete->execute($user_ID);

  echo "<script>alert('$user_ID');</script>";
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
    <h1>Manage Users</h1>

    <div>
      <?php if (!(isset($_GET['action']) && $_GET['action'] == "create")) { ?>
        <a href="admin.php?action=create" class="btn btn-primary admin-create-user-btn create-btn">Create a User</a>

      <?php } else { ?>
        <form class="admin-create-user-form" method="POST" action="admin.php">
          <h2>Create a User</h2>
          <?php getSignUpForm() ?>

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

      <form method="DELETE">
        <button class="btn btn-danger">Delete All Users</button>
      </form>
    </div>
  </main>
</body>

</html>