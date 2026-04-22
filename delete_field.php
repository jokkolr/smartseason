<?php

header("Content-Type: application/json");
include "db.php";

$data = json_decode(file_get_contents("php://input"), true);

$id = $data["id"] ?? "";

if ($id === "") {
    echo json_encode([
        "success" => false,
        "message" => "Missing field ID"
    ]);
    exit;
}

$stmt = $conn->prepare("DELETE FROM fields WHERE id = ?");
$stmt->bind_param("i", $id);

if ($stmt->execute()) {
    echo json_encode([
        "success" => true,
        "message" => "Field deleted successfully"
    ]);
} else {
    echo json_encode([
        "success" => false,
        "message" => "Failed to delete field"
    ]);
}

?>