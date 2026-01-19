<?php
include "db.php";
session_start();

if(!isset($_SESSION['user_id'])){
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

if(!isset($_GET['id']) || !isset($_GET['post_id'])){
    header("Location: index.php");
    exit();
}

$comment_id = $_GET['id'];
$post_id = $_GET['post_id'];

$sql = "SELECT * FROM comments WHERE id='$comment_id' AND user_id='$user_id'";
$result = mysqli_query($conn, $sql);

if(mysqli_num_rows($result) == 0){
    header("Location: view_post.php?id=".$post_id);
    exit();
}

$del_sql = "DELETE FROM comments WHERE id='$comment_id' AND user_id='$user_id'";
mysqli_query($conn, $del_sql);

header("Location: view_post.php?id=".$post_id);
exit();
?>
