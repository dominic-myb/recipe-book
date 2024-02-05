<?php
session_start();
include("app/includes/components/connection.php");
if (isset($_SESSION["id"]) != 0) {
    function uploadImage($recipeID, $userID, $fileName, $conn)
    {
        $stmt = $conn->prepare("INSERT INTO images (recipe_id, user_id, image_filename) VALUES (?, ?, ?)");
        $stmt->bind_param("iis", $recipeID, $userID, $fileName);
        $stmt->execute();
        $stmt->close();
    }

    function insertRecipe($userID, $title, $ingredients, $instructions, $fileName, $conn)
    {
        $stmt = $conn->prepare("INSERT INTO recipes (user_id, title, ingredients, instructions, image_filename) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("issss", $userID, $title, $ingredients, $instructions, $fileName);
        $stmt->execute();

        $recipeID = $stmt->insert_id;
        $stmt->close();
        return $recipeID;
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $targetDir = "assets/uploads/";
        $targetFile = $targetDir . basename($_FILES["imgToUpload"]["name"]);
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

        if (isset($_POST["submit"])) {
            $check = getimagesize($_FILES["imgToUpload"]["tmp_name"]);
            if ($check === false) {
                echo "<script>alert('File is not an image.')
                    window.location = 'user.recipe.table.php'</script>";
                exit;
            }
        }

        $allowedFormats = array("jpg", "jpeg", "png");
        if (!in_array($imageFileType, $allowedFormats)) {
            echo "<script>alert('Sorry, only JPG, JPEG, and PNG files are allowed.')
                window.location = 'user.recipe.table.php'</script>";
            exit;
        }

        if (!move_uploaded_file($_FILES["imgToUpload"]["tmp_name"], $targetFile)) {
            echo "<script>alert('Sorry, your post was not uploaded.')
                window.location = 'user.recipe.table.php'</script>";
            exit;
        }

        $title = $_POST['title'];
        $ingredients = $_POST['ingredients'];
        $instructions = $_POST['instructions'];
        $fileName = $_FILES['imgToUpload']['name'];
        $userID = $_SESSION['id'];

        $recipeID = insertRecipe($userID, $title, $ingredients, $instructions, $fileName,$conn);
        uploadImage($recipeID, $userID, $fileName,$conn);

        if ($recipeID > 0) {
            echo "<script>
                alert('Post Uploaded!')
                window.location = 'user.recipe.table.php'
                </script>";
        } else {
            echo "<script>
                alert('An Error Occurred!')
                window.location = 'user.recipe.table.php'
                </script>";
        }

        $conn->close();
    }
} else {
    echo "<script>
    alert('How did you get here?  :P')
    window.location.href = 'index.php'</script>";
}
