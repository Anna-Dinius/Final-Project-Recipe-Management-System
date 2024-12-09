<?php
session_start();

if (!isset($_SESSION['signedIn'])) {
    alert();
    die('You do not have permission to access this page');
} else {
    include_once('../utils/functions.php');
    include_once('../db.php');

    $title = 'Delete Account';
    $one_admin = getNumAdmins($db);

    if (count($_POST) > 0 && !$one_admin) {
        $email = $_SESSION['email'];

        $query = $db->prepare('DELETE FROM users WHERE email=?');
        $query->execute([$email]);

        header('location: signout.php');
        exit();
    } elseif ($one_admin) {
        echo '<script>
            alert("You are the only Admin. Promote another user to Admin status before deleting your account.");
            window.location.href = "../entity/index.php";
        </script>';
        die();
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
            <div class="container delete-all-container">
                <div class="row">
                    <div id="btns">
                        <a href="../entity/index.php" class="btn btn-secondary update-btn">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor"
                                class="bi bi-arrow-left" viewBox="0 0 16 16">
                                <path fill-rule="evenodd"
                                    d="M15 8a.5.5 0 0 0-.5-.5H2.707l3.147-3.146a.5.5 0 1 0-.708-.708l-4 4a.5.5 0 0 0 0 .708l4 4a.5.5 0 0 0 .708-.708L2.707 8.5H14.5A.5.5 0 0 0 15 8" />
                            </svg>
                            Back to Index
                        </a>
                        <br><br><br>
                    </div>

                    <h2>Are you sure you want to delete your account?</h2>
                    <p>This action cannot be undone.</p>
                    <p>You will automatically be signed out.</p>

                    <div class="d-flex btns">
                        <form method="POST" class="delete-all-form">
                            <a href="../entity/index.php" class="btn btn-secondary">Cancel</a>
                            <button type="submit" name="delete" class="btn btn-danger btn-delete">Delete</button>
                        </form>
                    </div>
                </div>
            </div>
        </main>
    </body>

    </html>
<?php } ?>