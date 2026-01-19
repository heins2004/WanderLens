<?php
include "db.php";
session_start();

if(!isset($_SESSION['user_id'])){
    header("Location: login.php");
    exit();
}

if(!isset($_POST['submit']) || !isset($_POST['post_id'])){
    header("Location: index.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$post_id = $_POST['post_id'];
$comment = mysqli_real_escape_string($conn, $_POST['comment']);

$sql = "INSERT INTO comments (post_id, user_id, comment)
        VALUES ('$post_id', '$user_id', '$comment')";

mysqli_query($conn, $sql);

header("Location: view_post.php?id=".$post_id);
exit();
?>
