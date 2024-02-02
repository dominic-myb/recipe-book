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
$title = "Café BLK & BRWN";
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
    <!-- <video autoplay muted loop id="video-bg">
      <source src="assets/video/background.mp4" type="video/mp4">
    </video> -->
  </div>

  <div class="recipe" id="recipe">
    <div class="recipe-header">
      <h3>Recipes</h3>
    </div>
    <div class="recipe-box">
      <?php
      $sql = "SELECT * FROM recipes ORDER BY id DESC";
      $result = $conn->query($sql);
      if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
          ?>
          <form action="index.php" method="post">
            <div class="item">
              <div class="card">
                <div class="card-image">
                  <input type="hidden" name="id" id="id" value="<?php $row['id']?>">
                  <img src="<?php $row['image_filename'];?>" alt="">
                </div>
                <div class="card-body">
                  <i class="fa-solid fa-star"></i>
                  <i class="fa-solid fa-star"></i>
                  <i class="fa-solid fa-star"></i>
                  <i class="fa-solid fa-star"></i>
                  <i class="fa-solid fa-star-half"></i>

                  <input type="hidden" name="product_price" value="">
                  <label class="cash">
                    4.5
                  </label>

                  <h3>
                    <?php echo $row['title']?>
                  </h3>

                  <label>
                    Lorem ipsum dolor sit, amet consectetur adipisicing elit. Ea, cum.
                  </label>
                  <br>
                  <br>
                  <center>
                    <button type="submit" class="view-recipe" name="view-recipe">
                      View
                    </button>
                  </center>
                </div>
              </div>
            </div>
          </form>
          <?php
        }
      }
      ?>

    </div>
  </div>
  <!-- Button trigger modal -->
  <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
    Launch demo modal
  </button>

  <!-- Modal -->
  <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="exampleModalLabel">Modal title</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form action="">
            <input type="text" name="" id="">
            <input type="text" name="" id="">

        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary">Save changes</button>
        </div>
        </form>
      </div>
    </div>
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