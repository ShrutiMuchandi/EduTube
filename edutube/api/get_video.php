<?php
include "../db.php";

$id = $_GET['id'];

$sql = "SELECT * FROM videos WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();

$result = $stmt->get_result();
echo json_encode($result->fetch_assoc());