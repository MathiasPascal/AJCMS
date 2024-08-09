<?php
require_once '../settings/config.php';

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch all roles
$sql = "SELECT id, role_name FROM roles";
$result = $conn->query($sql);

$roles = array();
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $roles[] = $row;
    }
} else {
    echo "0 results";
}

$conn->close();
?>