<?php

function getHead($title)
{
  ?>
  <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4="
    crossorigin="anonymous"></script>
  <script type="module" src="./js/form.js"></script>

  <title><?= $title ?></title>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous" />
  <link rel="stylesheet" href="../css/styles.css" type="text/css" />
  <?php
}

function getNav()
{
  ?>
  <div class="container-fluid">
    <a class="navbar-brand text-light" href="../entity/index.php">SavorySagas</a>

    <?php
    if (isset($_SESSION['signedIn']))
    ?>
    <div id="navbarNavAltMarkup">
      <div class="navbar-nav">
        <?php
        if (isset($_SESSION['signedIn'])) {
          ?>
          <a class="nav-link" href="../auth/logout.php" id="signinBtn">Sign out</a>
          <?php
        } else {
          ?>
          <a class="nav-link" href="../auth/signin.php" id="signinBtn">Sign in</a>
          <a class="nav-link" href="../auth/signup.php" id="signupBtn">Sign up</a>
          <?php
        } ?>
      </div>
    </div>
  </div>
  <?php
}

function getRecipe($recipes, $id)
{
  for ($i = 0; $i < count($recipes); $i++) {
    $recipe = $recipes[$i];
    if ($recipe['id'] == $id) {
      return $recipe;
    }
  }

  return null;
}

$visitors_file = '../data/visitors.csv';

function getViewCount($target_id)
{
  if (file_exists('../data/visitors.csv')) {
    $lines = file('../data/visitors.csv');

    for ($i = 0; $i < count($lines); $i++) {
      $line = explode(';', $lines[$i]);
      $id = trim($line[0]);
      $views = trim($line[1]);

      if ($id == $target_id) {
        return $views;
      }
    }
  } else {
    return 'View count not found';
  }
}

function updateViewCount($target_id)
{
  if (file_exists('../data/visitors.csv')) {
    $lines = file('../data/visitors.csv');
    $updated_lines = [];
    $views = 0;

    for ($i = 0; $i < count($lines); $i++) {
      $line = explode(';', $lines[$i]);
      $id = trim($line[0]);
      $views = trim($line[1]);

      if ($id == $target_id) {
        $views++;
      }

      $updated_lines[] = $id . ';' . $views;
    }

    // writing to the file
    $fp = fopen('../data/visitors.csv', 'w');

    foreach ($updated_lines as $line) {
      fputs($fp, $line . PHP_EOL);
    }

    fclose($fp);
  } else {
    echo "
      <script>
        alert('Error: Could not update view count')
      </script>
    ";
  }
}

function displayCards($recipes)
{
  for ($i = 0; $i < count($recipes); $i++) {
    ?>
    <div class="card">
      <a href="../entity/detail.php?recipe_id=<?= $recipes[$i]['id'] ?>">
        <div class="img-div">
          <img src="<?= $recipes[$i]['image'] ?>">
        </div>

        <div class="h1-div">
          <h1 class="text-truncate"><?= $recipes[$i]['name'] ?></h1>
        </div>

        <p class="author">Author: <?= $recipes[$i]['author'] ?></p>
      </a>

      <?php if (isset($_SESSION['signedIn'])) { ?>
        <div class="d-flex btns" id="btn-box-<?= $recipes[$i]['id'] ?>">
          <a href="../entity/delete.php?recipe_id=<?= $recipes[$i]['id'] ?>"
            class="btn btn-sm btn-danger btn-delete">Delete</a>
          <a href="../entity/edit.php?recipe_id=<?= $recipes[$i]['id'] ?>" class="btn btn-secondary update-btn">Edit</a>
        </div>
      <?php } ?>
    </div>
    <?php
  }
}

function displayIngredients($recipe)
{
  for ($i = 0; $i < count($recipe['ingredients']); $i++) {
    ?>
    <li id="item-<?= $i ?>"><?= $recipe['ingredients'][$i] ?></li>
    <?php
  }
}

function displaySteps($recipe)
{
  for ($i = 0; $i < count($recipe['steps']); $i++) {
    ?>
    <li><?= $recipe['steps'][$i] ?></li>
    <?php
  }
}

