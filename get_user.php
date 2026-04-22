<?php

header("Content-Type: application/json");

include "db.php";

$email = $_GET['email'] ?? '';

$sql = "SELECT email, role, username FROM users WHERE email='$email'";
$result = mysqli_query($conn, $sql);

$user = mysqli_fetch_assoc($result);

if ($user) {
    echo json_encode($user);
} else {
    echo json_encode(["message" => "User not found"]);
}

?>