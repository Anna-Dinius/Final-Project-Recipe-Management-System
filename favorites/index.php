<?php
include_once('../utils/functions.php');
include_once('../utils/SQLfunctions.php');
include_once('../db.php');

session_start();

$recipes = fetchFavoriteRecipes($db, $_SESSION['user_id']);

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
		<div class="d-flex ms-3 buttons">
			<a href="../entity/index.php" id="index-btn" class="btn btn-secondary update-btn">
				Back to Index
			</a>
		</div>
		<?php if (count($recipes) > 0) { ?>
			<div id="content">
				<?php displayFavoriteCards($recipes); ?>
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