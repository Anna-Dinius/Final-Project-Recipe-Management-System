<?php
include_once('../utils/functions.php');

session_start();

//INSERT SQL HERE
//Pull each recipe_ID that matches with the user_ID, and add them to the array $recipies

$title = 'Favorites';

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

		<?php if (count($recipes) > 0) { ?>
			<div id="content">
				<?php
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

              <div class="d-flex btns" id="btn-box-<?= $recipes[$i]['id'] ?>">
                <a href="delete.php?recipe_id=<?= $recipes[$i]['id'] ?>" class="btn btn-danger btn-delete">Delete</a>
              </div>
            <?php } ?>
          </div>
          <?php
        } else {
			?>
			<div class="no-recipes">
				<h1>No recipes to display.</h1>
			</div>
		<?php } ?>
	</main>
</body>

</html>
