<?php
include("app/includes/components/connection.php");
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<?php
$CSS = "assets/css/table.css";
$title = "My Recipe";
include("app/includes/html/table.head.php");
?>

<body>
    <header>
        <div class="logo">
            <a href="index.php">Culinary <span>Collaborate</span></a>
        </div>
        <nav>
            <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#post">Post a Recipe</button>
        </nav>
    </header>
    <div class="table-container">
        <table class="table table-striped" id="recipe-tbl">
            <thead>
                <tr>
                    <th scope="col">No.</th>
                    <th scope="col">Photo</th>
                    <th scope="col">Title</th>
                    <th scope="col">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $user_id = $_SESSION['id'];
                $sql = "SELECT recipes.title, images.recipe_id, images.image_filename FROM images 
                    INNER JOIN recipes ON recipes.id = images.recipe_id 
                    INNER JOIN users ON images.user_id = users.id
                    WHERE users.id = '$user_id'
                    ORDER BY recipes.id DESC";

                $result = $conn->query($sql);
                $num = 1;
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                ?>
                        <tr>
                            <td class="align-middle text-center" scope="row">
                                <?php echo $num++; ?>
                            </td>
                            <td class="align-middle text-center"><img src="assets/uploads/<?php echo $row['image_filename'] ?>" alt=""></td>
                            <td class="align-middle text-center">
                                <?php echo $row['title']; ?>
                            </td>
                            <td class="align-middle text-center">
                                <form id="update-form" action="update.recipe.php" method="get">
                                    <input type="hidden" name="id" value="<?php echo $row['recipe_id']; ?>">
                                    <button type="submit" class="btn btn-primary m-2">Edit Post</button>
                                </form>
                                <form id="recipe-form" action="delete.recipe.php" method="get">
                                    <input type="hidden" name="id" value="<?php echo $row['recipe_id']; ?>">
                                    <button type="submit" class="btn btn-danger m-2" id="deleteButton">Delete</button>
                                </form>
                            </td>
                        </tr>
                    <?php
                    }
                } else {
                    ?>
                    <tr>
                        <td colspan="4" style="text-align: center;">You don't have any post yet</td>
                    </tr>
                <?php
                }
                ?>
            </tbody>
        </table>
    </div>
    <!-- Post A Recipe Modal -->
    <div class="modal fade modal-lg" id="post" tabindex="-1" aria-labelledby="post-label" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header text-center">
                    <div class="w-100">
                        <h1 class="modal-title fs-5 d-inline mx-auto" id="post-label">Create Post</h1>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="upload.php" method="post" enctype="multipart/form-data">
                    <div class="modal-body">
                        <div class="mb-4">
                            <label for="title" class="form-label">Title</label>
                            <input class="form-control" type="text" name="title" id="title" placeholder="Title">
                        </div>
                        <div class="input-group mb-3">
                            <input type="file" name="imgToUpload" class="form-control" id="imgToUpload">
                            <label class="input-group-text" for="imgToUpload">Upload</label>
                        </div>
                        <div class="mb-3">
                            <label for="ingredients" class="form-label">Ingredients</label>
                            <textarea class="form-control" name="ingredients" id="ingredients" rows="3"></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="instructions" class="form-label">Instructions</label>
                            <textarea class="form-control" name="instructions" id="instructions" rows="3"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Post</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- End of Post Modal -->

    <?php include("app/includes/html/table.foot.php"); ?>
    <script>
        $(document).ready(function() {
            // Attach a click event handler to the Delete button
            $('#deleteButton').on('click', function() {
                // Get the recipe ID from the data attribute
                var recipeId = $(this).data('recipe-id');

                // Show a confirmation dialog
                var isConfirmed = confirm('Are you sure you want to delete?');

                // Check if the user clicked OK
                if (isConfirmed) {
                    // If confirmed, set the recipe ID in a hidden input and submit the form
                    $('#recipe-form').append('<input type="hidden" name="deleteid" value="' + recipeId + '">');
                    $('#recipe-form').submit();
                } else {
                    // If canceled, do nothing or provide feedback to the user
                    alert('Delete canceled!');
                }
            });
            // $('[id^="updateButton"]').on('click', function() {
            //     var recipeId = $(this).data('recipe-id');
            //     // $('#update-form').append('<input type="hidden" name="updateid" value="' + recipeId + '">');
            //     $('#update-form').submit();
            // });
        });
    </script>
</body>

</html>