<?php
define('SITE_NAME', 'Ashesi Judicial Case Management System');
define('BASE_URL', 'http://localhost/ajcms/');

// Database configuration
define('DB_HOST', 'localhost');
define('DB_USER', 'root'); // Change this to your database username
define('DB_PASS', 'password'); // Change this to your database password
define('DB_NAME', 'ajcms');

// Create connection
$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>