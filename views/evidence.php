<?php
require_once '../settings/config.php';

// Function to get evidence for cases
function getEvidenceForCases($conn)
{
    $sql = "SELECT cr.title, e.evidence_type, e.evidence_details, e.is_valid
            FROM evidence e
            JOIN case_register cr ON e.case_id = cr.id
            ORDER BY cr.filling_date DESC";
    $result = $conn->query($sql);
    return $result->fetch_all(MYSQLI_ASSOC);
}

$evidence = getEvidenceForCases($conn);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/styles.css"> <!-- Custom CSS for additional styling -->
    <title><?php echo SITE_NAME; ?> - Case Evidence</title>
</head>

<body>
    <div class="header d-flex justify-content-between align-items-center p-3 bg-white shadow-sm">
        <a href="dashboard.php">
            <img src="../Ashesilogo.png" alt="Ashesi Logo" class="logo">
        </a>

        <a href="../login/login.php" class="btn btn-danger">Logout</a>
    </div>

    <div class="container mt-4">
        <h1 class="text-center text-danger">Evidence Center</h1>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Case Title</th>
                    <th>Evidence Type</th>
                    <th>Evidence Details</th>
                    <th>Validity</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($evidence as $item) { ?>
                    <tr>
                        <td><?php echo htmlspecialchars($item['title']); ?></td>
                        <td><?php echo htmlspecialchars($item['evidence_type']); ?></td>
                        <td><?php echo htmlspecialchars($item['evidence_details']); ?></td>
                        <td><?php echo $item['is_valid'] ? 'Valid' : 'Invalid'; ?></td>
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