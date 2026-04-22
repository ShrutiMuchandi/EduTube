<?php
include '../db.php';
header('Content-Type: application/json');
$result = $conn->query("SELECT * FROM videos ORDER BY id DESC");

$videos = [];

while ($row = $result->fetch_assoc()) {
    //$row['keywords'] = explode(",", $row['keywords']);
    $videos[] = $row;
}

echo json_encode($videos);
?>