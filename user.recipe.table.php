<?php
include("app/includes/components/connection.php");
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<?php
$CSS = "assets/css/table.css";
$title = "My Recipe";
include("app/includes/html/form.head.php");
?>

<body>
    <div class="container mt-2">
        <div class="row">
            <div class="col-lg-6">
                <a href="#" class="ml-auto">Culinary <span>Collaborate</span></a>
            </div>
            <div class="col-lg-6">
                <button class="btn btn-success ml-auto mb-1" id="add">Post a Recipe</button>
            </div>
        </div>
    </div>
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
                $sql = "SELECT * FROM recipes WHERE user_id = '$user_id' ORDER BY id DESC";
                $result = $conn->query($sql);
                $num = 1;
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        ?>
                        <tr>
                            <td class="align-middle text-center" scope="row">
                                <?php echo $num++; ?>
                            </td>
                            <td class="align-middle text-center"><img src="assets/img/flat-white.png" alt=""
                                    style="height: 150px; width 150px; object-fit:cover;"></td>
                            <td class="align-middle text-center">
                                <?php echo $row['title']; ?>
                            </td>
                            <td class="align-middle text-center">
                                <button type="button" class="btn btn-primary m-2">Update</button>
                                <button type="button" class="btn btn-danger m-2">Delete</button>
                            </td>
                        </tr>
                        <?php
                    }
                }
                ?>
            </tbody>
        </table>
    </div>
</body>

</html>