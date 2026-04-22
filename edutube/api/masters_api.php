<?php
include "../db.php";
header('Content-Type: application/json');

$data = json_decode(file_get_contents("php://input"), true);

// for GET (fetch)
$type = $_GET['type'] ?? ($data['type'] ?? '');
$action = $_GET['action'] ?? ($data['action'] ?? '');

$allowed = ['branches','semesters','curriculum','lecturers'];

if(!in_array($type, $allowed)){
  echo json_encode(["status"=>"error","msg"=>"Invalid type"]);
  exit;
}

// ───────── FETCH ─────────
if($action === 'fetch'){
  $res = $conn->query("SELECT id, name FROM $type ORDER BY id DESC");

  $out = [];
  while($row = $res->fetch_assoc()){
    $out[] = $row;
  }

  echo json_encode($out);
  exit;
}

// ───────── ADD ─────────
if($action === 'add'){
  $name = $data['name'] ?? '';

  if(!$name){
    echo json_encode(["status"=>"error","msg"=>"Name required"]);
    exit;
  }

  $stmt = $conn->prepare("INSERT INTO $type (name) VALUES (?)");
  $stmt->bind_param("s", $name);
  $stmt->execute();

  echo json_encode(["status"=>"success"]);
  exit;
}

// ───────── UPDATE ─────────
if($action === 'update'){
  $id = $data['id'] ?? 0;
  $name = $data['name'] ?? '';

  if(!$id || !$name){
    echo json_encode(["status"=>"error","msg"=>"Invalid data"]);
    exit;
  }

  $stmt = $conn->prepare("UPDATE $type SET name=? WHERE id=?");
  $stmt->bind_param("si", $name, $id);
  $stmt->execute();

  echo json_encode(["status"=>"success"]);
  exit;
}

// ───────── DELETE ─────────
if($action === 'delete'){
  $id = $data['id'] ?? 0;

  if(!$id){
    echo json_encode(["status"=>"error","msg"=>"ID required"]);
    exit;
  }

  $stmt = $conn->prepare("DELETE FROM $type WHERE id=?");
  $stmt->bind_param("i", $id);
  $stmt->execute();

  echo json_encode(["status"=>"success"]);
  exit;
}

// fallback
echo json_encode(["status"=>"error","msg"=>"Invalid action"]);