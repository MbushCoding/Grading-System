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
                    <b>Grade book</b>
                </a>
                <ul class="list-unstyled" id="homeSubmenu">
                    <li><a href="addStudent.php">Add student</a></li>
                    <li><a href="studentAttendance.php"><b>Student attendance</b></a></li>
                    <li><a href="grades.php">Grades</a></li>
                </ul>
            </li>
            <li>
                <a href="studentsThesis.php">
                    <i class="glyphicon glyphicon-link"></i>
                    Students thesis
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
        <div id="successfully-edited-student" class="modal">
            <!-- Modal content -->
            <div class="modal-content">
                <span class="close">&times;</span>
                <p class="modal-text">Successfully edited student</p>
            </div>
        </div>
        <div id="unsuccessfully-edited-student" class="modal">
            <!-- Modal content -->
            <div class="modal-content">
                <span class="close">&times;</span>
                <p class="modal-text">Unsuccessfully edited student</p>
            </div>
        </div>
        <div id="successfully-dismissed-student" class="modal">
            <!-- Modal content -->
            <div class="modal-content">
                <span class="close">&times;</span>
                <p class="modal-text">Successfully dismissed student</p>
            </div>
        </div>
        <div id="unsuccessfully-dismissed-student" class="modal">
            <!-- Modal content -->
            <div class="modal-content">
                <span class="close">&times;</span>
                <p class="modal-text">Unsuccessfully dismissed student</p>
            </div>
        </div>
<!--        <h2>Collapsible Sidebar Using Bootstrap 3</h2>-->
<!--        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et-->
<!--            dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex-->
<!--            ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat-->
<!--            nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit-->
<!--            anim id est laborum.</p>-->
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
                    </tr>
                    </thead>
                    <tbody>
                    <?
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
            if ('active' == document.getElementById("sidebar").classList[0]) {
                window.localStorage.setItem('#sidebar', 'active');
            } else {
                window.localStorage.setItem('#sidebar', 'inactive');
            }
        });
    });

    // Get the <span> element that closes the modal
    //Check if the session variable is set,
    <?php if (isset ($_SESSION['updatedStudent']) && $_SESSION['updatedStudent'] == 1){ ?>
    var modal = document.getElementById('successfully-edited-student');
    var span = document.getElementsByClassName("close")[0];
    <? unset($_SESSION['updatedStudent']);
    } else if (isset($_SESSION['updatedStudent'])){?>
    var modal = document.getElementById('unsuccessfully-edited-student');
    var span = document.getElementsByClassName("close")[1];
    <?} unset($_SESSION['updatedStudent']);?>

    <?php if (isset ($_SESSION['dismissStudent']) && $_SESSION['dismissStudent'] == 1){ ?>
    var modal = document.getElementById('successfully-dismissed-student');
    var span = document.getElementsByClassName("close")[2];
    <? unset($_SESSION['dismissStudent']);
    } else if (isset($_SESSION['dismissStudent'])){?>
    var modal = document.getElementById('unsuccessfully-dismissed-student');
    var span = document.getElementsByClassName("close")[3];
    <?} unset($_SESSION['updatedStudent']);?>

    // $_SESSION['dismissStudent'] = -1;
    modal.style.display = "block";
    // When the user clicks on <span> (x), close the modal
    span.onclick = function () {
        modal.style.display = "none";
    };

    // When the user clicks anywhere outside of the modal, close it
    window.onclick = function (event) {
        if (event.target == modal) {
            modal.style.display = "none";
        }
    }
</script>
</body>
</html>

