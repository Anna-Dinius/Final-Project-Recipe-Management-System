-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 10, 2024 at 05:28 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `savorysagasdb`
--

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `category_ID` tinyint(4) UNSIGNED NOT NULL,
  `category_name` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`category_ID`, `category_name`) VALUES
(1, 'Entrees'),
(2, 'Dessert'),
(3, 'Sides');

-- --------------------------------------------------------

--
-- Table structure for table `favorites`
--

CREATE TABLE `favorites` (
  `recipe_ID` int(10) UNSIGNED NOT NULL,
  `user_ID` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ingredients`
--

CREATE TABLE `ingredients` (
  `ingredients_ID` tinyint(3) UNSIGNED NOT NULL,
  `ingredient` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `ingredients`
--

INSERT INTO `ingredients` (`ingredients_ID`, `ingredient`) VALUES
(15, 'Test Ingredient'),
(16, '4 boneless, skinless chicken breasts'),
(17, '1 (15 oz) can black beans, drained and rinsed'),
(18, '1 (15 oz) can corn, drained'),
(19, '1 (10 oz) can diced tomatoes with green chilies (like Rotel)'),
(20, '1 cup shredded cheddar cheese (or your choice of cheese)'),
(21, '1 packet taco seasoning (about 1 oz)'),
(22, '1 tbsp olive oil'),
(23, 'Optional: fresh cilantro and sour cream for garnish'),
(24, '1 cup (2 sticks) unsalted butter, softened'),
(25, '1 cup granulated sugar'),
(26, '1 cup packed brown sugar'),
(27, '2 large eggs'),
(28, '2 tsp vanilla extract'),
(29, '3 cups all-purpose flour'),
(30, '1 tsp baking soda'),
(31, '1/2 tsp salt'),
(32, '2 cups (12-oz bag) semisweet chocolate chips'),
(33, '4 large russet potatoes'),
(34, '4 tbsp unsalted butter'),
(35, ''),
(36, '1/2 cup sour cream'),
(37, '1/4 cup milk (or heavy cream)'),
(38, '1 cup shredded cheddar cheese (divided)'),
(39, '4 slices bacon, cooked and crumbled (optional)'),
(40, '2 green onions, chopped'),
(41, '1/2 tsp garlic powder'),
(42, 'Salt and pepper to taste');

-- --------------------------------------------------------

--
-- Table structure for table `recipes`
--

CREATE TABLE `recipes` (
  `recipe_ID` int(10) UNSIGNED NOT NULL,
  `user_ID` int(10) UNSIGNED NOT NULL,
  `recipe_name` varchar(100) NOT NULL,
  `category_ID` tinyint(4) UNSIGNED NOT NULL,
  `prep_time_minutes` tinyint(3) UNSIGNED NOT NULL,
  `cook_time_minutes` tinyint(3) UNSIGNED NOT NULL,
  `servings` tinyint(4) UNSIGNED NOT NULL,
  `image` varchar(255) NOT NULL COMMENT 'File Path',
  `view_count` int(11) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `recipes`
--

INSERT INTO `recipes` (`recipe_ID`, `user_ID`, `recipe_name`, `category_ID`, `prep_time_minutes`, `cook_time_minutes`, `servings`, `image`, `view_count`) VALUES
(18, 1, 'Chocolate Chip Cookies', 2, 10, 10, 6, '../img/old-fashioned-chocolate-chip-cookies.jpg', 1),
(21, 7, 'Dillon\'s Testing Recipe', 2, 75, 75, 4, '../img/twice-baked-potatoes.jpeg', 0),
(23, 1, 'Santa Fe Chicken', 2, 30, 30, 0, '../img/santa-fe-chicken-recipe.jpg', 0);

-- --------------------------------------------------------

--
-- Table structure for table `recipe_r_ingredients`
--

CREATE TABLE `recipe_r_ingredients` (
  `recipe_ID` int(10) UNSIGNED NOT NULL,
  `ingredient_ID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `recipe_r_ingredients`
--

INSERT INTO `recipe_r_ingredients` (`recipe_ID`, `ingredient_ID`) VALUES
(18, 24),
(18, 25),
(18, 26),
(18, 27),
(18, 28),
(18, 29),
(18, 30),
(18, 31),
(18, 32),
(21, 33),
(21, 34),
(21, 36),
(21, 37),
(21, 38),
(21, 39),
(21, 40),
(21, 41),
(21, 42),
(23, 16),
(23, 17),
(23, 18),
(23, 19),
(23, 20),
(23, 21),
(23, 22),
(23, 23);

-- --------------------------------------------------------

--
-- Table structure for table `steps`
--

CREATE TABLE `steps` (
  `order_number` tinyint(3) UNSIGNED NOT NULL,
  `recipe_ID` int(10) UNSIGNED NOT NULL,
  `step` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `steps`
--

INSERT INTO `steps` (`order_number`, `recipe_ID`, `step`) VALUES
(1, 18, 'Preheat your oven to 375°F (190°C).'),
(1, 21, 'Preheat your oven to 400°F (200°C).\r\nScrub the potatoes clean and poke each with a fork several times.\r\nPlace them directly on the oven rack and bake for 45-60 minutes, or until tender.\r\nRemove and let cool slightly, until they are safe to handle.'),
(1, 23, 'Season the chicken breasts with the taco seasoning on both sides.'),
(2, 18, 'In a large mixing bowl, beat the softened butter, granulated sugar, and brown sugar together until light and fluffy (about 2-3 minutes).'),
(2, 21, 'Cut each potato in half lengthwise.\r\nCarefully scoop out the insides into a mixing bowl, leaving a thin layer of potato to support the skin. Place the potato skins on a baking sheet.\r\n'),
(2, 23, 'In a large skillet or oven-safe dish, heat the olive oil over medium heat.\r\nAdd the chicken and sear for 3-4 minutes on each side until lightly browned.'),
(3, 18, 'Beat in the eggs one at a time, then mix in the vanilla extract.'),
(3, 21, 'Mash the scooped potato flesh with butter, sour cream, milk, garlic powder, salt, and pepper until creamy.\r\nStir in half of the cheddar cheese, most of the bacon (if using), and half of the green onions.'),
(3, 23, 'Remove the chicken from the skillet temporarily.\r\nAdd the black beans, corn, and diced tomatoes with green chilies to the skillet. Stir to combine.'),
(4, 18, 'In a separate bowl, whisk together the all-purpose flour, baking soda, and salt.'),
(4, 21, 'Spoon the filling back into the potato skins, mounding slightly.\r\nTop each with the remaining cheddar cheese.'),
(4, 23, 'Place the chicken back into the skillet on top of the mixture.'),
(5, 18, 'Gradually add the dry ingredients to the butter mixture, mixing until just combined. Avoid overmixing.'),
(5, 21, 'Reduce the oven temperature to 375°F (190°C).\r\nReturn the stuffed potatoes to the oven and bake for 15-20 minutes, or until the cheese is melted and the tops are golden brown.'),
(5, 23, 'Sprinkle shredded cheese over the chicken breasts.'),
(6, 18, 'Fold in the chocolate chips until evenly distributed.'),
(6, 21, 'Remove from the oven, sprinkle with the remaining bacon and green onions, and serve hot.'),
(6, 23, 'Preheat your oven to 350°F (175°C).\r\nCover the skillet or dish with aluminum foil and bake for 25-30 minutes, or until the chicken is fully cooked (internal temperature of 165°F).'),
(7, 18, 'Drop tablespoon-sized spoonfuls of dough onto an ungreased baking sheet, spacing them about 2 inches apart.'),
(7, 23, 'Remove from the oven, garnish with fresh cilantro or a dollop of sour cream if desired, and serve warm.'),
(8, 18, 'Bake for 8-10 minutes, or until the edges are golden brown.'),
(9, 18, 'Allow the cookies to cool on the baking sheet for about 2 minutes, then transfer to a wire rack to cool completely.');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_ID` int(10) UNSIGNED NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(200) NOT NULL,
  `password` varchar(72) NOT NULL,
  `is_admin` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_ID`, `name`, `email`, `password`, `is_admin`) VALUES
(1, 'John Doe', 'johndoe@gmail.com', 'johndoe', 0),
(7, 'Dillon Carpenter', 'admin@gmail.com', 'password1!', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`category_ID`);

--
-- Indexes for table `favorites`
--
ALTER TABLE `favorites`
  ADD PRIMARY KEY (`recipe_ID`,`user_ID`),
  ADD KEY `recipe_ID` (`recipe_ID`),
  ADD KEY `user_ID` (`user_ID`);

--
-- Indexes for table `ingredients`
--
ALTER TABLE `ingredients`
  ADD PRIMARY KEY (`ingredients_ID`);

--
-- Indexes for table `recipes`
--
ALTER TABLE `recipes`
  ADD PRIMARY KEY (`recipe_ID`),
  ADD KEY `user_ID` (`user_ID`),
  ADD KEY `category_ID` (`category_ID`);

--
-- Indexes for table `recipe_r_ingredients`
--
ALTER TABLE `recipe_r_ingredients`
  ADD KEY `recipe_foreign_key2` (`recipe_ID`);

--
-- Indexes for table `steps`
--
ALTER TABLE `steps`
  ADD PRIMARY KEY (`order_number`,`recipe_ID`),
  ADD KEY `recipe_foreign_key` (`recipe_ID`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_ID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `category_ID` tinyint(4) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `ingredients`
--
ALTER TABLE `ingredients`
  MODIFY `ingredients_ID` tinyint(3) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- AUTO_INCREMENT for table `recipes`
--
ALTER TABLE `recipes`
  MODIFY `recipe_ID` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_ID` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `favorites`
--
ALTER TABLE `favorites`
  ADD CONSTRAINT `recipe_ID` FOREIGN KEY (`recipe_ID`) REFERENCES `recipes` (`recipe_ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `user_ID2` FOREIGN KEY (`user_ID`) REFERENCES `users` (`user_ID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `recipes`
--
ALTER TABLE `recipes`
  ADD CONSTRAINT `category_ID` FOREIGN KEY (`category_ID`) REFERENCES `category` (`category_ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `user_ID` FOREIGN KEY (`user_ID`) REFERENCES `users` (`user_ID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `recipe_r_ingredients`
--
ALTER TABLE `recipe_r_ingredients`
  ADD CONSTRAINT `recipe_foreign_key2` FOREIGN KEY (`recipe_ID`) REFERENCES `recipes` (`recipe_ID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `steps`
--
ALTER TABLE `steps`
  ADD CONSTRAINT `recipe_foreign_key` FOREIGN KEY (`recipe_ID`) REFERENCES `recipes` (`recipe_ID`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
