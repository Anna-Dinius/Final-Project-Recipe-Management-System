<?php
include_once('../utils/functions.php');

$title = 'Sign Up';

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
  <?php
  
    if(count($_POST) > 0){
      echo '<pre>';
      print_r($_POST);

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
      while($emailNotAdded){
        $csvLine = fgetcsv($fp);
        if($csvLine == FALSE){
          break;
        }
        if ($csvLine[2] == $email){
          $emailNotAdded = FALSE;
        }
      }
      //If the flag did not go off, that means the email is not in use thus the account can be added.
      if ($emailNotAdded){
        fputcsv($fp, $data);
        fclose($fp);
        header('location:signin.php'); //Redirects user to sign in where the session start is.
        exit();
      }else{
        fclose($fp);
        header('location:signup.php'); //Redirects user to sign in where the session start is.
      }
      fclose($fp);


    }else{
  ?>
  <main>
    <div class="d-flex ms-3">
      <div class="h-100 d-flex align-items-center justify-content-center signInUp">
        <h2>Sign Up</h2>
        <form class="position-absolute top-50 start-50 translate-middle card" method="POST" action="signup.php">
          <div class="form-group m-3">
            <label for="First Name">First Name</label><span class="required">*</span>
            <input type="text" class="form-control" id="firstName" aria-describedby="firstNameHelp" name="firstName" required
              placeholder="Enter First Name" />
          </div>

          <div class="form-group m-3">
            <label for="Last Name">Last Name</label><span class="required">*</span>
            <input type="text" class="form-control" id="lastName" aria-describedby="lastNameHelp" name="lastName" required
              placeholder="Enter Last Name" />
          </div>

          <div class="form-group m-3">
            <label for="email">Email address</label><span class="required">*</span>
            <input type="email" class="form-control" id="email" aria-describedby="emailHelp" name="email" required
              placeholder="Enter email" />
          </div>

          <div class="form-group m-3">
            <label for="password">Password</label><span class="required">*</span>
            <input type="password" class="form-control" id="password" placeholder="Password" name="password" required/>
          </div>

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
  <?php } ?>
</body>

</html>