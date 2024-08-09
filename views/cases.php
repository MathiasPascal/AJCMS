<?php
require_once '../settings/config.php';

// Function to get scheduled cases
function getScheduledCases($conn)
{
    $sql = "SELECT cr.title, cr.case_no, ct.case_type, cr.evidence_found, cr.description, cr.verdict
            FROM case_register cr
            JOIN case_types ct ON cr.case_type_id = ct.id
            ORDER BY cr.hearing_date DESC";
    $result = $conn->query($sql);
    return $result->fetch_all(MYSQLI_ASSOC);
}

$cases = getScheduledCases($conn);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../CSS/bootstrap.min.css">
    <link rel="stylesheet" href="../CSS/styles.css"> <!-- Custom CSS for additional styling -->
    <title><?php echo SITE_NAME; ?> - Scheduled Cases</title>
</head>

<body>
    <div class="header d-flex justify-content-between align-items-center p-3 bg-white shadow-sm">
        <a href="dashboard.php">
            <img src="../Ashesilogo.png" alt="Ashesi Logo" class="logo">
        </a>

        <a href="../login/login.php" class="btn btn-danger">Logout</a>
    </div>

    <div class="container mt-4">
        <h1 class="text-center text-danger"> Cases</h1>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Case Title</th>
                    <th>Case No</th>
                    <th>Case Type</th>
                    <th>Evidence Found</th>
                    <th>Description</th>
                    <th>Verdict</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($cases as $case) { ?>
                    <tr>
                        <td><?php echo htmlspecialchars($case['title']); ?></td>
                        <td><?php echo htmlspecialchars($case['case_no']); ?></td>
                        <td><?php echo htmlspecialchars($case['case_type']); ?></td>
                        <td><?php echo htmlspecialchars($case['evidence_found']); ?></td>
                        <td><?php echo htmlspecialchars($case['description']); ?></td>
                        <td><?php echo htmlspecialchars($case['verdict']); ?></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
</body>

</html>