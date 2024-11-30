<?php
session_start();

require_once('../db.php');
$query = $db->query('DELETE FROM users WHERE is_admin=0');
header('location: admin.php');
die();