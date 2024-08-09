<?php
require_once '../settings/config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['student_id'])) {
    $student_id_number = $_POST['student_id'];

    $sql = "SELECT name FROM users WHERE id_number = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $student_id_number);
    $stmt->execute();
    $stmt->bind_result($student_name);
    $stmt->fetch();
    $stmt->close();

    echo htmlspecialchars($student_name);
}
?>
