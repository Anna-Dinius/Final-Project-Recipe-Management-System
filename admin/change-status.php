<?php
session_start();

if (count($_POST) > 0 && isset($_GET['user_ID'])) {
  require_once('../db.php');

  $id = $_GET['user_ID'];
  $is_admin = 0;

  if (isset($_POST['status']) && $_POST['status'] == 'admin') {
    $is_admin = 1;
  }

  $query = $db->prepare('UPDATE users SET is_admin=? WHERE user_ID=?');
  $query->execute([$is_admin, $id]);

  header(header: 'location: admin.php');
}
