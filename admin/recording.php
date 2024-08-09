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
    <title><?php echo SITE_NAME; ?> - Recordings</title>
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script> <!-- Font Awesome -->
</head>

<body>
    <div class="header d-flex justify-content-between align-items-center p-2 bg-white shadow-sm">
        <a href="dashboard.php">
            <img src="../Ashesilogo.png" alt="Ashesi Logo" class="logo">
        </a>

        <a href="../login/login.php" class="btn btn-danger">Logout</a>
    </div>

    <div class="container mt-4">
        <h1 class="text-center text-danger">Case Hearings Recordings</h1>
        <p class="text-center text-danger">Click on a hearing to watch the recording</p>

        <div class="row">
            <div class="col-md-4 col-sm-6 mb-4">
                <a href="https://www.youtube.com/watch?v=dQw4w9WgXcQ" target="_blank" class="card-link">
                    <div class="card bg-primary text-white text-center">
                        <div class="card-body">
                            <i class="fas fa-video fa-2x"></i>
                            <h5 class="card-title mt-2">Hearing 1: Osama Bin-Laden</h5>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-md-4 col-sm-6 mb-4">
                <a href="https://www.youtube.com/watch?v=3JZ_D3ELwOQ" target="_blank" class="card-link">
                    <div class="card bg-secondary text-white text-center">
                        <div class="card-body">
                            <i class="fas fa-video fa-2x"></i>
                            <h5 class="card-title mt-2">Hearing 2: Jane Smith</h5>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-md-4 col-sm-6 mb-4">
                <a href="https://www.youtube.com/watch?v=9bZkp7q19f0" target="_blank" class="card-link">
                    <div class="card bg-success text-white text-center">
                        <div class="card-body">
                            <i class="fas fa-video fa-2x"></i>
                            <h5 class="card-title mt-2">Hearing 3: Michael Brown</h5>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-md-4 col-sm-6 mb-4">
                <a href="https://www.youtube.com/watch?v=6n3pFFPSlW4" target="_blank" class="card-link">
                    <div class="card bg-danger text-white text-center">
                        <div class="card-body">
                            <i class="fas fa-video fa-2x"></i>
                            <h5 class="card-title mt-2">Hearing 4: Emily Davis</h5>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-md-4 col-sm-6 mb-4">
                <a href="https://www.youtube.com/watch?v=0R1-ZZTcTBY" target="_blank" class="card-link">
                    <div class="card bg-warning text-white text-center">
                        <div class="card-body">
                            <i class="fas fa-video fa-2x"></i>
                            <h5 class="card-title mt-2">Hearing 5: Chris Wilson</h5>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-md-4 col-sm-6 mb-4">
                <a href="https://www.youtube.com/watch?v=CevxZvSJLk8" target="_blank" class="card-link">
                    <div class="card bg-info text-white text-center">
                        <div class="card-body">
                            <i class="fas fa-video fa-2x"></i>
                            <h5 class="card-title mt-2">Hearing 6: Lisa Johnson</h5>
                        </div>
                    </div>
                </a>
            </div>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/js/all.min.js"></script>
</body>

</html>