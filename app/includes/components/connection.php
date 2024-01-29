<?php
$dbhost = "localhost";
$dbuser = "root";
$dbpass = "";
$dbname = "recipe_book_db";

if (!$conn = mysqli_connect($dbhost, $dbuser, $dbpass)) {
    die("Connection Error" . mysqli_connect_error());
}
