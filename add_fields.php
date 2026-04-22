<?php

header("Content-Type: application/json");
include "db.php";

$data = json_decode(file_get_contents("php://input"));

if (!$data) {
    echo json_encode(["message" => "No data received"]);
    exit;
}

$name = $data->name ?? "";
$crop = $data->crop ?? "";
$date = $data->date ?? "";
$stage = $data->stage ?? "";
$assigned_to = $data->assigned_to ?? "";

$stmt = $conn->prepare("INSERT INTO fields (name, crop, planting_date, stage, assigned_to) VALUES (?, ?, ?, ?, ?)");
$stmt->bind_param("sssss", $name, $crop, $date, $stage, $assigned_to);

if ($stmt->execute()) {
    echo json_encode(["message" => "Field added successfully"]);
} else {
    echo json_encode(["message" => "Failed to add field"]);
}

?>