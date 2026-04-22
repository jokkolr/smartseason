<?php
include "db.php";

if ($conn) {
    echo json_encode([
        "success" => true,
        "message" => "DB connected successfully"
    ]);
}
?>