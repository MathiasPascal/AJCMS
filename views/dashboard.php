<?php
require_once '../settings/config.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/styles.css"> <!-- Custom CSS for additional styling -->
    <title><?php echo SITE_NAME; ?> - Dashboard</title>
</head>

<body>
    <div class="header d-flex justify-content-between align-items-center p-3 bg-white shadow-sm">
        <img src="../Ashesilogo.png" alt="Ashesi Logo" class="logo">
    </div>

    <div class="container mt-4">
        <h1 class="text-center text-danger">Welcome to the AJCMS Student and Faculty Dashboard</h1>
        <p class="text-center text-danger">... you deserve transparency</p>

        <div class="row">
            <div class="col-md-3 col-sm-6 mb-4">
                <a href="cases.php" class="card-link">
                    <div class="card bg-success text-white text-center">
                        <div class="card-body">
                            <i class="fas fa-briefcase fa-2x"></i>
                            <h5 class="card-title mt-2">CASES</h5>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-md-3 col-sm-6 mb-4">
                <a href="evidence.php" class="card-link">
                    <div class="card bg-warning text-white text-center">
                        <div class="card-body">
                            <i class="fas fa-file-alt fa-2x"></i>
                            <h5 class="card-title mt-2">EVIDENCE</h5>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-md-3 col-sm-6 mb-4">
                <a href="student_handbook.php" class="card-link">
                    <div class="card bg-secondary text-white text-center">
                        <div class="card-body">
                            <i class="fas fa-book fa-2x"></i>
                            <h5 class="card-title mt-2">HANDBOOK</h5>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-md-3 col-sm-6 mb-4">
                <a href="about.php" class="card-link">
                    <div class="card bg-info text-white text-center">
                        <div class="card-body">
                            <i class="fas fa-info-circle fa-2x"></i>
                            <h5 class="card-title mt-2">ABOUT</h5>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-md-3 col-sm-6 mb-4">
                <a href="file_complaint.php" class="card-link">
                    <div class="card bg-primary text-white text-center">
                        <div class="card-body">
                            <i class="fas fa-edit fa-2x"></i>
                            <h5 class="card-title mt-2">FILE COMPLAINT</h5>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-md-3 col-sm-6 mb-4">
                <a href="../login/login.php" class="card-link">
                    <div class="card bg-danger text-white text-center">
                        <div class="card-body">
                            <i class="fas fa-sign-out-alt fa-2x"></i>
                            <h5 class="card-title mt-2">LOGOUT</h5>
                        </div>
                    </div>
                </a>
            </div>
            <!-- Add more grid items as needed -->
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/js/all.min.js"></script>
</body>

</html>
