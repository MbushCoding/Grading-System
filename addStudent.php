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
require_once('classes/Teacher.php');
if (!isset($_SESSION['email'])) {
    header("Location: login.php");
}
if (isset($_POST['email'])) {
    //connect to DB, insert & get response
    require('db/DBConnection.php');
    insertStudent($_POST['firstName'], $_POST['lastName'], $_POST['email'], $_POST['class'], $_POST['course']);
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
                    <li class="active">
                        <a href="addStudent.php"><b>Add student</b></a></li>
                    <li><a href="studentAttendance.php">Student attendance</a></li>
                    <li><a href="grades.php">Grades</a></li>
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
        <h2>Add a student</h2>
        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et
            dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex
            ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat
            nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit
            anim id est laborum.</p>
        <div class="line"></div>

        <div id="succesfully-added-student" class="modal">
            <!-- Modal content -->
            <div class="modal-content">
                <span class="close">&times;</span>
                <p class="modal-text">Successfully added student</p>
            </div>
        </div>
        <div id="unsuccesfully-added-student" class="modal">
            <!-- Modal content -->
            <div class="modal-content">
                <span class="close">&times;</span>
                <p class="modal-text">Unsuccessfully added student</p>
            </div>
        </div>
        <form action="addStudent.php" method="POST">
            <div class="form-group">
                <label for="addStudent-firstName">First name</label>
                <input type="text" class="form-control" id="addStudent-firstName" placeholder="First name"
                       name="firstName" required>
            </div>
            <div class="form-group">
                <label for="addStudent-lastName">Last name</label>
                <input type="text" class="form-control" id="addStudent-lastName" placeholder="Last name"
                       name="lastName" required>
            </div>
            <div class="form-group">
                <label for="addStudent-class">Class</label>
                <input type="text" class="form-control" id="addStudent-class" placeholder="Class" name="class" required>
            </div>
            <div class="form-group">
                <label for="addStudent-email">Email address</label>
                <input type="email" class="form-control" id="addStudent-email" placeholder="Enter email" name="email"
                       required>
            </div>
            <div class="form-group">
                <label for="course">Course</label>
                <select class="form-control" id="course" name="course" required>
                    <?php
                    $teacher = unserialize($_SESSION['currentUser']);
                    $courses = $teacher->getCourses();
                    foreach ($courses as $course) {
                        ?>
                        <option><?php echo $course ?></option>
                        <?php
                    }
                    ?>
                </select>
            </div>
            <div class="form-check">
                <input type="checkbox" class="form-check-input" id="gdpr-check" required>
                <label class="form-check-label" for="gdpr-check">Agree with GDPR rules</label>
            </div>
            <button type="submit" class="btn btn-primary" id="addStudent-button">Add</button>
        </form>


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
    <?php if (isset ($_SESSION['addUserSuccessfully']) && $_SESSION['addUserSuccessfully'] == 1){ ?>
    var modal = document.getElementById('succesfully-added-student');
    var span = document.getElementsByClassName("close")[0];
    <? unset($_SESSION['addUserSuccessfully']);
    } else if (isset($_SESSION['addUserSuccessfully'])){?>
    var modal = document.getElementById('unsuccesfully-added-student');
    var span = document.getElementsByClassName("close")[1];
    <?} unset($_SESSION['addUserSuccessfully']);?>
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
