<?php
include_once('../utils/functions.php');
include_once('../utils/SQLfunctions.php');
include_once('../db.php');

session_start();

// Fetch the recipes from database
$recipes = fetchRecipes($db);

$title = 'Recipes';

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

		<?php
		//Displays Create button if user is signed in
		if (isset($_SESSION['signedIn'])) {
			?>
			<div class="d-flex justify-content-center gap-3">
				<div id="create">
					<a href="create.php" id="create-btn" class="btn btn-primary">
						Create a Recipe
					</a>
				</div>

				<div id="favorites">
					<a href="../favorites/index.php" id="favorites-btn" class="btn btn-secondary update-btn">
						Go to Favorites
					</a>
				</div>

				<?php
				//Displays admin buttons if user has admin status
				if (isset($_SESSION['admin'])) {
					if (count($recipes) > 0) {
						?>

						<div>
							<a href="../admin/delete-all.php?target=recipe" class="btn btn-danger">
								Delete All Recipes
							</a>
						</div>
					<?php } ?>

					<div>
						<a href="../admin/admin.php" class="btn btn-secondary manage-users">Manage Users</a>
					</div>

				<?php } ?>
			</div>
		<?php } ?>

		<?php if (count($recipes) > 0) { ?>
			<div id="content">
				<?php displayCards($recipes); ?>
			</div>
		<?php } else {
			?>
			<div class="no-recipes">
				<h1>No recipes to display.</h1>

				<?php if (!isset($_SESSION['signedIn'])) { ?>
					<p><a href="../auth/signin.php">Sign in</a> or <a href="../auth/signup.php">sign up</a> to add the first recipe.
					</p>
				<?php } ?>
			</div>
		<?php } ?>

	</main>
</body>

</html>
