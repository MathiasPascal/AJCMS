<?php
require_once '../settings/config.php';

// Function to get the list of cases with their verdicts
function getCasesWithVerdicts($conn)
{
    $sql = "SELECT id, title, case_no, verdict FROM case_register";
    $result = $conn->query($sql);
    return $result->fetch_all(MYSQLI_ASSOC);
}

// Fetch cases with verdicts
$cases_with_verdicts = getCasesWithVerdicts($conn);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/styles.css">
    <title><?php echo SITE_NAME; ?> - Voting Results</title>
</head>

<body>
    <div class="header d-flex justify-content-between align-items-center p-2 bg-white shadow-sm">
        <a href="dashboard.php">
            <img src="../Ashesilogo.png" alt="Ashesi Logo" class="logo">
        </a>

        <a href="../login/login.php" class="btn btn-danger">Logout</a>
    </div>
    <div class="container mt-4">
        <h1 class="text-center text-danger">Voting Results</h1>
        <div class="row">
            <?php foreach ($cases_with_verdicts as $case) { ?>
                <div class="col-md-4 col-sm-6 mb-4">
                    <div class="card <?php echo $case['verdict'] == 'Guilty' ? 'bg-danger' : ($case['verdict'] == 'Not Guilty' ? 'bg-success' : 'bg-secondary'); ?> text-white text-center">
                        <div class="card-body">
                            <h5 class="card-title"><?php echo $case['title']; ?></h5>
                            <p class="card-text">Case No: <?php echo $case['case_no']; ?></p>
                            <p class="card-text">Verdict: <?php echo $case['verdict']; ?></p>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>
</body>

</html>