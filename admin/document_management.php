<?php
require_once '../settings/config.php';

// Function to get evidence items
function getEvidenceItems($conn)
{
    $sql = "SELECT e.id, e.case_id, cr.title AS case_title, u.name AS student_name, e.evidence_type, e.evidence_details, e.is_valid
            FROM evidence e
            JOIN case_register cr ON e.case_id = cr.id
            JOIN users u ON cr.student_id = u.id
            ORDER BY e.case_id ASC";
    $result = $conn->query($sql);
    return $result->fetch_all(MYSQLI_ASSOC);
}

// Function to add a new evidence item
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add_evidence'])) {
    $case_id = $_POST['case_id'];
    $evidence_type = $_POST['evidence_type'];
    $evidence_details = $_POST['evidence_details'];
    $is_valid = isset($_POST['is_valid']) ? 1 : 0;

    $sql = "INSERT INTO evidence (case_id, evidence_type, evidence_details, is_valid) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("issi", $case_id, $evidence_type, $evidence_details, $is_valid);
    $stmt->execute();

    // Redirect to avoid form resubmission
    header("Location: document_management.php");
    exit();
}

// Function to update an evidence item
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['edit_evidence'])) {
    $evidence_id = $_POST['evidence_id'];
    $evidence_type = $_POST['evidence_type'];
    $evidence_details = $_POST['evidence_details'];
    $is_valid = isset($_POST['is_valid']) ? 1 : 0;

    $sql = "UPDATE evidence SET evidence_type = ?, evidence_details = ?, is_valid = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssii", $evidence_type, $evidence_details, $is_valid, $evidence_id);
    $stmt->execute();

    // Redirect to avoid form resubmission
    header("Location: document_management.php");
    exit();
}

// Function to delete an evidence item
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['delete_evidence'])) {
    $evidence_id = $_POST['evidence_id'];

    $sql = "DELETE FROM evidence WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $evidence_id);
    $stmt->execute();

    // Redirect to avoid form resubmission
    header("Location: document_management.php");
    exit();
}

// Fetch evidence items
$evidence_items = getEvidenceItems($conn);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../CSS/bootstrap.min.css">
    <link rel="stylesheet" href="../CSS/styles.css"> <!-- Custom CSS for additional styling -->
    <title><?php echo SITE_NAME; ?> - Document Management</title>
</head>

<body>
    <div class="header d-flex justify-content-between align-items-center p-3 bg-white shadow-sm">
        <a href="dashboard.php">
            <img src="../Ashesilogo.png" alt="Ashesi Logo" class="logo">
        </a>

        <a href="../login/login.php" class="btn btn-danger">Logout</a>
    </div>

    <div class="container mt-4">
        <h1 class="text-center text-danger">Document Management</h1>
        <button class="btn btn-primary mb-3" data-toggle="modal" data-target="#addEvidenceModal">Add New Evidence</button>

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Case Title</th>
                    <th>Student Name</th>
                    <th>Evidence Type</th>
                    <th>Evidence Details</th>
                    <th>Valid</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($evidence_items as $item) { ?>
                    <tr>
                        <td><?php echo htmlspecialchars($item['case_title']); ?></td>
                        <td><?php echo htmlspecialchars($item['student_name']); ?></td>
                        <td><?php echo htmlspecialchars($item['evidence_type']); ?></td>
                        <td><?php echo htmlspecialchars($item['evidence_details']); ?></td>
                        <td><?php echo $item['is_valid'] ? 'Yes' : 'No'; ?></td>
                        <td>
                            <button class="btn btn-warning btn-sm" data-toggle="modal" data-target="#editEvidenceModal<?php echo $item['id']; ?>">Edit</button>
                            <form method="POST" action="" style="display: inline-block;">
                                <input type="hidden" name="evidence_id" value="<?php echo $item['id']; ?>">
                                <button type="submit" name="delete_evidence" class="btn btn-danger btn-sm">Delete</button>
                            </form>
                        </td>
                    </tr>

                    <!-- Edit Evidence Modal -->
                    <div class="modal fade" id="editEvidenceModal<?php echo $item['id']; ?>" tabindex="-1" aria-labelledby="editEvidenceModalLabel<?php echo $item['id']; ?>" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="editEvidenceModalLabel<?php echo $item['id']; ?>">Edit Evidence</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <form method="POST" action="">
                                    <div class="modal-body">
                                        <input type="hidden" name="evidence_id" value="<?php echo $item['id']; ?>">
                                        <div class="form-group">
                                            <label for="evidence_type<?php echo $item['id']; ?>">Evidence Type</label>
                                            <input type="text" class="form-control" name="evidence_type" id="evidence_type<?php echo $item['id']; ?>" value="<?php echo htmlspecialchars($item['evidence_type']); ?>" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="evidence_details<?php echo $item['id']; ?>">Evidence Details</label>
                                            <textarea class="form-control" name="evidence_details" id="evidence_details<?php echo $item['id']; ?>" required><?php echo htmlspecialchars($item['evidence_details']); ?></textarea>
                                        </div>
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input" name="is_valid" id="is_valid<?php echo $item['id']; ?>" <?php echo $item['is_valid'] ? 'checked' : ''; ?>>
                                            <label class="form-check-label" for="is_valid<?php echo $item['id']; ?>">Valid</label>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                        <button type="submit" name="edit_evidence" class="btn btn-primary">Save changes</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            </tbody>
        </table>
    </div>

    <!-- Add Evidence Modal -->
    <div class="modal fade" id="addEvidenceModal" tabindex="-1" aria-labelledby="addEvidenceModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addEvidenceModalLabel">Add New Evidence</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form method="POST" action="">
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="case_id">Case</label>
                            <select class="form-control" name="case_id" id="case_id" required>
                                <?php
                                $cases = $conn->query("SELECT cr.id, cr.title, u.name AS student_name FROM case_register cr JOIN users u ON cr.student_id = u.id");
                                while ($case = $cases->fetch_assoc()) {
                                    echo '<option value="' . $case['id'] . '">' . htmlspecialchars($case['title']) . ' (' . htmlspecialchars($case['student_name']) . ')</option>';
                                }
                                ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="evidence_type">Evidence Type</label>
                            <input type="text" class="form-control" name="evidence_type" id="evidence_type" required>
                        </div>
                        <div class="form-group">
                            <label for="evidence_details">Evidence Details</label>
                            <textarea class="form-control" name="evidence_details" id="evidence_details" required></textarea>
                        </div>
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" name="is_valid" id="is_valid">
                            <label class="form-check-label" for="is_valid">Valid</label>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" name="add_evidence" class="btn btn-primary">Add Evidence</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
</body>

</html>