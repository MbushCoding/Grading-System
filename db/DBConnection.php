<?php
require_once 'classes/Teacher.php';
function connectToDB()
{
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "students_grading";
    $port = "3307";
// Create connection
    $conn = new mysqli($servername, $username, $password, $dbname, $port);
// Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    return $conn;
}

function checkEmailAndPassword($email, $password)
{
    $sql = "SELECT * FROM teacher WHERE email=\"" . $email . "\" AND password=\"" . $password . "\"";
    $conn = connectToDB();
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        // output data of each row
        while ($row = $result->fetch_assoc()) {
            if ($row["email"] == $email && $row["password"] == $password) {
                //TODO: replace this with $_SESSION['currentUser']
                $_SESSION['email'] = $_POST['email'];
                $teacher = new Teacher($row['id'], $row['first_name'], $row['last_name'], $row['email']);
                $_SESSION['currentUser'] = serialize($teacher);
                $conn->close();
                return 1;
            }
        }
    }
    $conn->close();
    return 0;
}

function insertStudent($firstName, $lastName, $email, $class, $course)
{
    $sql = "INSERT INTO student VALUES (NULL,\"$firstName\", \"$lastName\", \"$email\", \"$class\")";
    $conn = connectToDB();
    if ($conn->query($sql) === TRUE) {
        $sql = "SELECT id FROM student WHERE email=\"" . $email . "\"";
        $result = $conn->query($sql);
        $studentId = -1;
        if ($result->num_rows > 0) {
            $studentId = $result->fetch_assoc()['id'];
        }
        $sql = "SELECT id FROM course WHERE course_name=\"" . $course . "\"";
        $result = $conn->query($sql);
        $courseId = -1;
        if ($result->num_rows > 0) {
            $courseId = $result->fetch_assoc()['id'];
        }
        if (-1 != $studentId && -1 != $courseId) {
//            Insert into student2course -> Enroll student
            $sql = "INSERT INTO student2course VALUES(" . $studentId . ", " . $courseId . ", '2018-2019')";
            if ($conn->query($sql) === TRUE) {
                $conn->close();
                $_SESSION['addUserSuccessfully'] = 1;
                return;
            }
        }
    }
    //An error occurred
    $conn->close();
    $_SESSION['addUserSuccessfully'] = -1;
    return;
}