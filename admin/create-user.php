<?php

session_start();
include_once('../db.php');

if (count($_POST) > 0) {
  $name = $_POST['firstName'] . " " . $_POST['lastName'];
  $email = $_POST['email'];
  $password = $_POST['password'];
  $is_admin = 0;

  if ($_POST['status'] == "admin") {
    $is_admin = 1;
  }

  $add_user = $db->prepare('INSERT INTO users(name,email,password,is_admin) VALUES(?,?,?,?)');
  $add_user->execute([$name, $email, $password, $is_admin]);

  header("location: admin.php");
}
