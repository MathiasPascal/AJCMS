<?php
require_once '../settings/config.php';

// Function to get the list of scheduled cases from the database
function getScheduledCases($conn)
{
    $sql = "SELECT cr.id, cr.title, cr.case_no, u.name as student_name, ct.case_type, cr.hearing_date
            FROM case_register cr
            JOIN users u ON cr.student_id = u.id
            JOIN case_types ct ON cr.case_type_id = ct.id
            ORDER BY cr.hearing_date DESC";
    $result = $conn->query($sql);
    return $result->fetch_all(MYSQLI_ASSOC);
}

// Fetch scheduled cases
$scheduled_cases = getScheduledCases($conn);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/styles.css">
    <title><?php echo SITE_NAME; ?> - Scheduled Cases</title>
</head>

<body>
    <div class="header d-flex justify-content-between align-items-center p-2 bg-white shadow-sm">
        <a href="dashboard.php">
            <img src="../Ashesilogo.png" alt="Ashesi Logo" class="logo">
        </a>

        <a href="../login/login.php" class="btn btn-danger">Logout</a>
    </div>
    <div class="container mt-4">
        <h1 class="text-center text-danger">Scheduled Cases</h1>
        <div class="row">
            <?php foreach ($scheduled_cases as $case) { ?>
                <div class="col-md-4 col-sm-6 mb-4">
                    <a href="case_details.php?id=<?php echo $case['id']; ?>" class="card-link">
                        <div class="card bg-primary text-white text-center">
                            <div class="card-body">
                                <h5 class="card-title"><?php echo $case['title']; ?></h5>
                                <p class="card-text">Case No: <?php echo $case['case_no']; ?></p>
                                <p class="card-text">Student: <?php echo $case['student_name']; ?></p>
                                <p class="card-text">Type: <?php echo $case['case_type']; ?></p>
                                <p class="card-text">Hearing Date: <?php echo $case['hearing_date']; ?></p>
                            </div>
                        </div>
                    </a>
                </div>
            <?php } ?>
        </div>
    </div>
</body>

</html>