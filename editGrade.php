<?php
session_start();
if (!isset($_SESSION['currentUser'])) {
    header("Location: login.php");
}
require_once('classes/Student.php');

if (isset($_GET['grade']) && isset($_GET['courseId']) && isset($_GET['academicYear']) && isset($_GET['studentId'])) {
    $student = new Student();
    $student->setId($_GET['studentId']);
    if (!$student->setGradeForCourse($_GET['courseId'], $_GET['grade'], $_GET['academicYear'])) {
//        TODO: set a global state of error or something else
    }
}
header("Location: grades.php");