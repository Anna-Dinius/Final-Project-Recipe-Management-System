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
        $query = $db->prepare('SELECT name,is_admin FROM users WHERE email=? AND password=?');
        $query->execute([$_POST['email'], $_POST['password']]);

        if ($query) {
            $user = $query->fetch();

            session_start();
            $_SESSION['signedIn'] = TRUE;
            $_SESSION['name'] = $user['name'];

            if ($user['is_admin'] == 1) {
                $_SESSION['admin'] = TRUE;
            }

            header('location:../index.php');
            exit();
        }

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