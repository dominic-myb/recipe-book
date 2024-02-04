<?php
session_start();
include("app/includes/components/connection.php");
include("app/includes/PHP/register.submit.php");
?>
<!DOCTYPE html>
<html lang="en">
<?php
$CSS = "assets/css/form.css";
$title = "Register";
include("app/includes/html/form.head.php");
?>

<body>
    <div class="container">
        <div class="d-flex col-12 flex-row flex-wrap align-items-center justify-content-center p-5">
            <div class="d-flex col-12 col-sm-8 col-lg-4 flex-wrap align-items-center justify-content-center border rounded-4 bg-white p-5 shadow-lg">
                <h4 style="width: 100%; margin-bottom: 5vh; margin-top: -1vh;">Culinary <span style="color: orange;">Collaborate</span></h4>
                <form id="register-form" method="post">
                    <div class="form-group mb-4">
                        <input type="text" class="form-control" name="username" id="username" placeholder="Username" required>
                    </div>
                    <div class="form-group">
                        <input type="password" class="form-control" name="password" id="password" placeholder="Password" required>
                    </div>
                    <button type="submit" id="register-btn" class="btn btn-primary btn-block"><?php echo $title; ?></button>
                    <div class="link-container">
                        <a href="login.php">Sign in</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <?php include("app/includes/html/form.foot.php"); ?>
</body>

</html>