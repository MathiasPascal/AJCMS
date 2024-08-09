<?php
require_once '../settings/config.php';

// Function to get complaints
function getComplaints($conn)
{
    $sql = "SELECT c.title, c.description, c.filing_date, u.name AS student_name
            FROM complaints c
            JOIN users u ON c.user_id = u.id
            ORDER BY c.filing_date DESC";
    $result = $conn->query($sql);
    return $result->fetch_all(MYSQLI_ASSOC);
}

$complaints = getComplaints($conn);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../CSS/bootstrap.min.css">
    <link rel="stylesheet" href="../CSS/styles.css"> <!-- Custom CSS for additional styling -->
    <title><?php echo SITE_NAME; ?> - Complaints</title>
</head>

<body>
    <div class="header d-flex justify-content-between align-items-center p-3 bg-white shadow-sm">
        <a href="dashboard.php">
            <img src="../Ashesilogo.png" alt="Ashesi Logo" class="logo">
        </a>

        <a href="../login/login.php" class="btn btn-danger">Logout</a>
    </div>

    <div class="container mt-4">
        <h1 class="text-center text-danger">Complaints</h1>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Complaint Title</th>
                    <th>Description</th>
                    <th>Filing Date</th>
                    <th>Student Name</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($complaints as $complaint) { ?>
                    <tr>
                        <td><?php echo htmlspecialchars($complaint['title']); ?></td>
                        <td><?php echo htmlspecialchars($complaint['description']); ?></td>
                        <td><?php echo htmlspecialchars($complaint['filing_date']); ?></td>
                        <td><?php echo htmlspecialchars($complaint['student_name']); ?></td>
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