<?php
include_once('../utils/functions.php');
require_once('../db.php');

session_start();

$file = '../data/recipes.json';
$content = file_get_contents($file);
$recipes = json_decode($content, true);

$action = 'create';
$recipe = null;

$title = 'Create a Recipe';

$author = $_SESSION['name'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $name = $_POST['name'];
  $category = $_POST['category'];
  $image = $_POST['image'];
  $prep_time_hours = $_POST['prep_time_hours'];
  $prep_time_minutes = $_POST['prep_time_minutes'];
  $cook_time_hours = $_POST['cook_time_hours'];
  $cook_time_minutes = $_POST['cook_time_minutes'];
  $servings = $_POST['servings'];
  $ingredients = $_POST['ingredients'];
  $steps = $_POST['steps'];

  $total_time_hours = $prep_time_hours + $cook_time_hours;
  $total_time_minutes = $prep_time_minutes + $cook_time_minutes;

  if ($total_time_minutes >= 60) {
    $total_time_hours++;
    $total_time_minutes = $total_time_minutes % 60;
  }

  $id = count($recipes) + 1;

  $new_recipe = [
    'id' => $id,
    'name' => $name,
    'author' => $author,
    'category' => $category,
    'image' => $image,
    'prep_time_hours' => $prep_time_hours,
    'prep_time_minutes' => $prep_time_minutes,
    'cook_time_hours' => $cook_time_hours,
    'cook_time_minutes' => $cook_time_minutes,
    'total_time' => "{$total_time_hours} hours {$total_time_minutes} minutes",
    'servings' => $servings,
    'ingredients' => $ingredients,
    'steps' => $steps,
  ];


  $recipes[] = $new_recipe;
  $content = json_encode($recipes, JSON_PRETTY_PRINT);
  file_put_contents('../data/recipes.json', $content);

  header("Location: ../entity/detail.php?recipe_id=$id");
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

        <form method="POST" action="create.php" id="change-form">
          <p>
            <strong>Recipe Name: </strong>
            <span class="required">*</span>
            <input type="text" class="form-control" name="name" id="recipe-name" />
          </p>

          <p class="author-input">
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
              <select name="prep_time_hours" class="time_hrs prep_time" id="prep_time_hrs">
                <?php
                $time = 'hours';
                generateTimeOptions($action, $type, $time, $recipe);
                ?>
              </select>
              <br>
              <select name="prep_time_minutes" class="time_mins prep_time" id="prep_time_mins">
                <?php
                $time = 'minutes';
                generateTimeOptions($action, $type, $time, $recipe);
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
              <select name="cook_time_hours" class="time_hrs cook_time" id="cook_time_hrs">
                <?php
                $time = 'hours';
                generateTimeOptions($action, $type, $time, $recipe);
                ?>
              </select>
              <br>
              <select name="cook_time_minutes" class="time_mins cook_time" id="cook_time_mins">
                <?php
                $time = 'minutes';
                generateTimeOptions($action, $type, $time, $recipe);
                ?>
              </select>
            </div>
          </div>
          </p>

          <p class="total-time-input">
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
            <strong>Image: &nbsp;&nbsp;</strong><input class="form-control" name="image" />
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