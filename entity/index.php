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
		//Displays Create button if user is signed in
		if (isset($_SESSION['signedIn'])) {
			?>
			<div class="d-flex ms-3 buttons">
				<div id="create">
					<a href="create.php" id="create-btn" class="btn btn-primary">
						Create Recipes
					</a>
				</div>

				<?php
				//Displays admin buttons if user has admin status
				if (isset($_SESSION['admin'])) {
					?>
					<div>
						<a href="../admin/delete-all.php?target=recipe" class="btn btn-danger">
							Delete All Recipes
						</a>
					</div>

					<div>
						<a href="../admin/admin.php" class="btn btn-secondary manage-users">Manage Users</a>
					</div>
				<?php } ?>
			</div>
		<?php } ?>

		<div id="content">
			<?php displayCards($recipes); ?>
		</div>
	</main>
</body>

</html>