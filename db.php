<?php

$conn = mysqli_connect(
  "sql105.infinityfree.com",
  "if0_41713839",
  "RRjB36Kfp8Rr6",
  "if0_41713839_smartseason"
);

if (!$conn) {
  echo json_encode([
    "message" => "Database connection failed"
  ]);
  exit;
}

?>