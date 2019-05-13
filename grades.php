<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>
    <link rel="stylesheet" href="css/collapsable.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
</head>
<body>
<?php
session_start();
if (!isset($_SESSION['email'])) {
    header("Location: login.php");
}
$academicYear = '2018-2019';
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
                    <li><a href="studentAttendance.php">Student attendance</a></li>
                    <li class="active"><a href="grades.php"><b>Grades</b></a></li>
                </ul>
            </li>
            <li>
                <a href="#">
                    <i class="glyphicon glyphicon-link"></i>
                    Students thesis
                </a>
            </li>
        </ul>
    </nav>

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
        <div id="successfully-edited-grade" class="modal">
            <!-- Modal content -->
            <div class="modal-content">
                <span class="close">&times;</span>
                <p class="modal-text">Successfully edited grade</p>
            </div>
        </div>
        <div id="unsuccessfully-edited-grade" class="modal">
            <!-- Modal content -->
            <div class="modal-content">
                <span class="close">&times;</span>
                <p class="modal-text">Unsuccessfully edited grade</p>
            </div>
        </div>
        <h2>Collapsible Sidebar Using Bootstrap 3</h2>
        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et
            dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex
            ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat
            nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit
            anim id est laborum.</p>
        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et
            dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex
            ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat
            nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit
            anim id est laborum.</p>
        <div class="line"></div>
        <?php
        require_once('classes/Teacher.php');
        require_once('classes/Student.php');
        require_once('classes/Course.php');
        $teacher = unserialize($_SESSION['currentUser']);
        $courses = $teacher->getCourses();
        foreach ($courses as $courseName) {
            $course = new Course();
            $course->setCourseName($courseName);
            $students = unserialize($course->getEnrolledStudentsForAcademicYear($academicYear));
            if (-1 == $students) {
                ?>
                <h1>No student enrolled @ <?php echo $courseName . " " . $academicYear ?></h1>
            <?php } else {
                ?>
                <h2>Grades for students enrolled @ <?php echo $courseName . " " . $academicYear ?></h2>
                <table class="table">
                    <thead class="thead-dark">
                    <tr>
                        <th scope="col">Student ID</th>
                        <th scope="col">First name</th>
                        <th scope="col">Last name</th>
                        <th scope="col">Email</th>
                        <th scope="col">Class</th>
                        <th scope="col">Grade</th>
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
                            echo "<th scope=\"row\">" . $studObj->getId() . "</th>";
                            echo "<td>" . $studObj->getFirstName() . "</td>";
                            echo "<td>" . $studObj->getLastName() . "</td>";
                            echo "<td>" . $studObj->getEmail() . "</td>";
                            echo "<td>" . $studObj->getClass() . "</td>";
                            ?>
                            <form method="GET" action="editGrade.php" class="editGrade">
                                <?php
                                if ($studObj->getGradeForCourse($course->getId()) != -1) {
                                    echo "<td>" .
                                        "<input type = \"text\" name='grade' maxlength='4' value = \"" . $studObj->getGradeForCourse($course->getId()) . "\"></td > ";
                                } else {
                                    echo "<td>" . "<input type=\"text\" name='grade' maxlength='4' value=\"No grade yet\"></td>";
                                }
                                ?>
                                <td>
                                    <button type="submit" class="btn btn-success btn-md">
                                        Update grade
                                    </button>
                                    <input type="hidden" name="courseId" value="<?= $course->getId() ?>">
                                    <input type="hidden" name="academicYear" value="<?= $academicYear ?>">
                                    <input type="hidden" name="studentId" value="<?= $studID ?>">
                            </form>
                            </td>
                        </tr>
                    <?php } ?>
                    </tbody>
                </table>
                <div class="line"></div>
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

    <?php if (isset ($_SESSION['editedGrade']) && $_SESSION['editedGrade'] == 1){ ?>
    var modal = document.getElementById('successfully-edited-grade');
    var span = document.getElementsByClassName("close")[0];
    <? unset($_SESSION['editedGrade']);
    } else if (isset($_SESSION['editedGrade'])){?>
    var modal = document.getElementById('unsuccessfully-edited-grade');
    var span = document.getElementsByClassName("close")[1];
    <?} unset($_SESSION['editedGrade']);?>

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
