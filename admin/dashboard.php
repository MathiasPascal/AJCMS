<?php
require_once '../settings/config.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title><?php echo SITE_NAME; ?> - Dashboard</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/styles.css"> <!-- Custom CSS for additional styling -->
    <style>
        .bg-purple {
            background-color: #6f42c1; /* Bootstrap's purple color */
        }
        .bg-teal {
            background-color: #20c997; /* Bootstrap's teal color */
        }
    </style>
</head>

<body>
    <div class="header d-flex justify-content-between align-items-center p-3 bg-white shadow-sm">
        <a href="dashboard.php">
            <img src="../Ashesilogo.png" alt="Ashesi Logo" class="logo">
        </a>
    </div>

    <div class="container mt-4">
        <h1 class="text-center text-danger">Welcome to the AJCMS Dashboard</h1>
        <p class="text-center text-danger">... innocent until proven guilty</p>

        <div class="row">
            <!-- Existing Cards -->
            <div class="col-md-3 col-sm-6 mb-4">
                <a href="schedules.php" class="card-link">
                    <div class="card bg-primary text-white text-center">
                        <div class="card-body">
                            <i class="fas fa-calendar-alt fa-2x"></i>
                            <h5 class="card-title mt-2">SCHEDULES</h5>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-md-3 col-sm-6 mb-4">
                <a href="recording.php" class="card-link">
                    <div class="card bg-secondary text-white text-center">
                        <div class="card-body">
                            <i class="fas fa-microphone fa-2x"></i>
                            <h5 class="card-title mt-2">RECORDING</h5>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-md-3 col-sm-6 mb-4">
                <a href="vote.php" class="card-link">
                    <div class="card bg-success text-white text-center">
                        <div class="card-body">
                            <i class="fas fa-vote-yea fa-2x"></i>
                            <h5 class="card-title mt-2">VOTING</h5>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-md-3 col-sm-6 mb-4">
                <a href="case_management.php" class="card-link">
                    <div class="card bg-danger text-white text-center">
                        <div class="card-body">
                            <i class="fas fa-briefcase fa-2x"></i>
                            <h5 class="card-title mt-2">CASE MANAGEMENT</h5>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-md-3 col-sm-6 mb-4">
                <a href="reports.php" class="card-link">
                    <div class="card bg-warning text-white text-center">
                        <div class="card-body">
                            <i class="fas fa-chart-line fa-2x"></i>
                            <h5 class="card-title mt-2">REPORTS</h5>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-md-3 col-sm-6 mb-4">
                <a href="document_management.php" class="card-link">
                    <div class="card bg-info text-white text-center">
                        <div class="card-body">
                            <i class="fas fa-folder fa-2x"></i>
                            <h5 class="card-title mt-2">DOCUMENT MANAGEMENT</h5>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-md-3 col-sm-6 mb-4">
                <a href="chat.php" class="card-link">
                    <div class="card bg-dark text-white text-center">
                        <div class="card-body">
                            <i class="fas fa-comments fa-2x"></i>
                            <h5 class="card-title mt-2">CHAT</h5>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-md-3 col-sm-6 mb-4">
                <a href="complaints.php" class="card-link">
                    <div class="card text-white text-center" style="background-color: #20c997;">
                        <div class="card-body">
                            <i class="fas fa-exclamation-circle fa-2x"></i>
                            <h5 class="card-title mt-2">COMPLAINTS</h5>
                        </div>
                    </div>
                </a>
            </div>
            <!-- New AI Assistant Card with Background Color -->
            <div class="col-md-3 col-sm-6 mb-4">
                <a href="ai_assistant.php" class="card-link">
                    <div class="card text-white text-center" style="background-color: #6f42c1;">
                        <div class="card-body">
                            <i class="fas fa-robot fa-2x"></i>
                            <h5 class="card-title mt-2">AI ASSISTANT</h5>
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
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/js/all.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</body>

</html>
