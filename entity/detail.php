<?php
include_once('../utils/functions.php');
include_once('../utils/SQLfunctions.php');
include_once('../db.php');

session_start();


$recipeID = $_GET['recipe_id'];

updateViewCountSQL($db, $recipeID);

$image = fetchRecipeImagePath($db, $recipeID);
$recipeName = fetchRecipeName($db, $recipeID);
$author = fetchRecipeAuthor($db, $recipeID);
$category = fetchRecipeCategory($db, $recipeID);

$prepTime =  fetchRecipeCookTime($db, $recipeID);
$cookTime =  fetchRecipeCookTime($db, $recipeID);
$totalTime = $prepTime + $cookTime;

$steps = fetchRecipeSteps($db, $recipeID);
$ingredients = fetchRecipeIngredients($db, $recipeID);
$servings = fetchRecipeServings($db, $recipeID);

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
					<img class="pic" src="<?= $image ?>" alt="Recipe photo" id="photo" />
				</div>

				<div class="col">
					<h3 id="name">
						<?= $recipeName ?>
					</h3>
					<p class="view_count">Total views: <?= getViewCountSQL($db, $recipeID) ?></p>
					<h3 id="author">
						By: <?= $author ?>
					</h3>

					<div class="d-flex justify-content-center flex-column">
						<div class="fw-bold text-center">Category:</div>
						<div id="category" class="text-center">
							<?= $category ?>
						</div>

						<div class="fw-bold text-center">Prep Time:</div>
						<div id="prep_time" class="text-center">
							<?php displayTime($prepTime); ?>
						</div>

						<div class="fw-bold text-center">Cook Time:</div>
						<div id="cook_time" class="text-center">
							<?php displayTime($cookTime); ?>
						</div>

						<div class="fw-bold text-center">Total Time:</div>
						<div id="total_time" class="text-center">
							<?php displayTime($totalTime) ?>
						</div>

						<div class="fw-bold text-center">Servings:</div>
						<div id="servings" class="text-center">
							<?= $servings ?>
						</div>
					</div>

					<h3>Ingredients</h3>
					<div class="centerContent">
						<ul id="ingredients">
							<?php
							displayIngredients($ingredients);
							?>
						</ul>
					</div>

					<h3>Steps</h3>
					<div class="centerContent">
						<ol id="steps">
							<?php
							displaySteps($steps);
							?>
						</ol>
					</div>
				</div>
			</div>
		</div>
	</main>
</body>

</html>
