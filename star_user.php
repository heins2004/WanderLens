<?php
include "db.php";
session_start();

if(!isset($_SESSION['user_id'])){
    echo json_encode(['success' => false, 'message' => 'Not logged in']);
    exit();
}

$user_id = $_SESSION['user_id'];
$starred_user_id = intval($_POST['starred_user_id'] ?? 0);
$action = $_POST['action'] ?? '';

if($starred_user_id <= 0 || $starred_user_id == $user_id){
    echo json_encode(['success' => false, 'message' => 'Invalid user']);
    exit();
}

if($action == 'star'){
    $sql = "INSERT IGNORE INTO starred_users (user_id, starred_user_id) VALUES ('$user_id', '$starred_user_id')";
    if(mysqli_query($conn, $sql)){
        echo json_encode(['success' => true, 'starred' => true]);
    } else {
        echo json_encode(['success' => false, 'message' => mysqli_error($conn)]);
    }
} else if($action == 'unstar'){
    $sql = "DELETE FROM starred_users WHERE user_id='$user_id' AND starred_user_id='$starred_user_id'";
    if(mysqli_query($conn, $sql)){
        echo json_encode(['success' => true, 'starred' => false]);
    } else {
        echo json_encode(['success' => false, 'message' => mysqli_error($conn)]);
    }
} else {
    $sql = "SELECT * FROM starred_users WHERE user_id='$user_id' AND starred_user_id='$starred_user_id'";
    $result = mysqli_query($conn, $sql);
    $starred = mysqli_num_rows($result) > 0;
    echo json_encode(['success' => true, 'starred' => $starred]);
}
?>




