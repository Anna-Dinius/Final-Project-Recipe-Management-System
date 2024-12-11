<?php

function fetchRecipes($db)
{
    try {
        // Prepare the SQL query
        $sql = "SELECT
                    recipes.recipe_ID AS id,
                    recipes.recipe_name AS name,
                    recipes.image,
                    users.name AS author
                FROM
                    recipes
                INNER JOIN
                    users
                ON
                    recipes.user_ID = users.user_ID";

        // Execute the query
        $stmt = $db->query($sql);

        // Fetch all results as an associative array
        $recipes = $stmt->fetchAll();

        return $recipes;
    } catch (Exception $e) {
        echo "Error fetching recipes: " . $e->getMessage();
        return [];
    }
}

function fetchFavoriteRecipes($db, $userId)
{
    try {
        $sqlFavorites = "SELECT recipe_ID FROM favorites WHERE user_ID = :userId";

        $stmtFavorites = $db->prepare($sqlFavorites);
        $stmtFavorites->execute(['userId' => $userId]);

        $favoriteRecipeIds = $stmtFavorites->fetchAll(PDO::FETCH_COLUMN);

        if (empty($favoriteRecipeIds)) {
            return [];
        }

        $sqlRecipes = "SELECT
                           recipes.recipe_ID AS id,
                           recipes.recipe_name AS name,
                           recipes.image,
                           users.name AS author
                       FROM
                           recipes
                       INNER JOIN
                           users
                       ON
                           recipes.user_ID = users.user_ID
                       WHERE
                           recipes.recipe_ID IN (" . implode(',', array_fill(0, count($favoriteRecipeIds), '?')) . ")";

        $stmtRecipes = $db->prepare($sqlRecipes);
        $stmtRecipes->execute($favoriteRecipeIds);

        $favoriteRecipes = $stmtRecipes->fetchAll(PDO::FETCH_ASSOC);

        return $favoriteRecipes;
    } catch (Exception $e) {
        error_log("Error fetching favorite recipes: " . $e->getMessage());
        return [];
    }
}


function updateViewCountSQL($db, $recipeID)
{
    try {
        // Prepare the UPDATE query to increment the view count
        $sql = "UPDATE recipes SET view_count = view_count + 1 WHERE recipe_ID = :recipeID";
        $stmt = $db->prepare($sql);

        // Execute the query with the provided recipe ID
        $stmt->execute([':recipeID' => $recipeID]);
    } catch (Exception $e) {
        echo "Error updating view count: " . $e->getMessage();
    }
}

function getViewCountSQL($db, $recipeID)
{
    try {
        $sql = "SELECT view_count FROM recipes  WHERE recipe_ID = :recipeID";
        $stmt = $db->prepare($sql);

        $stmt->execute([':recipeID' => $recipeID]);
        $view = $stmt->fetch();

        return $view ? $view['view_count'] : 'Unknown';
    } catch (Exception $e) {
        echo "Error updating view count: " . $e->getMessage();
        return 'Unknown';
    }
}

function fetchRecipeAuthor($db, $recipeID)
{
    try {
        $sql = "SELECT users.name AS author
                FROM users
                INNER JOIN recipes ON recipes.user_ID = users.user_ID
                WHERE recipes.recipe_ID = :recipeID";

        $stmt = $db->prepare($sql);
        $stmt->execute([':recipeID' => $recipeID]);
        $author = $stmt->fetch();

        return $author ? $author['author'] : 'Unknown';
    } catch (Exception $e) {
        echo "Error fetching recipe author: " . $e->getMessage();
        return 'Unknown';
    }
}


function fetchRecipeIngredients($db, $recipeID)
{
    try {
        $sql = "SELECT ingredients.ingredient
                FROM ingredients
                INNER JOIN recipe_r_ingredients ON ingredients.ingredients_ID = recipe_r_ingredients.ingredient_ID
                WHERE recipe_r_ingredients.recipe_ID = :recipeID";

        $stmt = $db->prepare($sql);
        $stmt->execute([':recipeID' => $recipeID]);
        $ingredients = $stmt->fetchAll();

        return $ingredients; // Will return a list of ingredients as associative arrays
    } catch (Exception $e) {
        echo "Error fetching recipe ingredients: " . $e->getMessage();
        return [];
    }
}


