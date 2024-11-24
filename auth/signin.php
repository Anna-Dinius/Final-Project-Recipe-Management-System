<?php
include_once('../utils/functions.php');
include_once('../db.php');

$title = 'Sign In';

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
    if (count($_POST) > 0) {
        //Opens file
        $file = '../data/users.csv';
        $fp = fopen($file, 'r');
        //Checks for correct log in information.
        while (($data = fgetcsv($fp)) !== FALSE) {
            if ($_POST['email'] == $data[2] && $_POST['password'] == $data[3]) {
                $fp = fclose($fp);
                session_start();
                $_SESSION['signedIn'] = TRUE;
                $_SESSION['name'] = $data[0] . ' ' . $data[1];

                $query = $db->prepare('SELECT is_admin FROM users WHERE email=? AND password=?');
                $query = $query->execute([$data[2], $data[3]]);

                // $is_admin = $query->fetch(); // doesn't work
    
                if ($is_admin == 1) {
                    $_SESSION['admin'] = TRUE;
                }

                die($is_admin . ' ' . $data[2] . ' ' . $data[3]); // for debugging
    
                header('location:../index.php'); //Once signed in, a session is started.
                exit();
            }
        }
        $fp = fclose($fp);
        header('location:signin.php');
        exit();
    } else {
        ?>
        <main>
            <div class="d-flex ms-3">
                <div class="h-100 d-flex align-items-center justify-content-center signInUp">
                    <h2>Sign In</h2>
                    <form class="position-absolute top-50 start-50 translate-middle card" method="POST" action="signin.php">
                        <div class="form-group m-3">
                            <label for="email">Email address</label>
                            <input type="email" class="form-control" id="email" aria-describedby="emailHelp" name="email"
                                required placeholder="Enter email" />
                        </div>
                        <div class="form-group m-3">
                            <label for="password">Password</label>
                            <input type="password" class="form-control" id="password" placeholder="Password" name="password"
                                required />
                        </div>
                        <button id="signin" type="submit" class="btn btn-primary">
                            Sign In
                        </button>
                        <br><br>
                        <div>
                            Don't have an account?
                            <a href="signup.php">Sign up here</a>
                        </div>
                    </form>
                </div>
            </div>
        </main>
        <?php
    }
    ?>
</body>

</html>