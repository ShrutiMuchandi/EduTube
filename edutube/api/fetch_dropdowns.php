<?php
include '../db.php';
header('Content-Type: application/json');
$data = [];

// branches
$res = $conn->query("SELECT * FROM branches");
$data['branches'] = $res->fetch_all(MYSQLI_ASSOC);

// semesters
$res = $conn->query("SELECT * FROM semesters");
$data['semesters'] = $res->fetch_all(MYSQLI_ASSOC);

// curriculum
$res = $conn->query("SELECT * FROM curriculum");
$data['curriculum'] = $res->fetch_all(MYSQLI_ASSOC);

// lecturers
$res = $conn->query("SELECT * FROM lecturers");
$data['lecturers'] = $res->fetch_all(MYSQLI_ASSOC);

echo json_encode($data);

?>