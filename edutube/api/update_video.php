<?php
include "../db.php";
header('Content-Type: application/json');

// ✅ Get JSON
$data = json_decode(file_get_contents("php://input"), true);

// ✅ Debug check
if(!$data){
  echo json_encode([
    "status" => "error",
    "msg" => "No data received"
  ]);
  exit;
}

// ✅ Extract safely
$id = $data['id'] ?? 0;
$title = $data['title'] ?? '';
$desc = $data['desc'] ?? '';
$branch = $data['branch'] ?? '';
$sem = $data['sem'] ?? '';
$curriculum = $data['curriculum'] ?? '';
$subject = $data['subject'] ?? '';
$lecturer = $data['lecturer'] ?? '';
$keywords = $data['keywords'] ?? '';
$ytUrl = $data['ytUrl'] ?? '';

if(!$id){
  echo json_encode([
    "status" => "error",
    "msg" => "ID missing"
  ]);
  exit;
}

// ✅ Prepare query
$sql = "UPDATE videos SET 
  video_title=?,
  description=?,
  branch=?,
  semester=?,
  curriculum=?,
  subject_name=?,
  lecturer=?,
  keywords=?,
  youtube_url=?
WHERE id=?";

$stmt = $conn->prepare($sql);

if(!$stmt){
  echo json_encode([
    "status" => "error",
    "msg" => $conn->error
  ]);
  exit;
}

// ✅ Bind
$stmt->bind_param(
  "sssssssssi",
  $title,
  $desc,
  $branch,
  $sem,
  $curriculum,
  $subject,
  $lecturer,
  $keywords,
  $ytUrl,
  $id
);

// ✅ Execute
if($stmt->execute()){
  echo json_encode([
    "status" => "success"
  ]);
} else {
  echo json_encode([
    "status" => "error",
    "msg" => $stmt->error
  ]);
}
?>


