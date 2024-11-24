<?php
$host = 'localhost';  // Hostname
$dbname = 'savorysagasdb';  // Replace with your database name
$username = 'root';  // Default username for XAMPP
$password = '';  // Default password for XAMPP (empty)
$options = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES => false,
];


try {
    $db = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password, $options);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // Enable exceptions
} catch (PDOException $e) {
    die("Could not connect to the database: " . $e->getMessage());
}
?>