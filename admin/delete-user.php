<?php
session_start();

require_once('../db.php');

$query = $db->prepare('DELETE FROM users WHERE user_ID=?');
if (count($_GET) > 0) {
  if (isset($_GET['user_ID'])) {
    $query->execute([$_GET['user_ID']]);
  }
}

header('location: admin.php');
// die();