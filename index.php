<?php
session_start();
include("app/includes/components/connection.php");
function updateUsername($username, $userID, $oldPass, $conn) {
  $stmt = $conn->prepare("UPDATE users SET username = ? WHERE id = ? AND password = ?");
  $stmt->bind_param("sis", $username, $userID, $oldPass);
  $stmt->execute();
  if ($stmt->error) {
    // Handle the error (print it, log it, etc.)
    echo "Update Username Error: " . $stmt->error;
  }
  $affectedRows = $stmt->affected_rows;
  $stmt->close();
  return $affectedRows;
}
function updateBoth($username, $newPass, $userID, $oldPass, $conn) {
  $stmt = $conn->prepare("UPDATE users SET username = ?, password = ? WHERE id = ? AND password = ?");
  $stmt->bind_param("ssis", $username, $newPass, $userID, $oldPass);
  $stmt->execute();
  if ($stmt->error) {
    // Handle the error (print it, log it, etc.)
    echo "Update Username Error: " . $stmt->error;
  }
  $affectedRows = $stmt->affected_rows;
  $stmt->close();
  return $affectedRows;
}
if ($_SERVER["REQUEST_METHOD"] === "POST") {
  $username = $_POST['username'];
  $newPass = $_POST['new-password'];
  $oldPass = $_POST['old-password'];
  $userID = $_SESSION['id'];

  $affectedRows = 0;

  if(empty($newPass) && !empty($username)){
    $affectedRows = updateUsername($username, $userID, $oldPass, $conn);
  }
  if(!empty($username) && !empty($newPass) && !empty($oldPass) && !empty($userID)){
    $affectedRows = updateBoth($username, $newPass, $userID, $oldPass, $conn);
  }

  $message = ($affectedRows > 0) ? 'Updated Successfully!' : 'Update Failed!';
  echo "<script>
    alert('$message');
    window.location.href = 'index.php';
    </script>";
}

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
                    <a href="index.view.recipe.php?id=<?php echo $row['id'] ?>" class="btn" id="view-btn">View</a>
                  </center>
                </div>
              </div>
            </div>
          <?php
          }
        } else {
          ?>
          <br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
        <?php
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
  <!-- Post A Recipe Modal -->
  <div class="modal fade" id="acc-setting" tabindex="-1" aria-labelledby="acc-setting-label" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header text-center">
          <div class="w-100">
            <h1 class="modal-title fs-5 d-inline mx-auto" id="acc-setting-label">Account Settings</h1>
          </div>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form method="post">
          <div class="modal-body">
              <?php
              $userID = $_SESSION['id'];
              $result = $conn->query("SELECT username FROM users WHERE id = '$userID'");
              if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
              ?>
                <div class="mb-3">
                  <label for="username" class="form-label">Username</label>
                  <input type="text" class="form-control" name="username" id="username" aria-describedby="username" value="<?php echo $row['username'] ?>">
                  <div id="username" class="form-text">Hey chef!</div>
                </div>

                <div class="mb-3">
                  <label for="new-password" class="form-label">New Password</label>
                  <input type="password" name="new-password" class="form-control" id="new-password">
                </div>
                <div class="mb-3 form-check">
                  <input type="checkbox" class="form-check-input" id="show-new-password">
                  <label class="form-check-label" for="show-new-password">Show Password</label>
                </div>

                <div class="mb-3 mt-4">
                  <label for="old-password" class="form-label">Old Password</label>
                  <input type="password" name="old-password" class="form-control" id="old-password" placeholder="Type your old password to confirm">
                </div>
                <div class="mb-3 form-check">
                  <input type="checkbox" class="form-check-input" id="show-old-password">
                  <label class="form-check-label" for="show-old-password">Show Password</label>
                </div>
              <?php
              }
              ?>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
            <button type="submit" class="btn btn-primary">Update</button>
          </div>
        </form>
      </div>
    </div>
  </div>
  <!-- End of Post Modal -->
  <?php include("app/includes/html/index.foot.php"); ?>
  <script>
    $(document).ready(function() {
      $('#show-new-password').change(function() {
        var passwordInput = $('#new-password');
        if ($(this).is(':checked')) {
          passwordInput.attr('type', 'text');
        } else {
          passwordInput.attr('type', 'password');
        }
      });
      $('#show-old-password').change(function() {
        var passwordInput = $('#old-password');
        if ($(this).is(':checked')) {
          passwordInput.attr('type', 'text');
        } else {
          passwordInput.attr('type', 'password');
        }
      });
    });
  </script>
</body>

</html>