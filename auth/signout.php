<?php //This file unsets the signed in data and destroys the session.
session_start();

if (isset($_SESSION['signedIn'])) {
    unset($_SESSION['signedIn']);
}

session_destroy();

header('Location: ../entity/index.php');
exit();
?>