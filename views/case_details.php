<?php
session_start();
require_once '../db/database.php';
require_once '../functions/auth.php';

$auth = new AuthController($pdo);

// Check if user is logged in
if (!isset($_SESSION['user'])) {
    header('Location: ../login/login.php');
    exit();
}

require_once '../functions/cases.php';
$caseController = new CaseController($pdo);

$case_id = $_GET['id'];
$case = $caseController->getCaseById($case_id);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/styles.css">
    <title>Case Details</title>
</head>
<body>
    <header>
        <h1>Case Details</h1>
    </header>

    <div class="container">
        <h2><?php echo htmlspecialchars($case['title']); ?></h2>
        <p><strong>Description:</strong> <?php echo htmlspecialchars($case['description']); ?></p>
        <p><strong>Status:</strong> <?php echo htmlspecialchars($case['status']); ?></p>
    </div>

    <footer>
        &copy; 2024 Ashesi Judicial Case Management System
    </footer>
</body>
</html>
