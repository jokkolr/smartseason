<?php

header("Content-Type: application/json");
include "db.php";

$rawInput = file_get_contents("php://input");
$data = json_decode($rawInput, true);

// Validate JSON input
if (!$data) {
    echo json_encode([
        "success" => false,
        "message" => "Invalid request data"
    ]);
    exit;
}

$email = trim($data["email"] ?? "");
$password = trim($data["password"] ?? "");

if ($email === "" || $password === "") {
    echo json_encode([
        "success" => false,
        "message" => "Please enter email and password"
    ]);
    exit;
}

// Find user
$stmt = $conn->prepare("SELECT id, username, email, password, role FROM users WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    echo json_encode([
        "success" => false,
        "message" => "No account found. Please sign up first."
    ]);
    exit;
}

$user = $result->fetch_assoc();

// Verify password
if (!password_verify($password, $user["password"])) {
    echo json_encode([
        "success" => false,
        "message" => "Incorrect password"
    ]);
    exit;
}

// Success
echo json_encode([
    "success" => true,
    "message" => "Login successful",
    "email" => $user["email"],
    "role" => $user["role"]
]);

?>