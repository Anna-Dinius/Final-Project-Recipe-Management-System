<?php

function alert()
{
  echo "<script>
    alert('Something went wrong. Returning you to the Home page...');
    window.location.href = '../entity/index.php';
  </script>";
}

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

function getSignUpForm()
{
  ?>
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
    <input type="password" class="form-control" id="password" placeholder="Password" name="password" required />
  </div>
  <?php
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

function allowedToEdit($author)
{
  if (isset($_SESSION['admin'])) {
    return true;
  } elseif (isset($_SESSION['name'])) {
    if ($author == $_SESSION['name']) {
      return true;
    }
  }
  return false;
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

      <?php
      if (isset($_SESSION['signedIn'])) { ?>
        <div class="d-flex btns" id="btn-box-<?= $recipes[$i]['id'] ?>">
        <?php if (allowedToEdit($recipes[$i]['author'])) { ?>
            <a href="../entity/delete.php?recipe_id=<?= $recipes[$i]['id'] ?>" class="btn btn-danger btn-delete">Delete</a>
            <a href="../entity/edit.php?recipe_id=<?= $recipes[$i]['id'] ?>" class="btn btn-secondary update-btn">Edit</a>
        <?php } ?>
        <a href="../favorites/add-favorite.php?recipe_id=<?= $recipes[$i]['id'] ?>" class="btn btn-secondary update-btn">Favorite</a>
      </div>
      <?php } ?>
    </div>
    <?php
  }
}

function displayFavoriteCards($recipes)
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

      <?php
      if (isset($_SESSION['signedIn'])) { ?>
        <div class="d-flex btns" id="btn-box-<?= $recipes[$i]['id'] ?>">
        <a href="../favorites/delete.php?recipe_id=<?= $recipes[$i]['id'] ?>" class="btn btn-danger btn-delete">Delete</a>
      </div>
      <?php } ?>
    </div>
    <?php
  }
}

function displayIngredients($ingredients)
{
    foreach ($ingredients as $index => $ingredient) {
        ?>
        <li id="item-<?= $index ?>"><?= $ingredient['ingredient'] ?></li>
        <?php
    }
}

function displaySteps($steps)
{
    foreach ($steps as $index => $step) {
        ?>
        <li id="item-<?= $index ?>"><?= $step['step'] ?></li>
        <?php
    }
}


function generateServingSizes($action, $servings = 0)
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
      if ($i == $servings) {
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

function generateTimeOptions($action, $time, $selectedValue = null)
{
    $maxHours = 24;
    $maxMinutes = 60;

    if ($action == 'create') {
        if ($time == 'hours') {
            for ($i = 0; $i <= $maxHours; $i++) {
                echo "<option value=\"$i\">$i</option>";
            }
        } elseif ($time == 'minutes') {
            for ($i = 0; $i < $maxMinutes; $i += 5) {
                echo "<option value=\"$i\">$i</option>";
            }
        }
    } elseif ($action == 'edit') {
        if ($time == 'hours') {
            for ($i = 0; $i <= $maxHours; $i++) {
                $selected = ($i == $selectedValue) ? 'selected' : '';
                echo "<option value=\"$i\" $selected>$i</option>";
            }
        } elseif ($time == 'minutes') {
            for ($i = 0; $i < $maxMinutes; $i += 5) {
                $selected = ($i == $selectedValue) ? 'selected' : '';
                echo "<option value=\"$i\" $selected>$i</option>";
            }
        }
    }
}


function generateSteps($steps = [])
{
  for ($i = 0; $i < count($steps); $i++) {
    ?>
    <div class="d-flex">
      <textarea class="form-control mb-3 step-input" name="steps[]"
        id="step-<?= $i + 1 ?>"><?= $steps[$i]['step'] ?></textarea>
      <button type="button" class="btn btn-danger del-input">X</button>
    </div>
    <?php
  }
}
function generateIngredients($ingredients = [])
{
  for ($i = 0; $i < count($ingredients); $i++) {
    ?>
    <div class="d-flex">
      <input class="form-control mb-3 ingredient-input" name="ingredients[]" id="ingredient-<?= $i + 1 ?>"
        value="<?= $ingredients[$i]['ingredient'] ?>" />
      <button type="button" class="btn btn-danger del-input">X</button>
    </div>
    <?php
  }
}

function generateCategory($category = '')
{
  $categories = ['Entrees', 'Sides', 'Dessert'];

  foreach ($categories as $category) {
    if ($category == $category) {
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

function displayTime($totalMinutes)
{
  $hours = intdiv($totalMinutes, 60); // Calculate full hours
  $minutes = $totalMinutes % 60; // Get remaining minutes after dividing by 60
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
  } elseif ($minutes == 1) {
    $minutes = $minutes . ' minute';
  } elseif ($minutes > 1) {
    $minutes = $minutes . ' minutes';
  }

  if ($hours != '' && $minutes != '') {
    $time = $hours . ', ' . $minutes;
  } elseif ($hours == '') {
    $time = $minutes;
  } elseif ($minutes == '') {
    $time = $hours;
  } else {
    $time = 'Error fetching time';
  }

    echo $time;
}
function displayUserRows($users)
{
  // echo count($users);
  foreach ($users as $user) {
    ?>
    <tr>
      <td class="name"><?= $user['name'] ?></td>
      <td class="email"><?= $user['email'] ?></td>

      <td class="status">
        <?php
        if ($user['is_admin'] == 1) {
          echo 'Admin';
        } else {
          echo 'User';
        }
        ?>
      </td>

      <td>
        <form method="POST" action="change-status.php?user_ID=<?= $user['user_ID'] ?>">
          <button type="submit" name="status" value="<?= $user['is_admin'] == 1 ? 'admin' : 'user' ?>" class="btn
            btn-primary change-status-btn">
            Change Status
          </button>
        </form>
      </td>

      <td>
        <?php
        if ($user['is_admin'] == 0) {
          ?>
          <form method="POST" action="delete-user.php?user_ID=<?= $user['user_ID'] ?>">
            <button type="submit" class="btn btn-danger">Delete User</button>
          </form>
          <?php
        }
        ?>

      </td>
    </tr>
    <?php
  }
}
