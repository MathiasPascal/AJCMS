<?php
require_once '../settings/config.php';
require '../vendor/autoload.php'; // Include the PHPMailer class

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Function to get students
function getStudents($conn)
{
    $sql = "SELECT id, id_number, name FROM users WHERE role_id = (SELECT id FROM roles WHERE role_name = 'student')";
    $result = $conn->query($sql);
    return $result->fetch_all(MYSQLI_ASSOC);
}

// Function to get student email by ID number
function getStudentEmailByIdNumber($conn, $id_number)
{
    $sql = "SELECT email FROM users WHERE id_number = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $id_number);
    $stmt->execute();
    $email = null;
    $stmt->bind_result($email);
    $stmt->fetch();
    $stmt->close();
    return $email;
}

// Function to send email notification using PHPMailer
function sendEmailNotification($to, $case_title, $hearing_date)
{
    $mail = new PHPMailer(true);

    try {
        // Server settings
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com'; // Replace with your SMTP server
        $mail->SMTPAuth   = true;
        $mail->Username   = 'pascal.mathias30@ashesi.edu.gh'; // Replace with your SMTP username
        $mail->Password   = 'leek vege xyof mszq'; // Replace with your SMTP password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port       = 587; // TCP port to connect to

        // Recipients
        $mail->setFrom('no-reply@ajcms.edu', 'AJCMS');
        $mail->addAddress($to); // Add recipient

        // Content
        $mail->isHTML(false); // Set email format to plain text
        $mail->Subject = "Subpoena for Case Hearing: $case_title";
        $mail->Body    = "Dear Student,\n\nYou are required to attend a hearing for the case titled '$case_title' on $hearing_date.\n\nPlease make sure to be present.\n\nBest regards,\nAJCMS";

        $mail->send();
        error_log("Email sent to $to");
        return true;
    } catch (Exception $e) {
        error_log("Message could not be sent. Mailer Error: {$mail->ErrorInfo}");
        return false;
    }
}

// Function to schedule a case
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['schedule_case'])) {
    $case_title = $_POST['case_title'];
    $case_no = $_POST['case_no'];
    $student_id_number = $_POST['student_id'];
    $case_type_id = $_POST['case_type_id'];
    $case_stage_id = $_POST['case_stage_id'];
    $legal_act_id = $_POST['legal_act_id'];
    $evidence_found = $_POST['evidence_found'];
    $description = $_POST['description'];
    $filling_date = $_POST['filling_date'];
    $hearing_date = $_POST['hearing_date'];
    $punishment_id = isset($_POST['punishment_id']) ? $_POST['punishment_id'] : null;

    // Get student ID using the id_number
    $sql = "SELECT id FROM users WHERE id_number = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $student_id_number);
    $stmt->execute();
    $stmt->bind_result($student_id);
    $stmt->fetch();
    $stmt->close();

    $sql = "INSERT INTO case_register (title, case_no, student_id, case_type_id, case_stage_id, legal_act_id, evidence_found, description, filling_date, hearing_date, punishment_id) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssiiiissssi", $case_title, $case_no, $student_id, $case_type_id, $case_stage_id, $legal_act_id, $evidence_found, $description, $filling_date, $hearing_date, $punishment_id);
    if ($stmt->execute()) {
        // Get student email
        $student_email = getStudentEmailByIdNumber($conn, $student_id_number);

        // Send email notification
        if (sendEmailNotification($student_email, $case_title, $hearing_date)) {
            echo "<script>
                setTimeout(function() {
                    Swal.fire({
                        title: 'Case Scheduled',
                        text: 'The case has been scheduled and an email notification has been sent to the student.',
                        icon: 'success'
                    }).then(function() {
                        window.location = 'schedules.php';
                    });
                }, 100);
            </script>";
        } else {
            echo "<script>
                setTimeout(function() {
                    Swal.fire({
                        title: 'Error',
                        text: 'The case was scheduled, but there was an error sending the email notification.',
                        icon: 'error'
                    }).then(function() {
                        window.location = 'schedules.php';
                    });
                }, 100);
            </script>";
        }
    } else {
        echo "<script>
            setTimeout(function() {
                Swal.fire({
                    title: 'Error',
                    text: 'There was an error scheduling the case. Please try again.',
                    icon: 'error'
                }).then(function() {
                    window.location = 'schedules.php';
                });
            }, 100);
        </script>";
    }
    $stmt->close();
}

// Fetch existing cases for display (optional)
function getExistingCases($conn)
{
    $sql = "SELECT cr.id, cr.title, cr.case_no, u.name as student_name, ct.case_type, cr.hearing_date
            FROM case_register cr
            JOIN users u ON cr.student_id = u.id
            JOIN case_types ct ON cr.case_type_id = ct.id
            ORDER BY cr.filling_date DESC";
    $result = $conn->query($sql);
    return $result->fetch_all(MYSQLI_ASSOC);
}

