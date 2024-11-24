<?php
$host = 'localhost';  // Hostname
$dbname = 'savorysagadb';  // Replace with your database name
$username = 'root';  // Default username for XAMPP
$password = '';  // Default password for XAMPP (empty)

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // Enable exceptions
} catch (PDOException $e) {
    die("Could not connect to the database: " . $e->getMessage());
}
?>
