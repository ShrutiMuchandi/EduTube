<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
header('Content-Type: application/json');
$conn = new mysqli("localhost", "root", "", "edutube");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

//$data = json_decode(file_get_contents("php://input"), true);
$data = json_decode(file_get_contents("php://input"), true);

if(!$data){
    $data = $_POST; // fallback if JSON fails
}

// assign safely
$title = $data['title'] ?? '';
$desc = $data['desc'] ?? '';
$branch = $data['branch'] ?? '';
$sem = $data['sem'] ?? '';
$curriculum = $data['curriculum'] ?? '';
$subject = $data['subject'] ?? '';
$lecturer = $data['lecturer'] ?? '';
$keywords = $data['keywords'] ?? '';
$ytUrl = $data['ytUrl'] ?? '';

if(empty($title) || empty($ytUrl)){
    die("ERROR: Missing title or URL");
}

$stmt = $conn->prepare("INSERT INTO videos 
(video_title, description, branch, semester, curriculum, subject_name, lecturer, keywords, youtube_url) 
VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");

$stmt->bind_param("sssssssss", $title, $desc, $branch, $sem, $curriculum, $subject, $lecturer, $keywords, $ytUrl);

if($stmt->execute()){
    echo "SUCCESS";
} else {
    echo "ERROR: " . $stmt->error;
}

$stmt->close();
$conn->close();



?>