<?php

header("Content-Type: application/json");
include "db.php";

// GET DATA SAFELY
$email = isset($_GET['email']) ? trim($_GET['email']) : "";
$role  = isset($_GET['role']) ? trim($_GET['role']) : "";

// VALIDATION
if ($email === "" || $role === "") {
    echo json_encode([]);
    exit;
}

$fields = [];

if ($role === "admin") {

    $sql = "SELECT * FROM fields";
    $result = mysqli_query($conn, $sql);

    if ($result) {
        while ($row = mysqli_fetch_assoc($result)) {
            $fields[] = $row;
        }
    } else {
        echo json_encode(["error" => "SQL error in admin query"]);
        exit;
    }

} else {

    $sql = "SELECT * FROM fields WHERE assigned_to = ?";
    $stmt = $conn->prepare($sql);

    if (!$stmt) {
        echo json_encode(["error" => "Prepare failed"]);
        exit;
    }

    $stmt->bind_param("s", $email);

    if (!$stmt->execute()) {
        echo json_encode(["error" => "Execute failed"]);
        exit;
    }

    $result = $stmt->get_result();

    while ($row = $result->fetch_assoc()) {
        $fields[] = $row;
    }
}

echo json_encode($fields);

?>