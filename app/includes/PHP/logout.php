<?php
session_start();
$_SESSION = array();        //DESTROYS THE SESSION
session_destroy();
header("Location: ../../../login.php");
exit();