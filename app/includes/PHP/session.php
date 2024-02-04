<?php
session_start();
header('Content-Type: application/json');
$isAuthenticated = isset($_SESSION['id']);      //IF id is FILLED in SESSION MSG WILL BE SENT TO JS TO CONFIRM
echo json_encode(['isAuthenticated' => $isAuthenticated]);