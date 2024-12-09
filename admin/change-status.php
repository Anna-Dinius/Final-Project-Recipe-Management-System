<?php
session_start();

if (!isset($_SESSION['admin'])) {
  alert();
  die('You do not have permission to access this page');
} else {
  include_once('../utils/functions.php');

  if (isset($_GET['user_ID'])) {
    require_once('../db.php');

    $id = $_GET['user_ID'];
    $is_admin = 0;

    // If changing status of someone else's account:
    if (count($_POST) > 0 && !isset($_GET['target'])) {
      $is_admin = 1;

      if (isset($_POST['status']) && $_POST['status'] == 'admin') {
        $is_admin = 0;
      }
    }

    $query = $db->prepare('UPDATE users SET is_admin=? WHERE users.user_ID=?');
    $query->execute([$is_admin, $id]);

    // If changing status of own account, redirect to index.php:
    if (isset($_GET['target']) && $_GET['target'] == 'current') {
      $one_admin = getNumAdmins($db);

      if ($one_admin) {
        echo '<script>
            alert("You are the only Admin. Promote another user to Admin status before changing your Admin status.");
            window.location.href = "../entity/index.php";
        </script>';
        die();
      } else {
        unset($_SESSION['admin']);
        header(header: 'location: ../entity/index.php');
        exit();
      }
    }

    // If changing status of someone else's account, redirect to admin.php:
    header(header: 'location: admin.php');
    exit();
  } else {
    alert();
    die('Something went wrong');
  }
}