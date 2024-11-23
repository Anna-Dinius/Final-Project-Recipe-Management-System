<?php 

#This file is strictly for organizing the queries being used and where. Can change to a class if you want.
#These are meant to be put into prepare statements. Associative arrays are used in the execute statements.

#sql statements for create.php
$sql = "SELECT category_ID FROM category WHERE category_name = :category";
$sql = "INSERT INTO recipes VALUES(:ID, :user_ID, :recipe_name, :category_ID, :prep_time_minutes, :prep_time_hours, :cook_time_minutes, :cook_time_hours, :servings, :image_file, 0)";
$sql = "INSERT INTO ingredients VALUES(:ID, :recipe_ID, :ingredient)";
$sql = "INSERT INTO steps VALUES(:order_number, :Recipe_ID, :step)";

#SQL statements for delete.php
$sql = "DELETE FROM recipe WHERE recipe_ID = :ID";

#SQL statements for edit.php

#Could just use Update on all attributes for the given row.

#SQL statements for signin and signup
$sql = "SELECT from users WHERE email = :email AND password = :user_password";
$sql = "INSERT INTO users VALUES(:ID, :user_name, :user_email, :user_password)";