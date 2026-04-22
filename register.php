<?php

header("Content-Type: application/json");
include "db.php";

$rawInput = file_get_contents("php://input");
$data = json_decode($rawInput);

if (!$data) {
    echo json_encode(["message" => "No data received"]);
    exit;
}

$username = $data->username ?? "";
$email = $data->email ?? "";
$password = $data->password ?? "";
$role = $data->role ?? "";

if ($username == "" || $email == "" || $password == "" || $role == "") {
    echo json_encode(["message" => "Please fill all fields"]);
    exit;
}

/*
-----------------------------
CHECK IF EMAIL EXISTS
-----------------------------
*/
$stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    echo json_encode([
        "message" => "This email is already registered. Please login instead."
    ]);
    exit;
}

/*
-----------------------------
INSERT USER SECURELY
-----------------------------
*/
$hashedPassword = password_hash($password, PASSWORD_DEFAULT);

$stmt = $conn->prepare("INSERT INTO users (username, email, password, role) VALUES (?, ?, ?, ?)");
$stmt->bind_param("ssss", $username, $email, $hashedPassword, $role);

if ($stmt->execute()) {
    echo json_encode([
        "message" => "Account created successfully! You can now login."
    ]);
} else {
    echo json_encode([
        "message" => "Something went wrong. Please try again."
    ]);
}

?>