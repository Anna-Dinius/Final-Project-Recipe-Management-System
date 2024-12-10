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
  $userid = $_SESSION['user_ID'];

  $recipes = fetchRecipes($db);
  $recipe = getRecipe($recipes, $id);

  $title = 'Add a Recipe';

  if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $db->beginTransaction();
    $sql = 'INSERT INTO favorites (user_ID, recipe_ID) VALUES (:userID, :recipeID)';
    $stmt = $db->prepare($sql);
    $params = [
        ':userID' => $userid,
        ':recipeID' => $id
      ];
    $stmt->execute($params);
    $db->commit();

    header("Location: ../favorites/index.php");
    exit;
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

          <h2>Are you sure you want to add the <?= $recipe['name']; ?> recipe to your favorites?</h2>

          <div class="d-flex btns" id="btn-box-<?= $recipe['id'] ?>">
            <form method="POST" action="add-favorite.php?recipe_id=<?= $recipe['id'] ?>">
              <a href="index.php" class="btn btn-secondary update-btn">Cancel</a>
              <button type="submit" class="btn btn-secondary update-btn">Add</button>
            </form>
          </div>
        </div>
      </div>
    </main>
  </body>

  </html>

<?php } ?>
