<?php
session_start();
include("app/includes/components/connection.php");
$isAuthenticated = isset($_SESSION['username']);
$jsUsername = $isAuthenticated ? $_SESSION['username'] : '';
echo '<script>';
echo "var jsUsername = '" . $jsUsername . "';";
echo '</script>';
?>
<!DOCTYPE html>
<html lang="en">
<?php
$title = "";
$CSS = "assets/css/main.css";
include("app/includes/html/index.head.php");
?>
</head>

<body>
  <header>
    <div class="logo">
      <a href="#">Culinary <span>Collaborate</span></a>
    </div>
    <nav>
      <ul>
        <li>
          <div class="recipe-drp">
            <a href="#recipe" class="account-btn">Recipes</a>
          </div>
        </li>
        <li class="my-recipe">
          <div class="my-recipe-drp">
            <a href="user.recipe.table.php" class="account-btn">My recipes</a>
          </div>
        </li>
        <li>
          <div class="account-drp">
            <a href="#" class="account-btn">Account</a>
            <div class="account-drp-content">
              <hr>
              <a href="app/includes/PHP/logout.php" style="color:red;">Logout</a>
            </div>
          </div>
        </li>
      </ul>
    </nav>
  </header>

  <div class="content">
    <h2>Culinary Collaborate</h2>
    <p>Unleash your inner chef, connect over recipes, and savor the art of delicious collaboration!</p>
    <video autoplay muted loop id="video-bg">
      <source src="assets/video/background.mp4" type="video/mp4">
    </video>
  </div>

  <div class="recipe" id="recipe">
    <div class="recipe-header">
      <h3>Recipes</h3>
    </div>
    <form method="POST">
      <div class="recipe-box">
        <?php
        $sql = "SELECT id, title, image_filename FROM recipes ORDER BY id DESC";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
          while ($row = $result->fetch_assoc()) {
            $recipeID = $row['id'];
            $avgRatingQuery = "SELECT AVG(rating) as avg_rating, COUNT(*) as rating_count FROM ratings WHERE recipe_id = $recipeID";
            $avgRatingResult = $conn->query($avgRatingQuery);
            $avgRatingData = $avgRatingResult->fetch_assoc();
            $averageRating = $avgRatingData['avg_rating'];
            $ratingCount = $avgRatingData['rating_count'];

            // Calculate percentage based on the average rating 
            $percentage = ($averageRating / 5) * 100;
        ?>
            <div class="item">
              <div class="card">
                <div class="card-image">
                  <img src="assets/uploads/<?php echo $row['image_filename']; ?>" alt="">
                </div>
                <div class="card-body">
                  <?php
                  // Display the star ratings based on the average rating
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
                  ?>
                  <span class="rating-percentage"><?php echo round($percentage, 2) . '%'; ?></span>
                  <h3>
                    <?php echo $row['title']; ?>
                  </h3>
                  <center>
                    <a href="index.view.recipe.php?id=<?php echo $row['id'] ?>" class="btn btn-success">View</a>
                  </center>
                </div>
              </div>
            </div>
        <?php
          }
        }
        ?>
      </div>
    </form>
  </div>

  <div class="footer">
    <div class="footer-box">
      <div class="social-media">
        <a href="#"><i class="fa-brands fa-facebook"></i></a>
        <a href="#"><i class="fa-brands fa-instagram"></i></a>
        <a href="#"><i class="fa-brands fa-twitter"></i></a>
        <a href="#"><i class="fa-brands fa-youtube"></i></a>
      </div>
      <div class="copyright">
        <label>Copyright &copy; 2024</label>
      </div>
      <div class="brand">
        <label>Culinary <span>Collaborate</span></label>
      </div>
    </div>
  </div>

  <?php include("app/includes/html/index.foot.php"); ?>
</body>

</html>