<?php
session_start();

require 'config/Database.php';
require 'classes/Student.php';

$db = (new Database())->connect();
$student = new Student($db);

if (isset($_GET['id'])) {
    $student->deleteStudent($_GET['id']);
    $_SESSION['success_msg'] = "Student deleted successfully!";
}

header("Location: index.php");
exit;
