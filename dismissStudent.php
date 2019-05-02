<?php
session_start();
if (!isset($_SESSION['currentUser'])) {
    header("Location: login.php");
}
if (isset($_GET['studentId'])) {
//    delete it from db
    require_once ("db/DBConnection.php");
    $sql = "DELETE FROM student where id=\"" . $_GET['studentId'] . "\"";
    echo $sql;
    $conn = connectToDB();
    if ($conn->query($sql) === TRUE) {
        header('Location: studentAttendance.php');
    } else {
//        set a global flag for display an error message
        echo "An error occurred";
    }
}