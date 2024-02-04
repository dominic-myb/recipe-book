<?php
session_start();
include("../components/connection.php");
$userID = $_SESSION['id'];
$recipeID = $_GET['id'];
$deleteSQL = "DELETE FROM recipes WHERE user_id = '$userID' AND id = '$recipeID'";
$result = $conn->query($deleteSQL);
$deleteComments = "DELETE FROM comments WHERE recipe_id = '$recipeID'";
$result = $conn->query($deleteComments);
$deleteRatings = "DELETE FROM ratings WHERE recipe_id = '$recipeID'";
$result = $conn->query($$deleteRatings);
if ($result) {
    echo "<script>
            alert('Deleted Successfully!')
            window.location = '../../../user.recipe.table.php'
        </script>";
} else {
    echo "<script>
            alert('An Error Occured while Deleting!')
            window.location = '../../../user.recipe.table.php'
        </script>";
}
