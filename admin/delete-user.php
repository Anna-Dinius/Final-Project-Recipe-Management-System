<?php
session_start();

require_once('../db.php');

if (count($_POST) > 0) {
  if (isset($_POST['user_ID'])) {
    $query = $db->prepare('DELETE FROM users WHERE user_ID=?');
    $query->execute([$_POST['user_ID']]);
  }
}

header('location: admin.php');
die();