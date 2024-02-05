<?php
session_start();
include("app/includes/components/connection.php");

if (isset($_GET['id'])) {
    $recipeID = $_GET['id'];

    // Fetch recipe details
    $stmt = $conn->prepare("SELECT title, ingredients, instructions, image_filename FROM recipes WHERE id = ?");
    $stmt->bind_param("i", $recipeID);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();

        // Fetch user rating
        if(isset($_SESSION['id'])){
            $userID = $_SESSION["id"];
        }else{
            $userID = "0";
        }
        
?>
        <!DOCTYPE html>
        <html lang="en">

        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <link rel="stylesheet" href="assets/css/vendor/bootstrap-5.2.3-dist/css/bootstrap.min.css">
            <link rel="stylesheet" href="assets/css/index.viewrecipe.css">
            <link href='https://unpkg.com/boxicons@2.1.1/css/boxicons.min.css' rel='stylesheet'>
            <title>Recipe - <?php echo $row['title'] ?></title>
        </head>

        <body>
            <header>
                <div class="logo">
                    <a href="index.php">Culinary <span>Collaborate</span></a>
                </div>
            </header>
            <div class="container">
                <div class="recipe-card">
                    <div class="recipe-image">
                        <img src="assets/uploads/<?php echo $row['image_filename'] ?>" alt="Recipe Image">
                    </div>
                    <div class="recipe-details">
                        <div class="recipe-name"><?php echo $row['title'] ?></div>
                        <div class="recipe-ingredients">
                            <h4>Ingredients:</h4>
                            <ul>
                                <?php
                                // Split the ingredients string into an array using newline as the delimiter
                                $ingredientsArray = explode("\n", $row['ingredients']);

                                // Loop through the array and display each ingredient as a list item
                                foreach ($ingredientsArray as $ingredient) {
                                    echo '<li>' . htmlspecialchars($ingredient) . '</li>';
                                }
                                ?>
                            </ul>
                        </div>
                        <div class="recipe-instructions">
                            <h4>Instructions:</h4>
                            <ol>
                                <?php
                                // Split the instructions string into an array using newline as the delimiter
                                $instructionsArray = explode("\n", $row['instructions']);

                                // Loop through the array and display each instruction as a numbered list item
                                foreach ($instructionsArray as $instruction) {
                                    echo '<li>' . htmlspecialchars($instruction) . '</li>';
                                }
                                ?>
                            </ol>
                        </div>
                        <div class="users-comments">
                            <h3 style="margin-left:-20px;">Comments:</h3>
                            <?php
                            $result = mysqli_query($conn, "SELECT comments.content, users.username FROM comments 
                                INNER JOIN users ON users.id = comments.user_id
                                WHERE comments.recipe_id = '$recipeID'
                                ORDER BY comments.id DESC");
                            if ($result && mysqli_num_rows($result) > 0) {
                            ?>
                                <?php
                                while ($row = mysqli_fetch_assoc($result)) {
                                ?>
                                    <p><span><?php echo $row['username'] ?></span>: <?php echo $row['content'] ?></p>
                                <?php
                                }
                            } else {
                                ?>
                                <p style="text-align: center; margin-left:-20px;">Be the first one to comment!</p>
                            <?php
                            }
                            ?>
                        </div>
                    </div>
                </div>

                <!-- Recipe Rating Form -->
                <div class="wrapper">
                    <h3>Your Rating</h3>
                    <form action="app/includes/PHP/submit.rating.php" method="post">
                        <input type="hidden" name="id" value="<?php echo $recipeID ?>">
                        <div class="rating">
                            <input type="number" name="rating" hidden>
                            <i class='bx bx-star star' style="--i: 0;"></i>
                            <i class='bx bx-star star' style="--i: 1;"></i>
                            <i class='bx bx-star star' style="--i: 2;"></i>
                            <i class='bx bx-star star' style="--i: 3;"></i>
                            <i class='bx bx-star star' style="--i: 4;"></i>
                        </div>
                        <textarea name="comment" cols="30" rows="5" placeholder="Add a Comment"></textarea>
                        <div class="btn-group">
                            <button type="submit" class="btn submit">Submit</button>
                            <button class="btn cancel">Cancel</button>
                        </div>
                    </form>
                </div>
            </div>
            <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

            <script>
                $(document).ready(function() {
                    const allStar = $('.rating .star');
                    const ratingValue = $('.rating input');

                    allStar.each(function(idx, item) {
                        $(item).on('click', function() {
                            let click = 0;
                            ratingValue.val(idx + 1);

                            allStar.removeClass('bxs-star').addClass('bx-star').removeClass('active');

                            for (let i = 0; i < allStar.length; i++) {
                                if (i <= idx) {
                                    $(allStar[i]).removeClass('bx-star').addClass('bxs-star').addClass('active');
                                } else {
                                    $(allStar[i]).css('--i', click);
                                    click++;
                                }
                            }
                        });
                    });
                });
            </script>

        </body>

        </html>
<?php
    } else {
        echo "<script>alert('Recipe not found.')
            window.location = 'user.recipe.table.php'</script>";
    }

    $stmt->close();
}
?>