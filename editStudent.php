<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Student attendance</title>
    <link rel="stylesheet" href="css/collapsable.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
</head>
<body>
<?php
session_start();
if (!isset($_SESSION['currentUser'])) {
    header("Location: login.php");
}
require('classes/Teacher.php');
require_once('classes/Course.php');
require_once('classes/Student.php');
require_once('db/DBConnection.php');

if (isset($_POST['firstName'])) {
    $sql = "UPDATE student SET first_name=\"" . $_POST['firstName'] . "\""
        . ", last_name=\"" . $_POST['lastName'] . "\""
        . ", email=\"" . $_POST['email'] . "\""
        . ", class=\"" . $_POST['class'] . "\""
        . " WHERE id = \"" . $_POST['id'] . "\"";
    $conn = connectToDB();
    if ($conn->query($sql) === TRUE) {
        $_SESSION['updatedStudent'] = 1;
    } else {
        $_SESSION['updatedStudent'] = -1;
    }
    header('Location: studentAttendance.php');
}
?>
<div class="wrapper">
    <!-- Sidebar Holder -->
    <nav id="sidebar">
        <script type="text/javascript">
            if (localStorage.getItem('#sidebar') == 'active') {
                document.getElementById("sidebar").classList.add('active');
            }
        </script>
        <div class="sidebar-header">
            <h3>Teacher Dashboard</h3>
            <strong>TD</strong>
        </div>

        <ul class="list-unstyled components">
            <li>
                <a href="dashboard.php" aria-expanded="false">
                    <i class="glyphicon glyphicon-home"></i>
                    Home
                </a>
            </li>
            <li>
                <a href="#homeSubmenu" data-toggle="collapse" aria-expanded="false">
                    <i class="glyphicon glyphicon-briefcase"></i>
                    Grade book
                </a>
                <ul class="list-unstyled" id="homeSubmenu">
                    <li><a href="addStudent.php">Add student</a></li>
                    <li><a href="studentAttendance.php"><b>Student attendance</b></a></li>
                    <li><a href="#">Grades</a></li>
                </ul>
                <a href="#pageSubmenu" data-toggle="collapse" aria-expanded="false">
                    <i class="glyphicon glyphicon-duplicate"></i>
                    Reports
                </a>
                <ul class="collapse list-unstyled" id="pageSubmenu">
                    <li><a href="#">Schoolar situation</a></li>
                    <li><a href="#">Teaching activity</a></li>
                </ul>
            </li>
            <li>
                <a href="#">
                    <i class="glyphicon glyphicon-link"></i>
                    Students thesis
                </a>
            </li>
            <li>
                <a href="#">
                    <i class="glyphicon glyphicon-paperclip"></i>
                    Course files
                </a>
            </li>
            <li>
                <a href="#">
                    <i class="glyphicon glyphicon-send"></i>
                    Email access
                </a>
            </li>
        </ul>
    </nav>

    <!-- Page Content Holder -->
    <div id="content">
        <nav class="navbar navbar-default">
            <div class="container-fluid">
                <div class="navbar-header">
                    <button type="button" id="sidebarCollapse" class="btn btn-info navbar-btn">
                        <i class="glyphicon glyphicon-align-left"></i>
                        <span>Toggle Sidebar</span>
                    </button>
                </div>
                <!--                TODO: don't hide this on resize-->
                <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                    <ul class="nav navbar-nav navbar-right">
                        <li><a href="logout.php">Log out</a></li>
                    </ul>
                </div>

            </div>
        </nav>

        <h2>Collapsible Sidebar Using Bootstrap 3</h2>
        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et
            dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex
            ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat
            nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit
            anim id est laborum.</p>
        <div class="line"></div>
        <!--        Display student information-->
        <?php
        if (isset($_GET['studentId'])) {
            $student = new Student();
            $student->getStudentById($_GET['studentId']);
            if ($student !== -1) {
                ?>
                <table class="table">
                    <thead class="thead-dark">
                    <tr>
                        <!--                        <th scope="col">Student ID</th>-->
                        <th scope="col">First name</th>
                        <th scope="col">Last name</th>
                        <th scope="col">Email</th>
                        <th scope="col">Class</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>

                        <!--                        <td><input type="text" name="id" value="-->
                        <? //= $student->getId() ?><!--"></td>-->
                        <form method="POST" action="editStudent.php">
                            <td><input type="text" name="firstName" value="<?= $student->getFirstName() ?>"></td>
                            <td><input type="text" name="lastName" value="<?= $student->getLastName() ?>"></td>
                            <td><input type="text" name="email" value="<?= $student->getEmail() ?>"></td>
                            <td><input type="text" name="class" value="<?= $student->getClass() ?>"></td>
                            <td><input type="hidden" name="id" value="<?= $student->getId() ?>"></td>
                            <td>
                                <button type="submit" class="btn btn-success btn-md">Save</button>
                            </td>
                        </form>
                    </tr>
                    </tbody>
                </table>
                <?php
            } else {
                echo "An error occurred.";
            }
        }
        ?>
    </div>
</div>

<!-- jQuery CDN -->
<script src="https://code.jquery.com/jquery-1.12.0.min.js"></script>
<!-- Bootstrap Js CDN -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<script type="text/javascript">
    $(document).ready(function () {
        $('#sidebarCollapse').on('click', function () {
            $('#sidebar').toggleClass('active');
            if ('active' == document.getElementById("sidebar").classList[0]) {
                window.localStorage.setItem('#sidebar', 'active');
            } else {
                window.localStorage.setItem('#sidebar', 'inactive');
            }
        });
    });
</script>
</body>
</html>
