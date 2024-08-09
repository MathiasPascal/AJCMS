<?php
require_once '../settings/config.php';

// Function to get cases and their stages
function getCasesAndStages($conn)
{
    $sql = "SELECT cr.id, cr.title, cr.case_no, u.name as student_name, ct.case_type, cs.name as case_stage, cr.verdict
            FROM case_register cr
            JOIN users u ON cr.student_id = u.id
            JOIN case_types ct ON cr.case_type_id = ct.id
            JOIN case_stage cs ON cr.case_stage_id = cs.id
            ORDER BY cr.filling_date DESC";
    $result = $conn->query($sql);
    return $result->fetch_all(MYSQLI_ASSOC);
}

// Function to get votes for a case
function getVotesForCase($conn, $case_id)
{
    $sql = "SELECT vote, COUNT(*) as vote_count
            FROM case_votes
            WHERE case_id = ?
            GROUP BY vote";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $case_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $votes = [];
    while ($row = $result->fetch_assoc()) {
        $votes[$row['vote']] = $row['vote_count'];
    }
    return $votes;
}

// Function to get vote count for a specific case and vote type
function getVoteCount($conn, $case_id, $vote)
{
    $sql = "SELECT COUNT(*) as vote_count FROM case_votes WHERE case_id = ? AND vote = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("is", $case_id, $vote);
    $stmt->execute();
    $vote_count = null;
    $stmt->bind_result($vote_count);
    $stmt->fetch();
    $stmt->close();
    return $vote_count;
}

// Function to update case verdict based on majority vote
function updateCaseVerdict($conn, $case_id)
{
    $votes = getVotesForCase($conn, $case_id);
    $vote_counts = ['Guilty' => 0, 'Not Guilty' => 0];

    foreach ($votes as $vote => $count) {
        $vote_counts[$vote] = $count;
    }

    if ($vote_counts['Guilty'] >= 5 && $vote_counts['Guilty'] > $vote_counts['Not Guilty']) {
        $verdict = 'Guilty';
    } elseif ($vote_counts['Not Guilty'] >= 5 && $vote_counts['Not Guilty'] > $vote_counts['Guilty']) {
        $verdict = 'Not Guilty';
    } else {
        $verdict = 'Pending'; // If there are not enough votes or there's a tie
    }

    $sql = "UPDATE case_register SET verdict = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("si", $verdict, $case_id);
    $stmt->execute();
}

// Fetch cases and their stages
$cases = getCasesAndStages($conn);

// Update verdicts for cases that have been voted on
foreach ($cases as $case) {
    updateCaseVerdict($conn, $case['id']);
}

// Fetch updated cases with stages and verdicts
$updated_cases = getCasesAndStages($conn);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/styles.css">
    <title><?php echo SITE_NAME; ?> - Case Management</title>
</head>

<body>
    <div class="header d-flex justify-content-between align-items-center p-2 bg-white shadow-sm">
        <a href="dashboard.php">
            <img src="../Ashesilogo.png" alt="Ashesi Logo" class="logo">
        </a>

        <a href="logout.php" class="btn btn-danger">Logout</a>
    </div>
    <div class="container mt-4">
        <h1 class="text-center text-danger">Case Management</h1>
        <div class="row">
            <?php foreach ($updated_cases as $case) { ?>
                <div class="col-md-4 col-sm-6 mb-4">
                    <div class="card text-center <?php echo $case['verdict'] == 'Guilty' ? 'bg-danger' : ($case['verdict'] == 'Not Guilty' ? 'bg-success' : 'bg-secondary'); ?> text-white">
                        <div class="card-body">
                            <h5 class="card-title"><?php echo $case['title']; ?></h5>
                            <p class="card-text">Case No: <?php echo $case['case_no']; ?></p>
                            <p class="card-text">Student: <?php echo $case['student_name']; ?></p>
                            <p class="card-text">Type: <?php echo $case['case_type']; ?></p>
                            <p class="card-text">Stage: <?php echo $case['case_stage']; ?></p>
                            <p class="card-text">Verdict: <?php echo $case['verdict']; ?></p>
                            <p class="card-text">Guilty Votes: <?php echo getVoteCount($conn, $case['id'], 'Guilty'); ?></p>
                            <p class="card-text">Not Guilty Votes: <?php echo getVoteCount($conn, $case['id'], 'Not Guilty'); ?></p>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>
</body>

</html>