function fetchRecipeSteps($db, $recipeID)
{
    try {
        $sql = "SELECT order_number, step
                FROM steps
                WHERE recipe_ID = :recipeID
                ORDER BY order_number ASC";

        $stmt = $db->prepare($sql);
        $stmt->execute([':recipeID' => $recipeID]);
        $steps = $stmt->fetchAll();

        return $steps; // List of steps in order
    } catch (Exception $e) {
        echo "Error fetching recipe steps: " . $e->getMessage();
        return [];
    }
}

function fetchRecipeName($db, $recipeID)
{
    try {
        $sql = "SELECT recipe_name
                FROM recipes
                WHERE recipe_ID = :recipeID";

        $stmt = $db->prepare($sql);
        $stmt->execute([':recipeID' => $recipeID]);
        $name = $stmt->fetch();

        return $name ? $name['recipe_name'] : 'Unknown';
    } catch (Exception $e) {
        echo "Error fetching recipe name: " . $e->getMessage();
        return 'Unknown';
    }
}

function fetchRecipeImagePath($db, $recipeID)
{
    try {
        $sql = "SELECT image
                FROM recipes
                WHERE recipe_ID = :recipeID";

        $stmt = $db->prepare($sql);
        $stmt->execute([':recipeID' => $recipeID]);
        $image = $stmt->fetch();

        return $image ? $image['image'] : 'Unknown';
    } catch (Exception $e) {
        echo "Error fetching recipe image: " . $e->getMessage();
        return [];
    }
}

function fetchRecipeCategory($db, $recipeID)
{
    try {
        // Fetch the category ID of the given recipe
        $sql = "SELECT category.category_name
                FROM category
                INNER JOIN recipes ON recipes.category_ID = category.category_ID
                WHERE recipes.recipe_ID = :recipeID";

        $stmt = $db->prepare($sql);
        $stmt->execute([':recipeID' => $recipeID]);
        $category = $stmt->fetch();

        return $category ? $category['category_name'] : 'Unknown Category';
    } catch (Exception $e) {
        echo "Error fetching recipe category: " . $e->getMessage();
        return 'Unknown Category';
    }
}

function fetchRecipePrepTime($db, $recipeID)
{
    try {
        $sql = "SELECT prep_time_minutes
                FROM recipes
                WHERE recipe_ID = :recipeID";

        $stmt = $db->prepare($sql);
        $stmt->execute([':recipeID' => $recipeID]);
        $time = $stmt->fetch();

        return $time ? $time['prep_time_minutes'] : 'Unknown';
    } catch (Exception $e) {
        echo "Error fetching recipe prep time: " . $e->getMessage();
        return 'Unknown';
    }
}

function fetchRecipeCookTime($db, $recipeID)
{
    try {
        $sql = "SELECT cook_time_minutes
                FROM recipes
                WHERE recipe_ID = :recipeID";

        $stmt = $db->prepare($sql);
        $stmt->execute([':recipeID' => $recipeID]);
        $time = $stmt->fetch();

        return $time ? $time['cook_time_minutes'] : 'Unknown';
    } catch (Exception $e) {
        echo "Error fetching recipe prep time: " . $e->getMessage();
        return 'Unknown';
    }
}

function fetchRecipeServings($db, $recipeID)
{
    try {
        $sql = "SELECT servings
                FROM recipes
                WHERE recipe_ID = :recipeID";

        $stmt = $db->prepare($sql);
        $stmt->execute([':recipeID' => $recipeID]);
        $servings = $stmt->fetch();

        return $servings ? $servings['servings'] : 'Unknown';
    } catch (Exception $e) {
        echo "Error fetching recipe prep time: " . $e->getMessage();
        return 'Unknown';
    }
}

function deleteOldRecipe($db, $recipeID)
{
    try {
        $sql = "DELETE FROM recipes WHERE recipe_ID = :recipeID";
        $stmt = $db->prepare($sql);
        $stmt->execute([':recipeID' => $recipeID]);

        return true; // Deletion successful
    } catch (Exception $e) {
        echo "Error deleting recipe: " . $e->getMessage();
        return false;
    }
}

function deleteOldImage($db, $recipeID)
{
    try {
        // Fetch current image path from the database
        $sql = "SELECT image FROM recipes WHERE recipe_ID = :recipeID";
        $stmt = $db->prepare($sql);
        $stmt->execute([':recipeID' => $recipeID]);
        $recipe = $stmt->fetch();

        if ($recipe && isset($recipe['image']) && file_exists($recipe['image'])) {
            unlink($recipe['image']); // Delete the image file
        }

        return true;
    } catch (Exception $e) {
        echo "Error deleting old image: " . $e->getMessage();
        return false;
    }
}
