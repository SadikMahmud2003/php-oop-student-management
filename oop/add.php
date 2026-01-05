<?php
session_start();
require 'config/Database.php';
require 'classes/Student.php';

$db = (new Database())->connect();
$student = new Student($db);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $student->addStudent(
            $_POST['name'],
            $_POST['email'],
            $_POST['course'],
            $_POST['phone'],
            $_POST['enrollment_date']
    );

    $_SESSION['success_msg'] = "Student added successfully!";
    header("Location: index.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add Student</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<h2 class="text-center my-4">Add Student</h2>

<form method="post" class="w-50 mx-auto">
    <input class="form-control mb-2" name="name" placeholder="Name" required>
    <input class="form-control mb-2" name="email" placeholder="Email" required>
    <input class="form-control mb-2" name="phone" placeholder="Phone" required>
    <input class="form-control mb-2" name="course" placeholder="Course" required>
    <input class="form-control mb-3" type="date" name="enrollment_date" required>

    <button class="btn btn-success">Add Student</button>
    <a href="index.php" class="btn btn-secondary ms-2">Back</a>
</form>

</body>
</html>
