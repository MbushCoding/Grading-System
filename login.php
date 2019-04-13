<!DOCTYPE html>
<html lang="ro">
<head>
    <meta charset="UTF-8">
    <title>Students grading</title>
<!--    TODO: put something here-->
    <link rel='icon' href='img/favicon.ico' type='image/x-icon' />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="login/vendor/bootstrap/css/bootstrap.min.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="login/fonts/font-awesome-4.7.0/css/font-awesome.min.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="login/fonts/Linearicons-Free-v1.0.0/icon-font.min.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="login/vendor/animate/animate.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="login/vendor/css-hamburgers/hamburgers.min.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="login/vendor/animsition/css/animsition.min.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="login/vendor/select2/select2.min.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="login/vendor/daterangepicker/daterangepicker.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="login/css/util.css">
    <link rel="stylesheet" type="text/css" href="login/css/main.css">
    <!--===============================================================================================-->
</head>
<body>
<?php
session_start();
if (isset($_POST['email']) && isset($_POST['password'])) {
    //TODO: connect to db, check the credentials
    //redirect to idex if all is fine
    //enalbe bad credentials label in case of not
    $_SESSION['email']=$_POST['email'];
    header("Location: dashboard.php");
}
if (isset ($_SESSION['email'])){
    header("Location: dashboard.php");
}
?>
<div class="limiter">
    <div class="container-login100">
        <div class="wrap-login100">
            <div class="login100-form-title" id="login100-form-title">
					<span class="login100-form-title-1">
						Log in
					</span>
            </div>
            <form method="post" class="login100-form validate-form" action="login.php">
                <div class="wrap-input100 validate-input m-b-26" data-validate="Email is required">
                    <span class="label-input100">Email</span>
                    <input class="input100" type="text" name="email" placeholder="Enter email">
                    <span class="focus-input100"></span>
                </div>

                <div class="wrap-input100 validate-input m-b-18" data-validate = "Password is required">
                    <span class="label-input100">Password</span>
                    <input class="input100" type="password" name="password" placeholder="Enter password">
                    <span class="focus-input100"></span>
                </div>
                <div class="flex-sb-m w-full p-b-30">
<!--                    <div>-->
<!--                        <a href="#" class="txt1">-->
<!--                            Forgot Password?-->
<!--                        </a>-->
<!--                    </div>-->
                </div>
                <div class="container-login100-form-btn">
                    <button class="login100-form-btn">
                        Login
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!--===============================================================================================-->
<script src="login/vendor/jquery/jquery-3.2.1.min.js"></script>
<!--===============================================================================================-->
<script src="login/vendor/animsition/js/animsition.min.js"></script>
<!--===============================================================================================-->
<script src="login/vendor/bootstrap/js/popper.js"></script>
<script src="login/vendor/bootstrap/js/bootstrap.min.js"></script>
<!--===============================================================================================-->
<script src="login/vendor/select2/select2.min.js"></script>
<!--===============================================================================================-->
<script src="login/vendor/daterangepicker/moment.min.js"></script>
<script src="login/vendor/daterangepicker/daterangepicker.js"></script>
<!--===============================================================================================-->
<script src="login/vendor/countdowntime/countdowntime.js"></script>
<!--===============================================================================================-->
<script src="login/js/main.js"></script>
</body>
</html>
