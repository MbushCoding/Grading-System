<?php
session_start();
if (!isset($_SESSION['currentUser'])) {
    header("Location: login.php");
}
if (isset($_GET['studentId'])) {
    require_once("db/DBConnection.php");
    $sql = "DELETE FROM student where id=\"" . $_GET['studentId'] . "\"";
    echo $sql;
    $conn = connectToDB();
    if ($conn->query($sql) === TRUE) {
        $_SESSION['dismissStudent'] = 1;
    } else {
        $_SESSION['dismissStudent'] = -1;
    }
//    echo $_SESSION['dismissStudent'];
    header('Location: studentAttendance.php');
}