<?php
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit;
}


require 'config/Database.php';
require 'classes/Student.php';

$db = (new Database())->connect();
$student = new Student($db);
$data = $student->getStudents();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Student List</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>

<a href="logout.php" class="btn btn-danger btn-sm position-absolute top-0 end-0 m-3">
    Logout
</a>

<!-- SUCCESS MESSAGE -->
<?php if (isset($_SESSION['success_msg'])): ?>
    <div class="alert alert-success text-center w-75 mx-auto mt-3">
        <?= $_SESSION['success_msg']; ?>
    </div>
<?php unset($_SESSION['success_msg']); endif; ?>

<h2 class="text-center my-4">Student List</h2>

<!-- SEARCH BAR -->
<div class="w-75 mx-auto mb-3">
    <input
        type="text"
        id="searchInput"
        class="form-control"
        placeholder="Search by any field"
        onkeyup="searchTable()"
    >
</div>

<!-- TABLE -->
<table id="studentTable" class="table table-bordered table-striped w-75 mx-auto">
<thead class="table-primary text-center">
<tr>
    <th>#</th>
    <th>Name</th>
    <th>Email</th>
    <th>Phone</th>
    <th>Course</th>
    <th>Enrollment Date</th>
    <th>Action</th>
</tr>
</thead>

<tbody>
<?php $i = 1; foreach ($data as $row): ?>
<tr>
    <td class="text-center"><?= $i++; ?></td>
    <td><?= htmlspecialchars($row['name']); ?></td>
    <td><?= htmlspecialchars($row['email']); ?></td>
    <td><?= htmlspecialchars($row['phone']); ?></td>
    <td><?= htmlspecialchars($row['course']); ?></td>
    <td class="text-center"><?= htmlspecialchars($row['enrollment_date']); ?></td>
    <td class="text-center">
        <a href="edit.php?id=<?= $row['id']; ?>" class="btn btn-primary btn-sm">
            Edit
        </a>

        <a href="javascript:void(0)"
           class="btn btn-danger btn-sm"
           data-bs-toggle="modal"
           data-bs-target="#deleteModal"
           onclick="setDeleteId(<?= $row['id']; ?>)">
            Delete
        </a>
    </td>
</tr>
<?php endforeach; ?>
</tbody>
</table>

<!-- ADD BUTTON -->
<div class="text-center my-4">
    <a href="add.php" class="btn btn-success">Add Student</a>
</div>

<!-- DELETE CONFIRM MODAL -->
<div class="modal fade" id="deleteModal" tabindex="-1">
<div class="modal-dialog modal-dialog-centered">
<div class="modal-content">

<div class="modal-header bg-danger text-white">
    <h5 class="modal-title">Confirm Delete</h5>
    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
</div>

<div class="modal-body text-center">
    ⚠️ Are you sure you want to delete this student?
</div>

<div class="modal-footer">
    <button class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
    <a id="confirmDeleteBtn" class="btn btn-danger">Yes, Delete</a>
</div>

</div>
</div>
</div>

<!-- SEARCH SCRIPT -->
<script>
function searchTable() {
    let input = document.getElementById("searchInput").value.toLowerCase();
    document.querySelectorAll("#studentTable tbody tr").forEach(row => {
        row.style.display = row.innerText.toLowerCase().includes(input) ? "" : "none";
    });
}
</script>

<!-- DELETE SCRIPT -->
<script>
function setDeleteId(id) {
    document.getElementById("confirmDeleteBtn").href = "delete.php?id=" + id;
}
</script>

<!-- BOOTSTRAP JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
