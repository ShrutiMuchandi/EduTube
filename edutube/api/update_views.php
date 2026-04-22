<?php
/*  counts everyclick of user
include '../db.php';
header('Content-Type: application/json');
if(isset($_GET['id'])){
    $id = intval($_GET['id']);

    // 1️⃣ Increment views safely
    $sql = "UPDATE videos SET views_count = views_count + 1 WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);

    if($stmt->execute()){
        $stmt->close();

        // 2️⃣ Get the new views count safely
        $sql2 = "SELECT views_count FROM videos WHERE id = ?";
        $stmt2 = $conn->prepare($sql2);
        $stmt2->bind_param("i", $id);
        $stmt2->execute();
        $stmt2->bind_result($views);
        $stmt2->fetch();

        echo json_encode(["status"=>"success","views"=>$views]);

        $stmt2->close();
    } else {
        echo json_encode(["status"=>"error"]);
        $stmt->close();
    }

    $conn->close();
}


*/

/* counts per user*/
session_start(); 

include '../db.php';
header('Content-Type: application/json');

if(isset($_GET['id'])){
    $id = intval($_GET['id']);

    // 🔥 Create session storage
    if(!isset($_SESSION['viewed_videos'])){
        $_SESSION['viewed_videos'] = [];
    }

    // 🔥 Check if already viewed
    if(!in_array($id, $_SESSION['viewed_videos'])){

        // ✅ Increment view ONLY FIRST TIME
        $sql = "UPDATE videos SET views_count = views_count + 1 WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $stmt->close();

        // 🔥 Mark as viewed
        $_SESSION['viewed_videos'][] = $id;
    }

    // ✅ Always return current views
    $sql2 = "SELECT views_count FROM videos WHERE id = ?";
    $stmt2 = $conn->prepare($sql2);
    $stmt2->bind_param("i", $id);
    $stmt2->execute();
    $stmt2->bind_result($views);
    $stmt2->fetch();

    echo json_encode([
        "status" => "success",
        "views" => $views
    ]);

    $stmt2->close();
    $conn->close();
}
?>