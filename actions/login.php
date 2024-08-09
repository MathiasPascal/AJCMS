<?php
session_start();
require_once '../settings/config.php';

// Check if form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Prepare the SQL statement to prevent SQL injection
    $stmt = $conn->prepare("SELECT users.id, users.name, users.password, roles.role_name as role FROM users JOIN roles ON users.role_id = roles.id WHERE users.email = ?");
    $stmt->bind_param("s", $email);

    // Execute the statement
    $stmt->execute();

    // Get the result
    $result = $stmt->get_result();

    // Check if a user was found
    if ($result->num_rows == 1) {
        $user = $result->fetch_assoc();

        // Verify the password
        if (password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_name'] = $user['name'];
            $_SESSION['role'] = $user['role'];

            echo json_encode(['login' => 'success', 'message' => 'Login successful.']);
        } else {
            echo json_encode(['login' => 'fail', 'message' => 'Invalid email or password.']);
        }
    } else {
        echo json_encode(['login' => 'fail', 'message' => 'Invalid email or password.']);
    }

    // Close the connection
    $stmt->close();
    $conn->close();
} else {
    echo json_encode(['login' => 'fail', 'message' => 'Invalid request method.']);
}
