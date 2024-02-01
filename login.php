<?php
session_start();
include("app/includes/components/connection.php");
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];
    if (!empty($username) && !empty($password)) {
        $query = "SELECT * FROM users WHERE username = '$username'";
        $result = mysqli_query($conn, $query);
        if ($result && mysqli_num_rows($result) > 0) {
            $user_data = mysqli_fetch_assoc($result);
            if ($user_data['password'] === $password) {
                $_SESSION['id'] = $user_data['id'];
                header("location: index.php");
                die;
            }
        } else {
            echo '<script>
            window.alert("Incorrect Username or Password!")
            window.location="login.php"
            </script>';
        }
    } else {
        echo '<script>
        window.alert("Please Enter Valid Input!")
        window.location="login.php"
        </script>';
    }

}
?>
<!DOCTYPE html>
<html lang="en">
<?php
$title = "- Login";
include("app/includes/html/html.head.php");
?>
<div class="container">
    <form action="login.php" method="post">
        <h3>Login</h3>
        <input type="text" class="username" name="username" id="username" placeholder="Username" required>
        <input type="password" class="username" name="password" id="password" placeholder="Password" required>
        <button type="submit" class="btn btn-primary">Login</button>
    </form>
</div>

<body>
    <?php include("app/includes/html/html.foot.php"); ?>
</body>

</html>