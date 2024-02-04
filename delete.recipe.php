<?php
session_start();
include("app/includes/components/connection.php");
$userID = $_SESSION['id'];
$recipeID = $_GET['id'];
$deleteSQL = "DELETE FROM recipes WHERE user_id = '$userID' AND id = '$recipeID'";
$result = $conn -> query($deleteSQL);
$deleteComments = "DELETE FROM comments WHERE recipe_id = '$recipeID'";
$result = mysqli_query($conn, $deleteComments);
if ($result) {
    echo "<script>
            alert('Deleted Successfully!')
            window.location = 'user.recipe.table.php'
        </script>";
} else {
    echo "<script>
            alert('An Error Occured while Deleting!')
            window.location = 'user.recipe.table.php'
        </script>";
}
?>