<?php
require_once '../settings/config.php';
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['file_complaint'])) {
    $user_id = $_SESSION['user_id'];
    $complaint_title = $_POST['complaint_title'];
    $complaint_description = $_POST['complaint_description'];

    $sql = "INSERT INTO complaints (user_id, title, description, filing_date) VALUES (?, ?, ?, NOW())";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iss", $user_id, $complaint_title, $complaint_description);
    if ($stmt->execute()) {
        echo "<script>
            setTimeout(function() {
                Swal.fire({
                    title: 'Complaint Filed',
                    text: 'Your complaint has been successfully filed.',
                    icon: 'success'
                }).then(function() {
                    window.location = 'dashboard.php';
                });
            }, 100);
        </script>";
    } else {
        echo "<script>
            setTimeout(function() {
                Swal.fire({
                    title: 'Error',
                    text: 'There was an error filing your complaint. Please try again.',
                    icon: 'error'
                }).then(function() {
                    window.location = 'file_complaint.php';
                });
            }, 100);
        </script>";
    }
    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/styles.css"> <!-- Custom CSS for additional styling -->
    <title><?php echo SITE_NAME; ?> - File Complaint</title>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>

<body>
    <div class="header d-flex justify-content-between align-items-center p-3 bg-white shadow-sm">
        <a href="dashboard.php">
            <img src="../Ashesilogo.png" alt="Ashesi Logo" class="logo">
        </a>

        <a href="../login/login.php" class="btn btn-danger">Logout</a>
    </div>

    <div class="container mt-4">
        <h1 class="text-center text-danger">File a Complaint</h1>
        <form method="POST" action="">
            <div class="form-group">
                <label for="complaint_title">Complaint Title</label>
                <input type="text" class="form-control" id="complaint_title" name="complaint_title" required>
            </div>
            <div class="form-group">
                <label for="complaint_description">Complaint Description</label>
                <textarea class="form-control" id="complaint_description" name="complaint_description" required></textarea>
            </div>
            <button type="submit" name="file_complaint" class="btn btn-primary">File Complaint</button>
        </form>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
</body>

</html>