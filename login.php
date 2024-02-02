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
            <div
                class="d-flex col-12 col-sm-8 col-lg-4 flex-wrap align-items-center justify-content-center border rounded-4 bg-white p-5 shadow-lg">
                <form id="login-form" method="post">
                    <h3><?php echo $title;?></h3>
                    <div class="form-group mb-4">
                        <input type="text" class="form-control" name="username" id="username" placeholder="Username">
                    </div>
                    <div class="form-group">
                        <input type="password" class="form-control" name="password" id="password" placeholder="Password">
                    </div>
                    <div style="margin-y:0.5rem;">&nbsp</div>
                    <button type="submit" id="login-btn" class="btn btn-primary btn-block"><?php echo $title;?></button>
                </form>
            </div>
        </div>
    </div>
    <?php include("app/includes/html/form.foot.php"); ?>
</body>

</html>