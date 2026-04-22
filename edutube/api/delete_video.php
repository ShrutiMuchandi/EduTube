<?php
include '../db.php';
header('Content-Type: application/json');
$id = $_GET['id'];

$conn->query("DELETE FROM videos WHERE id=$id");

echo json_encode(["status" => "deleted"]);
?>