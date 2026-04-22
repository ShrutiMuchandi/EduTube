<?php
include '../db.php';
header('Content-Type: application/json');
$id = $_GET['id'];

$sql = "SELECT * FROM videos WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

$row = $result->fetch_assoc();

echo json_encode($row);
?>