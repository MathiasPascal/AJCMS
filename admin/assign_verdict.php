<?php
session_start();
require_once '../db/database.php';
require_once '../functions/auth.php';
require_once '../functions/cases.php';

$auth = new AuthController($pdo);

// Check if user is logged in and is an AJC member
if (!isset($_SESSION['user']) || $auth->getUserRole($_SESSION['user']['id']) !== 'ajc_member') {
    header('Location: ../login/login.php');
    exit();
}

$caseController = new CaseController($pdo);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $case_id = $_POST['case_id'];
    $verdict_id = $_POST['verdict'];
    $punishment_id = $_POST['punishment'];

    if ($caseController->assignVerdict($case_id, $verdict_id) && $caseController->assignPunishment($case_id, $punishment_id)) {
        header('Location: ../admin/dashboard.php');
    } else {
        echo "Failed to assign verdict and punishment.";
    }
}

$case_id = $_GET['id'];
$case = $caseController->getCaseById($case_id);
$verdicts = $caseController->getVerdicts();
$punishments = $caseController->getPunishments();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../CSS/styles.css">
    <title>Assign Verdict</title>
</head>
<body>
    <header>
        <h1>Assign Verdict and Punishment</h1>
    </header>

    <div class="container">
        <h2>Case: <?php echo htmlspecialchars($case['title']); ?></h2>
        <p><?php echo htmlspecialchars($case['description']); ?></p>

        <form method="POST">
            <input type="hidden" name="case_id" value="<?php echo $case_id; ?>">
            <label for="verdict">Verdict:</label>
            <select name="verdict" id="verdict">
                <?php foreach ($verdicts as $verdict): ?>
                    <option value="<?php echo $verdict['id']; ?>"><?php echo $verdict['description']; ?></option>
                <?php endforeach; ?>
            </select>
            
            <label for="punishment">Punishment:</label>
            <select name="punishment" id="punishment">
                <?php foreach ($punishments as $punishment): ?>
                    <option value="<?php echo $punishment['id']; ?>"><?php echo $punishment['description']; ?></option>
                <?php endforeach; ?>
            </select>
            
            <button type="submit">Assign</button>
        </form>
    </div>

    <footer>
        &copy; 2024 Ashesi Judicial Case Management System
    </footer>
</body>
</html>
