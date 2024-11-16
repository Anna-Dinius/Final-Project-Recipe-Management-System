<?php
include_once('../utils/functions.php');

session_start();

$file = '../data/recipes.json';
$content = file_get_contents($file);
$recipes = json_decode($content, true);

$id = $_GET['recipe_id'];
$recipe = getRecipe($recipes, $id);

updateViewCount($id);

$title = 'Recipe Details';

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

				<div class="colpic">
					<img class="pic" src="<?= $recipe['image'] ?>" alt="Recipe photo" id="photo" />
				</div>

				<div class="col">
					<h3 id="name">
						<?= $recipe['name'] ?>
					</h3>
					<p class="view_count">Total views: <?= getViewCount($id) ?></p>
					<h3 id="author">
						By: <?= $recipe['author'] ?>
					</h3>

					<div class="d-flex justify-content-center flex-column">
						<div class="fw-bold text-center">Category:</div>
						<div id="category" class="text-center">
							<?= $recipe['category'] ?>
						</div>

						<div class="fw-bold text-center">Prep Time:</div>
						<div id="prep_time" class="text-center">
							<?php displayTime('prep', $recipe); ?>
						</div>

						<div class="fw-bold text-center">Cook Time:</div>
						<div id="cook_time" class="text-center">
							<?php displayTime('cook', $recipe); ?>
						</div>

						<div class="fw-bold text-center">Total Time:</div>
						<div id="total_time" class="text-center">
							<?= $recipe['total_time'] ?>
						</div>

						<div class="fw-bold text-center">Servings:</div>
						<div id="servings" class="text-center">
							<?= $recipe['servings'] ?>
						</div>
					</div>

					<h3>Ingredients</h3>
					<div class="centerContent">
						<ul id="ingredients">
							<?php
							displayIngredients($recipe);
							?>
						</ul>
					</div>

					<h3>Steps</h3>
					<div class="centerContent">
						<ol id="steps">
							<?php
							displaySteps($recipe);
							?>
						</ol>
					</div>
				</div>
			</div>
		</div>
	</main>
</body>

</html>