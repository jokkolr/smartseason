<?php

header("Content-Type: application/json");
include "db.php";

$data = json_decode(file_get_contents("php://input"), true);

$id = $data["id"] ?? "";
$name = $data["name"] ?? "";
$crop = $data["crop"] ?? "";
$stage = $data["stage"] ?? "";

if ($id === "") {
    echo json_encode([
        "success" => false,
        "message" => "Missing ID"
    ]);
    exit;
}

$stmt = $conn->prepare("
    UPDATE fields 
    SET name = ?, crop = ?, stage = ? 
    WHERE id = ?
");

$stmt->bind_param("sssi", $name, $crop, $stage, $id);

if ($stmt->execute()) {
    echo json_encode([
        "success" => true,
        "message" => "Field updated successfully"
    ]);
} else {
    echo json_encode([
        "success" => false,
        "message" => "Update failed"
    ]);
}

?>