<?php
include_once('../utils/functions.php');

session_start();

$file = '../data/recipes.json';
$content = file_get_contents($file);
$recipes = json_decode($content, true);

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
		//Displays Create button if the user is signed in.
		if (isset($_SESSION['signedIn'])) {
			?>
			<div class="d-flex ms-3 buttons">
				<div id="create">
					<a href="create.php" id="create-btn" class="btn btn-primary">
						Create
					</a>
				</div>

				<div>
					<a href="admin.php" class="btn manage-users">Manage Users</a>
				</div>
			</div>
		<?php } ?>

		<div id="content">
			<?php
			displayCards($recipes);
			?>
		</div>
	</main>
</body>

</html>