$students = getStudents($conn);
$cases = getExistingCases($conn);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/styles.css"> <!-- Custom CSS for additional styling -->
    <title><?php echo SITE_NAME; ?> - Schedules</title>
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
        <h1 class="text-center text-danger">Schedule a Case Hearing</h1>
        <form method="POST" action="">
            <div class="form-group">
                <label for="case_title">Case Title</label>
                <input type="text" class="form-control" id="case_title" name="case_title" required>
            </div>
            <div class="form-group">
                <label for="case_no">Case No</label>
                <input type="text" class="form-control" id="case_no" name="case_no" required>
            </div>
            <div class="form-group">
                <label for="student_id">Student ID</label>
                <select class="form-control" id="student_id" name="student_id" required>
                    <option value="">Select Student ID</option>
                    <?php foreach ($students as $student) { ?>
                        <option value="<?php echo $student['id_number']; ?>"><?php echo $student['id_number']; ?></option>
                    <?php } ?>
                </select>
            </div>
            <div class="form-group">
                <label for="student_name">Student Name</label>
                <input type="text" class="form-control" id="student_name" name="student_name" readonly>
            </div>
            <div class="form-group">
                <label for="case_type_id">Case Type</label>
                <select class="form-control" id="case_type_id" name="case_type_id" required>
                    <?php
                    $case_types = $conn->query("SELECT id, case_type FROM case_types");
                    while ($case_type = $case_types->fetch_assoc()) {
                        echo '<option value="' . $case_type['id'] . '">' . $case_type['case_type'] . '</option>';
                    }
                    ?>
                </select>
            </div>
            <div class="form-group">
                <label for="case_stage_id">Case Stage</label>
                <select class="form-control" id="case_stage_id" name="case_stage_id" required>
                    <?php
                    $case_stages = $conn->query("SELECT id, name FROM case_stage");
                    while ($case_stage = $case_stages->fetch_assoc()) {
                        echo '<option value="' . $case_stage['id'] . '">' . $case_stage['name'] . '</option>';
                    }
                    ?>
                </select>
            </div>
            <div class="form-group">
                <label for="legal_act_id">Legal Act</label>
                <select class="form-control" id="legal_act_id" name="legal_act_id" required>
                    <?php
                    $legal_acts = $conn->query("SELECT id, act_name FROM legal_acts");
                    while ($legal_act = $legal_acts->fetch_assoc()) {
                        echo '<option value="' . $legal_act['id'] . '">' . $legal_act['act_name'] . '</option>';
                    }
                    ?>
                </select>
            </div>
            <div class="form-group">
                <label for="evidence_found">Evidence Found</label>
                <textarea class="form-control" id="evidence_found" name="evidence_found" required></textarea>
            </div>
            <div class="form-group">
                <label for="description">Description</label>
                <textarea class="form-control" id="description" name="description" required></textarea>
            </div>
            <div class="form-group">
                <label for="filling_date">Filing Date</label>
                <input type="date" class="form-control" id="filling_date" name="filling_date" required>
            </div>
            <div class="form-group">
                <label for="hearing_date">Hearing Date</label>
                <input type="date" class="form-control" id="hearing_date" name="hearing_date" required>
            </div>
            <div class="form-group">
                <label for="punishment_id">Punishment (optional)</label>
                <select class="form-control" id="punishment_id" name="punishment_id">
                    <option value="">None</option>
                    <?php
                    $punishments = $conn->query("SELECT id, punishment_type FROM punishments");
                    while ($punishment = $punishments->fetch_assoc()) {
                        echo '<option value="' . $punishment['id'] . '">' . $punishment['punishment_type'] . '</option>';
                    }
                    ?>
                </select>
            </div>
            <button type="submit" name="schedule_case" class="btn btn-primary">Schedule Case</button>
        </form>

        <h2 class="text-center text-danger mt-5">Existing Cases</h2>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Case Title</th>
                    <th>Case No</th>
                    <th>Student Name</th>
                    <th>Case Type</th>
                    <th>Hearing Date</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($cases as $case) { ?>
                    <tr>
                        <td><?php echo htmlspecialchars($case['title']); ?></td>
                        <td><?php echo htmlspecialchars($case['case_no']); ?></td>
                        <td><?php echo htmlspecialchars($case['student_name']); ?></td>
                        <td><?php echo htmlspecialchars($case['case_type']); ?></td>
                        <td><?php echo htmlspecialchars($case['hearing_date']); ?></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>

    <script>
        $(document).ready(function() {
            $('#student_id').change(function() {
                var studentId = $(this).val();
                if (studentId) {
                    $.ajax({
                        url: 'get_student_name.php',
                        type: 'POST',
                        data: {
                            student_id: studentId
                        },
                        success: function(data) {
                            $('#student_name').val(data);
                        }
                    });
                } else {
                    $('#student_name').val('');
                }
            });
        });
    </script>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
</body>

</html>
