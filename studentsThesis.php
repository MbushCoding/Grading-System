<?php
session_start();
if (!isset($_SESSION['currentUser'])) {
    header("Location: login.php");
}
require('classes/Teacher.php');
require_once('classes/Course.php');
require_once('classes/Student.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Students thesis</title>
    <link rel="stylesheet" href="css/collapsable.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
</head>
<body>
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
                <ul class="collapse list-unstyled" id="homeSubmenu">
                    <li><a href="addStudent.php">Add student</a></li>
                    <li><a href="studentAttendance.php">Student attendance</a></li>
                    <li><a href="grades.php">Grades</a></li>
                </ul>
            </li>
            <li class="active">
                <a href="studentsThesis.php">
                    <i class="glyphicon glyphicon-link"></i>
                    <b>Students thesis</b>
                </a>
            </li>
        </ul>
    </nav>

    <!-- Page Content Holder -->
    <div id="content">
        <nav class="navbar navbar-default">
            <div class="container-fluid">
                <div class="navbar-header" id="navbar-header">
                    <button type="button" id="sidebarCollapse" class="btn btn-info navbar-btn">
                        <i class="glyphicon glyphicon-align-left"></i>
                        <span>Toggle Sidebar</span>
                    </button>
                    <a href="logout.php">
                        <button type="button" class="btn btn-info navbar-btn" id="log-out-button">Log out</button>
                    </a>
                </div>
            </div>
        </nav>
        <h2>Students thesis</h2>
        <div class="line"></div>
        <?php
        $teacher = unserialize($_SESSION['currentUser']);
        $courses = $teacher->getCourses();
        foreach ($courses as $courseName) {
            $course = new Course();
            $course->setCourseName($courseName);
            $academicYear = '2018-2019';
            $students = unserialize($course->getEnrolledStudentsForAcademicYear($academicYear));
            if (-1 == $students) {
                ?>
                <h1>No student enrolled @ <?php echo $courseName . " " . $academicYear ?></h1>
            <?php } else {
                ?>
                <h1>Students enrolled @ <?php echo $courseName . " " . $academicYear ?></h1>
                <table class="table">
                    <thead class="thead-dark">
                    <tr>
                        <th scope="col">Student ID</th>
                        <th scope="col">First name</th>
                        <th scope="col">Last name</th>
                        <th scope="col">Email</th>
                        <th scope="col">Class</th>
                        <th scope="col">Thesis</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?
                    foreach ($students as $serializedStudent) {
                        $student = (unserialize($serializedStudent));
                        ?>
                        <tr>
                            <?php
                            echo "<th scope=\"row\">" . $student->getId() . "</th>";
                            echo "<td>" . $student->getFirstName() . "</td>";
                            echo "<td>" . $student->getLastName() . "</td>";
                            echo "<td>" . $student->getEmail() . "</td>";
                            echo "<td>" . $student->getClass() . "</td>";
                            echo "<td>" . $student->getThesisTitle() . "</td>";
                            ?>
                        </tr>
                    <?php } ?>
                    </tbody>
                </table>
            <?php } ?>
        <?php }
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
