<?php

header("Content-Type: application/json");
include "db.php";

error_reporting(E_ALL);
ini_set('display_errors', 1);

$data = json_decode(file_get_contents("php://input"), true);

if (!$data) {
    echo json_encode([
        "success" => false,
        "message" => "No data received"
    ]);
    exit;
}

$name = $data["name"] ?? "";
$crop = $data["crop"] ?? "";
$date = $data["date"] ?? "";
$stage = $data["stage"] ?? "";
$assigned_to = $data["assigned_to"] ?? "";

// DEBUG PRINT
if (!$name || !$crop || !$date || !$assigned_to) {
    echo json_encode([
        "success" => false,
        "message" => "Missing data",
        "data_received" => $data
    ]);
    exit;
}

$stmt = $conn->prepare("
    INSERT INTO fields (name, crop, planting_date, stage, assigned_to)
    VALUES (?, ?, ?, ?, ?)
");

if (!$stmt) {
    echo json_encode([
        "success" => false,
        "message" => "Prepare failed",
        "error" => $conn->error
    ]);
    exit;
}

$stmt->bind_param("sssss", $name, $crop, $date, $stage, $assigned_to);

if (!$stmt->execute()) {
    echo json_encode([
        "success" => false,
        "message" => "Execute failed",
        "error" => $stmt->error
    ]);
    exit;
}

echo json_encode([
    "success" => true,
    "message" => "Field added successfully"
]);

?>