function generateServingSizes($action, $recipe)
{
  $largestServing = 20;

  if ($action == 'create') {
    for ($i = 0; $i <= $largestServing; $i++) {
      ?>
      <option value="<?= $i ?>"><?= $i ?></option>
      <?php
    }
  }

  if ($action == 'edit') {
    for ($i = 0; $i <= $largestServing; $i++) {
      if ($i == $recipe['servings']) {
        ?>
        <option value="<?= $i ?>" selected><?= $i ?></option>
        <?php
      } else {
        ?>
        <option value="<?= $i ?>"><?= $i ?></option>
        <?php
      }
    }
  }
}

function generateTimeOptions($action, $type, $time, $recipe)
{
  $maxHours = 24;
  $maxMinutes = 60;

  if ($action == 'create') {
    if ($time == 'hours') {
      for ($i = 0; $i <= $maxHours; $i++) {
        ?>
        <option value="<?= $i ?>"><?= $i ?></option>
        <?php
      }
    } elseif ($time == 'minutes') {
      for ($i = 0; $i < $maxMinutes; $i += 5) {
        ?>
        <option value="<?= $i ?>"><?= $i ?></option>
        <?php
      }
    }
  } elseif ($action == 'edit') {
    if ($time == 'hours') {
      for ($i = 0; $i <= $maxHours; $i++) {
        if ($i == $recipe[$type . '_time_hours']) {
          ?>
          <option value="<?= $i ?>" selected><?= $i ?></option>
          <?php
        } else {
          ?>
          <option value="<?= $i ?>"><?= $i ?></option>
          <?php
        }
      }
    } elseif ($time == 'minutes') {
      for ($i = 0; $i < $maxMinutes; $i += 5) {
        if ($i == $recipe[$type . '_time_minutes']) {
          ?>
          <option value="<?= $i ?>" selected><?= $i ?></option>
          <?php
        } else {
          ?>
          <option value="<?= $i ?>"><?= $i ?></option>
          <?php
        }
      }
    }
  }
}

function generateSteps($recipe)
{
  for ($i = 0; $i < count($recipe['steps']); $i++) {
    ?>
    <div class="d-flex">
      <textarea class="form-control mb-3 step-input" name="steps[]"
        id="step-<?= $i + 1 ?>"><?= $recipe['steps'][$i] ?></textarea>
      <button type="button" class="btn btn-danger del-input">X</button>
    </div>
    <?php
  }
}
function generateIngredients($recipe)
{
  for ($i = 0; $i < count($recipe['ingredients']); $i++) {
    ?>
    <div class="d-flex">
      <input class="form-control mb-3 ingredient-input" name="ingredients[]" id="ingredient-<?= $i + 1 ?>"
        value="<?= $recipe['ingredients'][$i] ?>" />
      <button type="button" class="btn btn-danger del-input">X</button>
    </div>
    <?php
  }
}

function generateCategory($recipe)
{
  $categories = ['Entrees', 'Sides', 'Desserts'];

  foreach ($categories as $category) {
    if ($recipe['category'] == $category) {
      ?>
      <option value="<?= $category ?>" selected><?= $category ?></option>
      <?php
    } else {
      ?>
      <option value="<?= $category ?>"><?= $category ?></option>
      <?php
    }
  }
}

function displayTime($type, $recipe)
{
  $hours = $recipe[$type . '_time_hours'];
  $minutes = $recipe[$type . '_time_minutes'];
  $time = '';

  if ($hours == 0) {
    $hours = '';
  } elseif ($hours == 1) {
    $hours = $hours . ' hour';
  } elseif ($hours > 1) {
    $hours = $hours . ' hours';
  }

  if ($minutes == 0) {
    $minutes = '';
  } elseif ($minutes > 1) {
    $minutes = $minutes . ' minutes';
  }

  if ($hours != '' && $minutes != '') {
    $time = $hours . ', ' . $minutes;
  } else if ($hours == '') {
    $time = $minutes;
  } else if ($minutes == '') {
    $time = $hours;
  } else {
    $time = 'Error fetching time';
  }

  echo $time;
}