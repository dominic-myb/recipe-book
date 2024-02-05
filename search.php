<?php
include("app/includes/components/connection.php");

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $input = $_POST['input'];

    $sql = "SELECT r.id, r.title, r.image_filename, AVG(ra.rating) as avg_rating, COUNT(ra.rating) as rating_count
            FROM recipes r
            LEFT JOIN ratings ra ON r.id = ra.recipe_id
            WHERE r.title LIKE '%$input%'
            GROUP BY r.id
            ORDER BY r.id DESC";
            
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo '<div class="item">';
            echo '<div class="card">';
            echo '<div class="card-image">';
            echo '<img src="assets/uploads/' . $row['image_filename'] . '" alt="">';
            echo '</div>';
            echo '<div class="card-body">';
            
            // Display star ratings based on the average rating
            $averageRating = $row['avg_rating'];
            $percentage = ($averageRating / 5) * 100;

            for ($i = 1; $i <= 5; $i++) {
                if ($i <= $averageRating) {
                    echo '<i class="fa-solid fa-star"></i>';
                } else {
                    if ($i - 1 < $averageRating) {
                        echo '<i class="fa-solid fa-star-half"></i>';
                    } else {
                        echo '<i class="fa-regular fa-star"></i>';
                    }
                }
            }

            echo '<span class="rating-percentage">' . round($percentage, 2) . '%</span>';

            // Display other details as needed
            echo '<h3>' . $row['title'] . '</h3>';
            echo '<center><a href="index.view.recipe.php?id=' . $row['id'] . '" class="btn" id="view-btn">View</a></center>';
            echo '</div>';
            echo '</div>';
            echo '</div>';
        }
    } else {
        echo '<div><p style="color: #fff; padding: 20px; background-color: #000; border-radius: 10px;">No recipes found.</p></div>';
    }
}
