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
    <title><?php echo SITE_NAME; ?> - About</title>
</head>

<body>
    <div class="header d-flex justify-content-between align-items-center p-3 bg-white shadow-sm">
        <a href="dashboard.php">
            <img src="../Ashesilogo.png" alt="Ashesi Logo" class="logo">
        </a>

        <a href="../login/login.php" class="btn btn-danger">Logout</a>
    </div>

    <div class="container mt-4">
        <h1 class="text-center text-danger">About AJCMS</h1>
        <div class="row mt-4">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <h2 class="card-title text-center">Welcome to the Ashesi Judicial Case Management System (AJCMS)</h2>
                        <p class="card-text mt-4">At Ashesi University, we believe in upholding the highest standards of integrity, fairness, and transparency. The Ashesi Judicial Case Management System (AJCMS) is a testament to these values, designed to streamline and enhance the process of managing judicial cases within our community.</p>

                        <h4 class="card-title mt-4">Purpose of AJCMS</h4>
                        <p class="card-text">The primary purpose of AJCMS is to provide a comprehensive and transparent platform for managing all judicial cases related to academic and social misconduct. This system is tailored to ensure that every case is handled with the utmost care, providing all stakeholders with the necessary tools to facilitate a fair and just process.</p>

                        <h4 class="card-title mt-4">Key Features and Benefits</h4>
                        <ul class="card-text">
                            <li><strong>Transparency:</strong> All case details, evidence, and verdicts are accessible to authorized users, ensuring a transparent process.</li>
                            <li><strong>Efficiency:</strong> Streamlined workflows and automated notifications keep the process moving smoothly and reduce delays.</li>
                            <li><strong>Accountability:</strong> Detailed logs and records maintain accountability for all actions taken during case proceedings.</li>
                            <li><strong>Accessibility:</strong> Students, faculty, and administrators can access the system from anywhere, providing flexibility and ease of use.</li>
                        </ul>

                        <h4 class="card-title mt-4">Our Commitment</h4>
                        <p class="card-text">We are committed to fostering an environment of trust and integrity. AJCMS is a critical part of this commitment, ensuring that all members of the Ashesi community are treated fairly and with respect throughout the judicial process.</p>

                        <h4 class="card-title mt-4">How AJCMS Works</h4>
                        <p class="card-text">The system allows students to file complaints, view cases, and access evidence. Faculty members can manage cases, submit evidence, and participate in hearings. The system also supports the voting process for case verdicts, ensuring that decisions are made collectively and fairly.</p>

                        <h4 class="card-title mt-4">Get Involved</h4>
                        <p class="card-text">Your participation is crucial to the success of AJCMS. Whether you're a student filing a complaint, a faculty member managing a case, or an administrator overseeing the process, your engagement helps us maintain the integrity and fairness of our community.</p>

                        <h4 class="card-title mt-4">Contact Us</h4>
                        <p class="card-text">If you have any questions or need assistance with AJCMS, please do not hesitate to contact us at <a href="mailto:support@ajcms.edu">support@ajcms.edu</a>.</p>

                        <div class="text-center mt-4">
                            <a href="dashboard.php" class="btn btn-primary">Return to Dashboard</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
</body>

</html>