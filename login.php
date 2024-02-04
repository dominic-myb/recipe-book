<?php
session_start();
include("app/includes/components/connection.php");
include("app/includes/PHP/login.auth.php");
?>
<!DOCTYPE html>
<html lang="en">
<?php
$CSS = "assets/css/form.css";
$title = "Login";
include("app/includes/html/form.head.php");
?>

<body>
    <div class="container">
        <div class="d-flex col-12 flex-row flex-wrap align-items-center justify-content-center p-5">
            <div class="d-flex col-12 col-sm-8 col-lg-4 flex-wrap align-items-center justify-content-center border rounded-4 bg-white p-5 shadow-lg">
                <h4 style="width: 100%; margin-bottom: 5vh; margin-top: -1vh;">Culinary <span style="color: orange;">Collaborate</span></h4>
                <form id="login-form" method="post">
                    <div class="form-group mb-4">
                        <input type="text" class="form-control" name="username" id="username" placeholder="Username">
                    </div>
                    <div class="form-group">
                        <input type="password" class="form-control" name="password" id="password" placeholder="Password">
                    </div>
                    <button type="submit" id="login-btn" class="btn btn-primary btn-block"><?php echo $title; ?></button>
                </form>
                <p style="margin-top:4vh; margin-left: -1vh;"><a href="register.php" style="text-decoration: none;">Create Account</a></p>
            </div>
        </div>
    </div>
    <?php include("app/includes/html/form.foot.php"); ?>
</body>

</html>