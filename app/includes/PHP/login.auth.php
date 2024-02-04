<?php
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    if (!empty($username) && !empty($password)) {

        //SANITATION OF USER INPUT
        $select = mysqli_prepare($conn, "SELECT * FROM users WHERE username = ? AND password = ?");
        mysqli_stmt_bind_param($select, "ss", $username, $password);
        mysqli_stmt_execute($select);
        $result = mysqli_stmt_get_result($select);
        $user_data = mysqli_fetch_assoc($result);

        if ($user_data) {
            //WE GET THE DATA FROM LOGIN AND WE CAN USE SESSION TO KNOW WHO LOGGED IN
            $_SESSION['id'] = $user_data["id"];
            $_SESSION['username'] = $user_data["username"];
            $_SESSION['password'] = $user_data["password"];
            $isAuthenticated = isset($_SESSION['id']);

            echo json_encode(['isAuthenticated' => $isAuthenticated]); //SENDS A MESSAGE TO JS FOR USER AUTHENTICATION
            echo '<script>
                alert("Welcome, ' . $user_data['username'] . '!");
                window.location.href = "index.php";
                </script>';
            exit();
        } else {
            echo '<script>
                alert("Incorrect Username or Password!");
                window.location.href = "login.php";
                </script>';
            exit();
        }
    }
}
