<?php

header("Content-Type: application/json");
include "db.php";

$sql = "SELECT email FROM users WHERE role = 'agent'";
$result = mysqli_query($conn, $sql);

$agents = [];

while ($row = mysqli_fetch_assoc($result)) {
    $agents[] = $row;
}

echo json_encode($agents);

?>