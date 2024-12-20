<?php
include_once('../utils/functions.php');
include_once('../utils/SQLfunctions.php');
require_once('../db.php');

session_start();

if (!isset($_SESSION['signedIn'])) {
  alert();
  die('You do not have permission to access this page');
} else {

  $id = $_GET['recipe_id'];
  $recipes = fetchRecipes($db);
  $recipe = getRecipe($recipes,$id);

  $title = 'Delete a Recipe';

  if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    deleteOldRecipe($db, $id));

    header("Location: ../entity/index.php");
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
      <div class="container">
        <div class="row">
          <div id="btns">
            <a href="index.php" class="btn btn-secondary update-btn">
              <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-arrow-left"
                viewBox="0 0 16 16">
                <path fill-rule="evenodd"
                  d="M15 8a.5.5 0 0 0-.5-.5H2.707l3.147-3.146a.5.5 0 1 0-.708-.708l-4 4a.5.5 0 0 0 0 .708l4 4a.5.5 0 0 0 .708-.708L2.707 8.5H14.5A.5.5 0 0 0 15 8" />
              </svg>
              Back to Index
            </a>
            <br><br><br>
          </div>

          <h2>Are you sure you want to delete the <?= $recipe['name']; ?> recipe?</h2>
          <p>This action cannot be undone.</p>

          <div class="d-flex btns" id="btn-box-<?= $recipe['id'] ?>">
            <form method="POST" action="delete.php?recipe_id=<?= $_GET['recipe_id'] ?>">
              <a href="index.php" class="btn btn-secondary update-btn">Cancel</a>
              <button type="submit" class="btn btn-danger btn-delete">Delete</button>
            </form>
          </div>
        </div>
      </div>
    </main>
  </body>

  </html>

<?php } ?>
