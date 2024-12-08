<?php
include_once('../utils/functions.php');

$title = 'Sign Up';

if (count($_POST) > 0) {
  //Grab data from $_POST.
  $firstName = trim($_POST['firstName']);
  $lastName = trim($_POST['lastName']);
  $email = trim($_POST['email']);
  $password = trim($_POST['password']);

  $data = [$firstName, $lastName, $email, $password];

  //Flag
  $emailNotAdded = True;

  //Opening File in Append and read mode. Rewind the pointer to the beginning and then loop through the file to find the email.
  $f = "../data/users.csv";
  $fp = fopen($f, 'a+');
  rewind($fp);

  //Checking if email is in use
  while ($emailNotAdded) {
    $csvLine = fgetcsv($fp);
    if ($csvLine == FALSE) {
      break;
    }
    if ($csvLine[2] == $email) {
      $emailNotAdded = FALSE;
    }
  }
  //If the flag did not go off, that means the email is not in use thus the account can be added.
  if ($emailNotAdded) {
    fputcsv($fp, $data);
    fclose($fp);
    header('location:signin.php'); //Redirects user to sign in where the session start is.
    exit();
  } else {
    fclose($fp);
    header('location:signup.php'); //Redirects user to sign in where the session start is.
  }
  fclose($fp);
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
          <?php getSignUpForm($_POST) ?>

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