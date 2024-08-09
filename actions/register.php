<?php
session_start();
require_once '../settings/config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['username'];
    $email = $_POST['email'];
    $id_number = $_POST['id_number'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
    $role_id = $_POST['role_id'];
    $status = "active";

    // Validate role_id
    $stmt = $conn->prepare("SELECT id FROM roles WHERE id = ?");
    $stmt->bind_param("i", $role_id);
    $stmt->execute();
    $stmt->store_result();
    if ($stmt->num_rows == 0) {
        echo json_encode(['register' => 'fail', 'message' => 'Invalid role selected.']);
        exit();
    }

    // Check if ID number already exists
    $stmt = $conn->prepare("SELECT id FROM users WHERE id_number = ?");
    $stmt->bind_param("s", $id_number);
    $stmt->execute();
    $stmt->store_result();
    if ($stmt->num_rows > 0) {
        echo json_encode(['register' => 'fail', 'message' => 'ID number already exists.']);
        exit();
    }

    // Register the user
    $stmt = $conn->prepare("INSERT INTO users (name, email, id_number, password, role_id, status) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssis", $name, $email, $id_number, $password, $role_id, $status);
    if ($stmt->execute()) {
        echo json_encode(['register' => 'success', 'message' => 'Registration successful.']);
    } else {
        echo json_encode(['register' => 'fail', 'message' => 'Error: ' . $stmt->error]);
    }
} else {
    echo json_encode(['register' => 'fail', 'message' => 'Invalid request method.']);
}
?>
