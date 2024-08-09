<?php
require_once '../settings/config.php';

// Function to get the total number of cases
function getTotalCases($conn)
{
    $sql = "SELECT COUNT(*) as total_cases FROM case_register";
    $result = $conn->query($sql);
    return $result->fetch_assoc()['total_cases'];
}

// Function to get the number of guilty verdicts
function getGuiltyCases($conn)
{
    $sql = "SELECT COUNT(*) as guilty_cases FROM case_register WHERE verdict = 'Guilty'";
    $result = $conn->query($sql);
    return $result->fetch_assoc()['guilty_cases'];
}

// Function to get the number of not guilty verdicts
function getNotGuiltyCases($conn)
{
    $sql = "SELECT COUNT(*) as not_guilty_cases FROM case_register WHERE verdict = 'Not Guilty'";
    $result = $conn->query($sql);
    return $result->fetch_assoc()['not_guilty_cases'];
}

// Fetch data
$total_cases = getTotalCases($conn);
$guilty_cases = getGuiltyCases($conn);
$not_guilty_cases = getNotGuiltyCases($conn);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/styles.css"> <!-- Custom CSS for additional styling -->
    <title><?php echo SITE_NAME; ?> - Reports</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        .report-container {
            max-width: 800px;
            margin: auto;
            text-align: center;
        }

        .chart-container {
            position: relative;
            height: 400px;
        }

        .card-deck .card {
            margin-bottom: 20px;
        }
    </style>
</head>

<body>
    <div class="header d-flex justify-content-between align-items-center p-3 bg-white shadow-sm">
        <a href="dashboard.php">
            <img src="../Ashesilogo.png" alt="Ashesi Logo" class="logo">
        </a>

        <a href="../login/login.php" class="btn btn-danger">Logout</a>
    </div>

    <div class="container report-container mt-4">
        <h1 class="text-center text-danger">Case Reports</h1>
        <div class="card-deck">
            <div class="card text-white bg-primary">
                <div class="card-body">
                    <h5 class="card-title">Total Cases Registered</h5>
                    <p class="card-text"><?php echo $total_cases; ?></p>
                </div>
            </div>
            <div class="card text-white bg-danger">
                <div class="card-body">
                    <h5 class="card-title">Guilty Verdicts</h5>
                    <p class="card-text"><?php echo $guilty_cases; ?></p>
                </div>
            </div>
            <div class="card text-white bg-success">
                <div class="card-body">
                    <h5 class="card-title">Not Guilty Verdicts</h5>
                    <p class="card-text"><?php echo $not_guilty_cases; ?></p>
                </div>
            </div>
        </div>

        <div class="chart-container mt-4">
            <canvas id="verdictChart"></canvas>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const ctx = document.getElementById('verdictChart').getContext('2d');
            const data = {
                labels: ['Guilty', 'Not Guilty'],
                datasets: [{
                    label: 'Number of Cases',
                    data: [<?php echo $guilty_cases; ?>, <?php echo $not_guilty_cases; ?>],
                    backgroundColor: ['rgba(255, 99, 132, 0.2)', 'rgba(54, 162, 235, 0.2)'],
                    borderColor: ['rgba(255, 99, 132, 1)', 'rgba(54, 162, 235, 1)'],
                    borderWidth: 1
                }]
            };

            const config = {
                type: 'bar',
                data: data,
                options: {
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            };

            const verdictChart = new Chart(ctx, config);
        });
    </script>
</body>

</html>