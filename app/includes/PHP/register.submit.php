<?php
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];
    if (empty($username) || empty($password)) {
        echo "<script>
      window.alert('Please fill in all fields!')
      window.location='register.php'</script>";
    }
    $stmt = $conn->prepare("SELECT * FROM users WHERE username=?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    $stmt->close();
    if ($result->num_rows > 0) {
        echo "<script>
          alert('Username or Email Unavailable!')
          window.location = '././register.php'</script>";
    } else {

        $stmt = $conn->prepare("INSERT INTO users (username,password) VALUES (?, ?)");
        $stmt->bind_param("ss", $username, $password);
        $stmt->execute();

        if ($stmt->affected_rows > 0) {
            echo "<script>
            alert('Successfully Registered!')
            window.location = '././login.php'
        </script>";
        } else {
            echo "<script>
            alert('Error adding user!')
            window.location = '././register.php'
        </script>";
        }

        $stmt->close();
    }
    $conn->close();
}