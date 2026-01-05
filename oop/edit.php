<?php
session_start();
require 'config/Database.php';
require 'classes/Student.php';

$db = (new Database())->connect();
$studentObj = new Student($db);

$id = $_GET['id'];
$student = $studentObj->getStudentById($id);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $studentObj->updateStudent(
            $id,
            $_POST['name'],
            $_POST['email'],
            $_POST['course'],
            $_POST['phone'],
            $_POST['enrollment_date']
    );

    $_SESSION['success_msg'] = "Student updated successfully!";
    header("Location: index.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Student</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<h2 class="text-center my-4">Edit Student</h2>

<form method="post" class="w-50 mx-auto">
    <input class="form-control mb-2" name="name" value="<?= $student['name']; ?>" required>
    <input class="form-control mb-2" name="email" value="<?= $student['email']; ?>" required>
    <input class="form-control mb-2" name="phone" value="<?= $student['phone']; ?>" required>
    <input class="form-control mb-2" name="course" value="<?= $student['course']; ?>" required>
    <input class="form-control mb-3" type="date" name="enrollment_date" value="<?= $student['enrollment_date']; ?>" required>

    <button class="btn btn-primary">Update Student</button>
    <a href="index.php" class="btn btn-secondary ms-2">Back</a>
</form>

</body>
</html>
