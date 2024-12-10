<?php
include_once('../utils/functions.php');
require_once('../db.php');

session_start();

if (!isset($_SESSION['signedIn'])) {
  alert();
  die('You do not have permission to access this page');
} else {

  $action = 'create';
  $recipe = null;

  $title = 'Create a Recipe';

  $author = $_SESSION['name'];

  if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $category = $_POST['category'];

    $imagePath = '../img/' . basename($_FILES['image']['name']);
    move_uploaded_file($_FILES['image']['tmp_name'], $imagePath);
    $image = $imagePath;

    $prep_time_hours = (int) $_POST['prep_time_hours'];
    $prep_time_minutes = (int) $_POST['prep_time_minutes'];
    $cook_time_hours = (int) $_POST['cook_time_hours'];
    $cook_time_minutes = (int) $_POST['cook_time_minutes'];
    $servings = (int) $_POST['servings'];
    $ingredients = $_POST['ingredients'];
    $steps = $_POST['steps'];
    try {
      $db->beginTransaction();

      //grab user ID
      $sql = "SELECT user_ID FROM users WHERE name = :name";
      $stmt = $db->prepare($sql);
      $params = [':name' => $author];
      $stmt->execute($params);
      $user = $stmt->fetch();
      $userID = $user['user_ID'];

      //grab category ID
      $sql = "SELECT category_ID FROM category WHERE category_name = :category_name";
      $stmt = $db->prepare($sql);
      $params = [':category_name' => $category];
      $stmt->execute($params);
      $categoryRow = $stmt->fetch();
      $categoryID = $categoryRow['category_ID'];

      //Recipes Insert Statement
      //$value means that I haven't gotten their value yet.

      $prep_time_total = $prep_time_minutes + $prep_time_hours * 60;
      $cook_time_total = $cook_time_minutes + $cook_time_hours * 60;
      $sql = "INSERT INTO recipes (user_ID, recipe_name, category_ID, prep_time_minutes, cook_time_minutes, servings, image, view_count) VALUES (:userID, :recipe_name, :category_ID, :prep_time_minutes, :cook_time_minutes, :servings, :image, :view_count)";
      $stmt = $db->prepare($sql);
      $params = [
        ':userID' => $userID,
        ':recipe_name' => $name,
        ':category_ID' => $categoryID,
        ':prep_time_minutes' => $prep_time_total,
        ':cook_time_minutes' => $cook_time_total,
        ':servings' => $servings,
        ':image' => $imagePath,
        ':view_count' => 0
      ];
      $stmt->execute($params);

      //Once the recipe is inputted, we can grab the recipe ID.

      $recipe_ID = $db->lastInsertId(); // Fetch the auto-incremented ID of the inserted recipe

      //Steps Insert Statements
      $sql = "INSERT INTO steps (order_number, recipe_ID, step) VALUES (:order_number, :recipe_ID, :step)";
      $stmt = $db->prepare($sql);

      $order_number = 1; // Start from step 1
      foreach ($steps as $step) {
        $params = [
          ':order_number' => $order_number,
          ':recipe_ID' => $recipe_ID, // Use the fetched recipe_ID
          ':step' => $step // Step description
        ];
        $stmt->execute($params);
        $order_number++;
      }
      //Ingredients
      $selectIngredientID = "SELECT ingredients_ID FROM ingredients WHERE ingredient = :ingredient";
      $addIngredient = "INSERT INTO ingredients (ingredient) VALUES (:ingredient)";
      $RecipeIngredientRelationship = "INSERT INTO recipe_r_ingredients (recipe_ID, ingredient_ID) VALUES (:recipe_ID, :ingredient_ID)";

      foreach ($ingredients as $ingredient) {
        // Check if the ingredient exists
        $stmt = $db->prepare($selectIngredientID);
        $stmt->execute([':ingredient' => $ingredient]);
        $result = $stmt->fetch();

        if ($result) {
          // Ingredient exists, get its ID
          $ingredientID = $result['ingredients_ID'];
        } else {
          // Ingredient does not exist, insert it and get the new ID
          $stmt = $db->prepare($addIngredient);
          $stmt->execute([':ingredient' => $ingredient]);
          $ingredientID = $db->lastInsertId();
        }

        // Create the relationship between recipe and ingredient
        $stmt = $db->prepare($RecipeIngredientRelationship);
        $stmt->execute([
          ':recipe_ID' => $recipe_ID, // Recipe ID from the earlier insert
          ':ingredient_ID' => $ingredientID // Ingredient ID from above
        ]);
      }

      $db->commit();

    } catch (Exception $e) {
      // Roll back the transaction on any failure
      $db->rollBack();
      echo "Transaction failed: " . $e->getMessage();
    }

    header("Location: ../entity/index.php");
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

          <form enctype="multipart/form-data" method="POST" action="create.php" id="change-form">
            <p>
              <strong>Recipe Name: </strong>
              <span class="required">*</span>
              <input type="text" class="form-control" name="name" id="recipe-name" />
            </p>

            <p>
              <strong>Author: </strong>
              <input type="text" class="form-control" name="author" id="m-authorName" value="<?= $author ?>" disabled />
            </p>

            <p>
              <strong>Category: &nbsp;&nbsp;</strong>
              <select name="category" id="m-category">
                <option value="Entrees">Entrees</option>
                <option value="Sides">Sides</option>
                <option value="Desserts">Desserts</option>
              </select>
            </p>

            <p class="prep_cook_time">
              <strong>Prep Time: </strong>
              <span class="required">*</span>
            <div style="display:flex">
              <div>
                &nbsp;&nbsp;Hours:&nbsp;&nbsp;
                <br>
                &nbsp;&nbsp;Minutes:&nbsp;&nbsp;
              </div>
              <div class="time_options">
                <?php
                $type = 'prep';
                ?>
                <select name="prep_time_hours" class="time" id="prep_time_hrs">
                  <?php
                  $time = 'hours';
                  generateTimeOptions($action, $time, $recipe);
                  ?>
                </select>
                <br>
                <select name="prep_time_minutes" class="time" id="prep_time_mins">
                  <?php
                  $time = 'minutes';
                  generateTimeOptions($action, $time, $recipe);
                  ?>
                </select>
              </div>
            </div>
            </p>

            <p class="prep_cook_time">
              <strong>Cook Time: </strong>
            <div style="display:flex">
              <div>
                &nbsp;&nbsp;Hours:&nbsp;&nbsp;
                <br>
                &nbsp;&nbsp;Minutes:&nbsp;&nbsp;
              </div>
              <div class="time_options">
                <?php
                $type = 'cook';
                ?>
                <select name="cook_time_hours" class="time" id="cook_time_hrs">
                  <?php
                  $time = 'hours';
                  generateTimeOptions($action, $time, $recipe);
                  ?>
                </select>
                <br>
                <select name="cook_time_minutes" class="time" id="cook_time_mins">
                  <?php
                  $time = 'minutes';
                  generateTimeOptions($action, $time, $recipe);
                  ?>
                </select>
              </div>
            </div>
            </p>

            <p>
              <strong>Total Time: &nbsp;&nbsp;</strong><input type="text" class="form-control" name="total_time"
                id="m-total-time" disabled />
            </p>

            <p>
              <strong>Servings: </strong>
              <span class="required">*</span>
              <select name="servings" id="servingSizes">
                <?php
                generateServingSizes($action, $recipe);
                ?>
              </select>
            </p>

            <p>
              <strong>Image: &nbsp;&nbsp;</strong><input type="file" class="form-control" name="image" accept="image/*" />
            </p>

            <p>
              <strong>Ingredients: </strong>
              <span class="required">*</span>
            <div id="m-ingredients"></div>

            <button type="button" id="add-ingredient" class="btn btn-secondary">Add Ingredient</button>
            </p>

            <p>
              <strong>Steps: </strong>
              <span class="required">*</span>
            <div id="m-steps"></div>

            <button type="button" id="add-step" class="btn btn-secondary">Add Step</button>
            </p>

            <div class="modal-footer" id="modalButton">
              <a href="index.php" class="btn btn-secondary" id="btn-cancel">
                Cancel
              </a>

              <a href="index.php">
                <button type="submit" class="btn btn-primary" id="save-changes-btn">
                  Save
                </button>
              </a>
            </div>
          </form>
        </div>
      </div>
    </main>
  </body>

  </html>

<?php } ?>