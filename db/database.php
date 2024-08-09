<?php
$host = 'localhost';
$dbname = 'ajcms';
$user = 'root';  // Default user for XAMPP
$password = '';  // Default password is empty for XAMPP

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $user, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Could not connect to the database $dbname :" . $e->getMessage());
}
?>
