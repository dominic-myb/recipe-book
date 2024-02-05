<?php
session_start();
include("app/includes/components/connection.php");
if (isset($_SESSION["id"]) != 0) {
    $userID = $_SESSION['id'];
    $recipeID = $_GET['id'];


    function updateImage($fileName, $recipeID, $userID)
    {
        global $conn;

        $stmt = $conn->prepare("UPDATE images SET image_filename = ? WHERE recipe_id = ? AND user_id = ?");
        $stmt->bind_param("sii", $fileName, $recipeID, $userID);
        $stmt->execute();
        $stmt->close();
    }
    function updateInfo($recipeID, $title, $ingredients, $instructions, $fileName)
    {
        global $conn;

        $stmt = $conn->prepare("UPDATE recipes SET title = ?, ingredients = ?, instructions = ?, image_filename = ? WHERE id = ?");
        $stmt->bind_param("ssssi", $title, $ingredients, $instructions, $fileName, $recipeID);
        $stmt->execute();
        $stmt->close();
    }

    function updateInfoOnly($recipeID, $title, $ingredients, $instructions)
    {
        global $conn;

        $stmt = $conn->prepare("UPDATE recipes SET title = ?, ingredients = ?, instructions = ? WHERE id = ?");
        $stmt->bind_param("sssi", $title, $ingredients, $instructions, $recipeID);
        $stmt->execute();
        $stmt->close();
    }

    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        $title = $_POST['title'];
        $ingredients = $_POST['ingredients'];
        $instructions = $_POST['instructions'];

        if (!empty($_FILES["imgToUpload"]["name"])) {
            $fileName = $_FILES['imgToUpload']['name'];

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
            updateImage($fileName, $recipeID, $userID);
            updateInfo($recipeID, $title, $ingredients, $instructions, $fileName);
            header("location: user.recipe.table.php");
            exit;
        }
        if (!empty($_POST["title"]) || !empty($_POST['$ingredients']) || !empty($_POST['instructions'])) {
            updateInfoOnly($recipeID, $title, $ingredients, $instructions);
            header("location: user.recipe.table.php");
            exit;
        }
    }

?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="assets/css/vendor/bootstrap-5.2.3-dist/css/bootstrap.min.css">
        <link rel="stylesheet" href="assets/css/update.css">
        <title>Update Post</title>
    </head>

    <body>
        <?php
        $select = "SELECT * FROM recipes WHERE user_id = '$userID' AND id = '$recipeID'";
        $result = $conn->query($select);
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
        ?>
                <div class="container">
                    <div class="container-2">
                        <form method="POST" enctype="multipart/form-data">
                            <h4 style="text-align: center; margin-top:-30px;" class="mb-4">Edit Post</h4>
                            <div class="mb-4">
                                <label for="title" class="form-label">Title</label>
                                <input class="form-control" type="text" name="title" id="title" placeholder="Title" value="<?php echo $row['title']; ?>">
                            </div>
                            <div class="input-group mb-3">
                                <input type="file" name="imgToUpload" class="form-control" id="imgToUpload">
                                <label class="input-group-text" for="imgToUpload">Upload</label>
                            </div>
                            <div class="mb-3">
                                <label for="ingredients" class="form-label">Ingredients</label>
                                <textarea class="form-control" name="ingredients" id="ingredients" rows="3"><?php echo $row['ingredients']; ?></textarea>
                            </div>
                            <div class="mb-3">
                                <label for="instructions" class="form-label">Instructions</label>
                                <textarea class="form-control" name="instructions" id="instructions" rows="3"><?php echo $row['instructions']; ?></textarea>
                            </div>
                            <div class="button-container">
                                <button type="submit" class="btn btn-primary">Update</button>
                                <button type="button" class="btn btn-danger">Cancel</button>
                            </div>
                        </form>
                    </div>
                </div>
        <?php
            }
        }
        ?>
        <script src="assets/css/vendor/bootstrap-5.2.3-dist/js/bootstrap.min.js"></script>
    </body>

    </html>

<?php
} else {
    echo "<script>
    alert('How did you get here?  :P')
    window.location.href = 'index.php'</script>";
}
?>