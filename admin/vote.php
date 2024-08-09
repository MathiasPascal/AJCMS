<?php
session_start();
require_once '../settings/config.php';

// Check if the user is logged in and has a user_id set in the session
if (!isset($_SESSION['user_id'])) {
    die("User not logged in.");
}

$user_id = $_SESSION['user_id'];

// Fetch the cases for voting
function getCasesForVoting($conn)
{
    $sql = "SELECT cr.id, cr.title, cr.case_no, u.name as student_name, ct.case_type, cr.verdict
            FROM case_register cr
            JOIN users u ON cr.student_id = u.id
            JOIN case_types ct ON cr.case_type_id = ct.id
            WHERE cr.verdict = 'Pending'
            ORDER BY cr.filling_date DESC";
    $result = $conn->query($sql);
    return $result->fetch_all(MYSQLI_ASSOC);
}

// Check if the user has already voted on a case
function hasUserVoted($conn, $case_id, $user_id)
{
    $sql = "SELECT COUNT(*) FROM case_votes WHERE case_id = ? AND user_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $case_id, $user_id);
    $stmt->execute();
    $count = 0;
    $stmt->bind_result($count);
    $stmt->fetch();
    $stmt->close();
    return $count > 0;
}

// Submit a vote
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['vote'])) {
    $case_id = $_POST['case_id'];
    $vote = $_POST['vote'];

    if (!hasUserVoted($conn, $case_id, $user_id)) {
        $sql = "INSERT INTO case_votes (case_id, user_id, vote) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("iis", $case_id, $user_id, $vote);
        if ($stmt->execute()) {
            echo "<script>
                setTimeout(function() {
                    Swal.fire({
                        title: 'Vote Submitted',
                        text: 'Your vote has been successfully submitted.',
                        icon: 'success'
                    }).then(function() {
                        window.location = 'vote.php';
                    });
                }, 100);
            </script>";
        } else {
            echo "<script>
                setTimeout(function() {
                    Swal.fire({
                        title: 'Error',
                        text: 'There was an error submitting your vote. Please try again.',
                        icon: 'error'
                    }).then(function() {
                        window.location = 'vote.php';
                    });
                }, 100);
            </script>";
        }
    } else {
        echo "<script>
            setTimeout(function() {
                Swal.fire({
                    title: 'Already Voted',
                    text: 'You have already voted on this case.',
                    icon: 'info'
                }).then(function() {
                    window.location = 'vote.php';
                });
            }, 100);
        </script>";
    }
}

// Fetch cases for voting
$cases = getCasesForVoting($conn);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../CSS/bootstrap.min.css">
    <link rel="stylesheet" href="../CSS/styles.css"> <!-- Custom CSS for additional styling -->
    <title><?php echo SITE_NAME; ?> - Voting</title>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
</head>

<body>
    <div class="header d-flex justify-content-between align-items-center p-3 bg-white shadow-sm">
        <a href="dashboard.php">
            <img src="../Ashesilogo.png" alt="Ashesi Logo" class="logo">
        </a>

        <a href="../login/login.php" class="btn btn-danger">Logout</a>
    </div>

    <div class="container mt-4">
        <h1 class="text-center text-danger">Vote on Cases</h1>
        <div class="row">
            <?php foreach ($cases as $case) { ?>
                <div class="col-md-4 col-sm-6 mb-4">
                    <div class="card text-center bg-light">
                        <div class="card-body">
                            <h5 class="card-title"><?php echo $case['title']; ?></h5>
                            <p class="card-text">Case No: <?php echo $case['case_no']; ?></p>
                            <p class="card-text">Student: <?php echo $case['student_name']; ?></p>
                            <p class="card-text">Type: <?php echo $case['case_type']; ?></p>
                            <form method="POST" action="">
                                <input type="hidden" name="case_id" value="<?php echo $case['id']; ?>">
                                <button type="submit" name="vote" value="Guilty" class="btn btn-danger btn-block">Guilty</button>
                                <button type="submit" name="vote" value="Not Guilty" class="btn btn-success btn-block mt-2">Not Guilty</button>
                            </form>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
</body>

</html>