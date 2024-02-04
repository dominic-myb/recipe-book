<?php
session_start();
include("app/includes/components/connection.php");

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['rating'])) {
    $rating = $_POST['rating'];
    $userID = $_SESSION["id"];
    $recipeID = $_POST['id'];

    $checkRatingQuery = "SELECT * FROM ratings WHERE user_id = '$userID' AND recipe_id = '$recipeID'";
    $checkRatingResult = mysqli_query($conn, $checkRatingQuery);

    if (mysqli_num_rows($checkRatingResult) > 0) {

        $updateRatingQuery = "UPDATE ratings SET rating = '$rating' WHERE user_id = '$userID' AND recipe_id = '$recipeID'";
        $updateResult = mysqli_query($conn, $updateRatingQuery);

        if (!$updateResult) {
            echo "Error updating rating: " . mysqli_error($conn);
        }
        header("location: index.viewrecipe.php?id=$recipeID");

    } else {

        $insertRatingQuery = "INSERT INTO ratings (user_id, recipe_id, rating) VALUES ('$userID','$recipeID','$rating')";
        $insertResult = mysqli_query($conn, $insertRatingQuery);

        if (!$insertResult) {
            echo "Error inserting rating: " . mysqli_error($conn);
        }
        header("location: index.viewrecipe.php?id=$recipeID");

    }


    if (isset($_POST['comment']) && !empty($_POST['comment'])) {
        $comment = $_POST['comment'];

        $insertCommentQuery = "INSERT INTO comments (recipe_id, user_id, content) VALUES ('$recipeID','$userID','$comment')";
        $insertCommentResult = mysqli_query($conn, $insertCommentQuery);

        if (!$insertCommentResult) {
            echo "Error inserting comment: " . mysqli_error($conn);
        }
        header("location: index.viewrecipe.php?id=$recipeID");

    }
} else {
    echo "Error: Please submit a valid rating.";
}

