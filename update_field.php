<?php

header("Content-Type: application/json");
include "db.php";

$data = json_decode(file_get_contents("php://input"));

$id = $data->id ?? "";
$stage = $data->stage ?? "";

if ($id == "" || $stage == "") {
    echo json_encode(["message" => "Missing data"]);
    exit;
}

$stmt = $conn->prepare("UPDATE fields SET stage=? WHERE id=?");
$stmt->bind_param("si", $stage, $id);

if ($stmt->execute()) {
    echo json_encode(["message" => "Field updated"]);
} else {
    echo json_encode(["message" => "Update failed"]);
}

?>