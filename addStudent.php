<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>
    <link rel="stylesheet" href="css/dashboard.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
</head>
<body>
<?php
session_start();
if (!isset($_SESSION['email'])) {
    header("Location: login.php");
}
if (isset($_POST['email'])) {
    //connect to DB, insert & get response
    require('db/DBConnection.php');
    insertStudent($_POST['firstName'], $_POST['lastName'], $_POST['email'], $_POST['class']);

}
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
                <a href="dashboard.php data-toggle collapse" aria-expanded="false">
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
                        <?php if (basename($_SERVER["SCRIPT_FILENAME"], '.php') == 'addStudent') echo '<b>' ?>
                        <a href="addStudent.php">Add student</a></li>
                    <?php if (basename($_SERVER["SCRIPT_FILENAME"], '.php') == 'addStudent') echo '</b>' ?>
                    <li><a href="#">Student attendance</a></li>
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

        <h2>Add a student</h2>
        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et
            dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex
            ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat
            nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit
            anim id est laborum.</p>

        <!--        TODO: make this fields required-->
        <form action="addStudent.php" method="POST">
            <div class="form-group">
                <label for="addStudent-firstName">First name</label>
                <input type="text" class="form-control" id="addStudent-firstName" placeholder="First name"
                       name="firstName">
            </div>
            <div class="form-group">
                <label for="addStudent-lastName">Last name</label>
                <input type="text" class="form-control" id="addStudent-lastName" placeholder="Last name"
                       name="lastName">
            </div>
            <div class="form-group">
                <!--                TODO: change this to a drop menu-->
                <label for="addStudent-class">Class</label>
                <input type="text" class="form-control" id="addStudent-class" placeholder="Class" name="class">
            </div>
            <div class="form-group">
                <label for="addStudent-email">Email address</label>
                <input type="email" class="form-control" id="addStudent-email" placeholder="Enter email" name="email">
            </div>
            <div class="form-check">
                <input type="checkbox" class="form-check-input" id="gdpr-check">
                <label class="form-check-label" for="gdpr-check">Agree with GDPR rules</label>
            </div>
            <button type="submit" class="btn btn-primary" id="submit-button">Add</button>
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
        });
    });
</script>
</body>
</html>

