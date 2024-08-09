<?php
require_once '../settings/config.php';

// Function to get case details from the database
function getCaseDetails($conn, $case_id)
{
    $sql = "SELECT cr.*, u.name as student_name, ct.case_type, cs.name as case_stage, la.act_name, p.punishment_type
            FROM case_register cr
            JOIN users u ON cr.student_id = u.id
            JOIN case_types ct ON cr.case_type_id = ct.id
            JOIN case_stage cs ON cr.case_stage_id = cs.id
            JOIN legal_acts la ON cr.legal_act_id = la.id
            LEFT JOIN punishments p ON cr.punishment_id = p.id
            WHERE cr.id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $case_id);
    $stmt->execute();
    return $stmt->get_result()->fetch_assoc();
}

$case_id = $_GET['id'];
$case_details = getCaseDetails($conn, $case_id);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/styles.css">
    <title><?php echo SITE_NAME; ?> - Case Details</title>
</head>

<body>
    <div class="header d-flex justify-content-between align-items-center p-2 bg-white shadow-sm">
        <a href="dashboard.php">
            <img src="../Ashesilogo.png" alt="Ashesi Logo" class="logo">
        </a>

        <a href="../login/login.php" class="btn btn-danger">Logout</a>
    </div>
    <div class="container mt-4">
        <h1 class="text-center text-danger">Case Details</h1>
        <div class="card">
            <div class="card-body">
                <h5 class="card-title"><?php echo $case_details['title']; ?></h5>
                <p class="card-text"><strong>Case Number:</strong> <?php echo $case_details['case_no']; ?></p>
                <p class="card-text"><strong>Student:</strong> <?php echo $case_details['student_name']; ?></p>
                <p class="card-text"><strong>Case Type:</strong> <?php echo $case_details['case_type']; ?></p>
                <p class="card-text"><strong>Case Stage:</strong> <?php echo $case_details['case_stage']; ?></p>
                <p class="card-text"><strong>Legal Act:</strong> <?php echo $case_details['act_name']; ?></p>
                <p class="card-text"><strong>Evidence Found:</strong> <?php echo $case_details['evidence_found']; ?></p>
                <p class="card-text"><strong>Description:</strong> <?php echo $case_details['description']; ?></p>
                <p class="card-text"><strong>Filling Date:</strong> <?php echo $case_details['filling_date']; ?></p>
                <p class="card-text"><strong>Hearing Date:</strong> <?php echo $case_details['hearing_date']; ?></p>
                <p class="card-text"><strong>Verdict:</strong> <?php echo $case_details['verdict']; ?></p>
                <?php if ($case_details['punishment_type']) { ?>
                    <p class="card-text"><strong>Punishment:</strong> <?php echo $case_details['punishment_type']; ?></p>
                <?php } ?>
            </div>
        </div>
    </div>
</body>

</html>