<?php
session_start();    //session start to get the id from the session
include("../components/connection.php");

$userID = $_SESSION['id'];      //GET user id from session
$recipeID = $_GET['id'];        //GET recipe id from the delete-form 

function deleteRecipe($recipeID, $userID, $conn) {  //for deleting of the recipe from db                                               
    $stmt = $conn->prepare("DELETE FROM recipes WHERE id = ? AND user_id = ?");
    $stmt->bind_param("ii", $recipeID, $userID);
    $result = $stmt->execute();
    $stmt->close();

    return $result;
}

function deleteComments($recipeID, $conn) { //for deleting of the comments from db
    $stmt = $conn->prepare("DELETE FROM comments WHERE recipe_id = ?");
    $stmt->bind_param("i", $recipeID);
    $stmt->execute();
    $stmt->close();
}

function deleteRatings($recipeID, $userID, $conn) { //for deleting of the ratings from db
    $stmt = $conn->prepare("DELETE FROM ratings WHERE recipe_id = ? AND user_id = ?");
    $stmt->bind_param("ii", $recipeID, $userID);
    $stmt->execute();
    $stmt->close();
}

function deleteImages($recipeID, $userID, $conn) {  //for deleting of the images from db
    $stmt = $conn->prepare("DELETE FROM images WHERE recipe_id = ? AND user_id = ?");
    $stmt->bind_param("ii", $recipeID, $userID);
    $stmt->execute();
    $stmt->close();
}

if ($_SERVER["REQUEST_METHOD"] === "GET") {
    
    //Perform the deletion with their corresponding parameters
    deleteComments($recipeID, $conn);
    deleteRatings($recipeID, $userID, $conn);
    deleteImages($recipeID, $userID, $conn);
    $result = deleteRecipe($recipeID, $userID, $conn);

    // Redirect after deletion
    if ($result) {
        echo "<script>
            alert('Deleted Successfully!')
            window.location = '../../../user.recipe.table.php'
            </script>";
    } else {
        echo "<script>
            alert('An Error Occurred while Deleting!')
            window.location = '../../../user.recipe.table.php'
            </script>";
    }
}