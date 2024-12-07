<?php
session_start();

if (!isset($_SESSION['admin'])) {
  alert();
  die('You do not have permission to access this page');
} else {
  if (count($_POST) > 0 && isset($_GET['user_ID'])) {
    require_once('../db.php');

    $id = $_GET['user_ID'];
    $is_admin = 1;

    if (isset($_POST['status']) && $_POST['status'] == 'admin') {
      $is_admin = 0;
    }

    $query = $db->prepare('UPDATE users SET is_admin=? WHERE users.user_ID=?');
    $query->execute([$is_admin, $id]);

    header(header: 'location: admin.php');
  }

  alert();
  die('Something went wrong');
}