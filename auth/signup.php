<?php
include_once('../utils/functions.php');
include_once('../db.php');

$title = 'Sign Up';

if (count($_POST) > 0) {
  //Grab data from $_POST.
  $firstname = trim($_POST['firstName']);
  $lastname = trim($_POST['lastName']);
  $fullname = $firstname . ' ' . $lastname;
  $email = trim($_POST['email']);
  $password = trim($_POST['password']);
  $is_admin = 0;

  // Add data to db if email isn't already being used.
  if (validateEmail($_POST['email']) && !checkEmailExists($_POST['email'], $db)) {
    $add_user = $db->prepare(query: "INSERT INTO users(name, email, password, is_admin) VALUES(:name, :email, :password, :is_admin)");
    $add_user->execute([
      ':name' => $fullname,
      ':email' => $email,
      ':password' => $password,
      ':is_admin' => $is_admin
    ]);

    $user = [
      'name' => $fullname,
      'is_admin' => $isadmin
    ];
    startSession($user);

    // Redirect user to sign in page.
    header('location: ../entity/index.html');
    die();
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

  <main>
    <div class="d-flex ms-3">
      <div class="h-100 d-flex align-items-center justify-content-center signInUp">
        <h2>Sign Up</h2>

        <form class="position-absolute top-50 start-50 translate-middle card" method="POST">
          <?php getSignUpForm($_POST, $db) ?>

          <button id="signup" type="submit" class="btn btn-primary">
            Sign up
          </button>
          <br><br>

          <div>
            Already have an account?
            <a href="signin.php">Sign in here</a>
          </div>
        </form>
      </div>
    </div>
  </main>
</body>

</html>