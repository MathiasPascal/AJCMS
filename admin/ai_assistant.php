<?php
require_once '../settings/config.php';

// Handle the form submission and call the AI model
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $complaint_description = $_POST['complaint_description'];
    $evidence_details = $_POST['evidence_details'];
    $text = $complaint_description . ' ' . $evidence_details;

    // Call the Python script to predict the verdict
    $command = escapeshellcmd("python3 predict_verdict.py '$text'");
    $output = shell_exec($command);
    $predicted_verdict = trim($output);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../CSS/bootstrap.min.css">
    <link rel="stylesheet" href="../CSS/styles.css">
    <title><?php echo SITE_NAME; ?> - AI Assistant</title>
</head>

<body>
    <div class="header d-flex justify-content-between align-items-center p-3 bg-white shadow-sm">
        <a href="dashboard.php">
            <img src="../Ashesilogo.png" alt="Ashesi Logo" class="logo">
        </a>
        <a href="../login/login.php" class="btn btn-danger">Logout</a>
    </div>
    <div class="container mt-4">
        <h1 class="text-center text-danger">AI Assistant</h1>
        <form method="POST" action="ai_assistant.php" class="mt-4">
            <div class="form-group">
                <label for="complaint-description">Complaint Description:</label>
                <textarea class="form-control" id="complaint-description" name="complaint_description" rows="4" required></textarea>
            </div>
            <div class="form-group">
                <label for="evidence-details">Evidence Details:</label>
                <textarea class="form-control" id="evidence-details" name="evidence_details" rows="4" required></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Predict Verdict</button>
        </form>

        <?php if (isset($predicted_verdict)) { ?>
            <div class="alert alert-info mt-4" role="alert">
                <strong>Predicted Verdict:</strong> <?php echo htmlspecialchars($predicted_verdict); ?>
            </div>
        <?php } ?>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
</body>

</html>
