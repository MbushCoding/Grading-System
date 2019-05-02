<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Student attendance</title>
    <link rel="stylesheet" href="css/collapsable.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="js/scripts.js"></script>
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
?>
<div class="wrapper">
    <!-- Sidebar Holder -->
    <nav id="sidebar">
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
                    <li><a href="#"><b>Student attendance</b></a></li>
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
                    Portfolio
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
        <!--        <ul class="list-unstyled CTAs">-->
        <!--            <li><a href="https://bootstrapious.com/tutorial/files/sidebar.zip" class="download">Download source</a></li>-->
        <!--            <li><a href="https://bootstrapious.com/p/bootstrap-sidebar" class="article">Back to article</a></li>-->
        <!--        </ul>-->
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
        <?php
        $teacher = unserialize($_SESSION['currentUser']);
        $courses = $teacher->getCourses();
        foreach ($courses

                 as $courseName) {
            $course = new Course();
            $course->setCourseName($courseName);
            ?>
            <h1>Students enrolled @ <?php echo $courseName ?></h1>
            <table class="table">
                <thead class="thead-dark">
                <tr>
                    <th scope="col">Student ID</th>
                    <th scope="col">First name</th>
                    <th scope="col">Last name</th>
                    <th scope="col">Email</th>
                    <th scope="col">Class</th>
                </tr>
                </thead>
                <tbody>
                <?
                $students = unserialize($course->getEnrolledStudents());
                foreach ($students as $student) {
                    $studObj = (unserialize($student));
                    $studID = $studObj->getId();
                    ?>
                    <tr>
                        <?php
                        echo "<th scope=\"row\" id=\"id$studID\">" . $studObj->getId() . "</th>";
                        echo "<td id=\"firstName$studID\">" . $studObj->getFirstName() . "</td>";
                        echo "<td id=\"lastName$studID\">" . $studObj->getLastName() . "</td>";
                        echo "<td id=\"email$studID\">" . $studObj->getEmail() . "</td>";
                        echo "<td id=\"class$studID\">" . $studObj->getClass() . "</td>";
                        ?>
                        <td>
                            <form method="GET" action="editStudent.php" class="editStudent">
                                <button type="submit" id="editStudent<?= $studObj->getId() ?>"
                                        class="btn btn-success btn-md">
                                    Edit
                                </button>
                                <input type="hidden" name="studentId" value="<?= $studObj->getId() ?>">
                            </form>
                            <form method="GET" action="dismissStudent.php" class="dismissStudent"
                                  id="dismissStudentForm<?= $studObj->getId() ?>">
                                <input type="hidden" name="studentId" value="<?= $studObj->getId() ?>">
                                <button type="button" class="btn btn-danger btn-md"
                                        onclick="addConfirmationPopup(<?= $studObj->getId() ?>)">
                                    Dismiss
                                </button>
                            </form>
                        </td>
                    </tr>
                <?php } ?>
                </tbody>
            </table>
        <?php } ?>
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
        });
    });
</script>
</body>
</html>

