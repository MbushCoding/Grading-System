<?php
function connectToDB()
{
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "students_grading";
    $port="3307";
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
    $sql = "SELECT email, password FROM teacher";
    $conn = connectToDB();
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        // output data of each row
        while ($row = $result->fetch_assoc()) {
            if ($row["email"] == $email && $row["password"] == $password) {
                $_SESSION['email']=$_POST['email'];
                $conn->close();
                return 1;
            }
        }
    }
    $conn->close();
    return 0;
}