<?php
include "db.php";
session_start();

if(!isset($_SESSION['user_id'])){
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

if(!isset($_GET['id'])){
    header("Location: my_posts.php");
    exit();
}

$post_id = $_GET['id'];

$sql = "SELECT * FROM posts WHERE id='$post_id' AND user_id='$user_id'";
$result = mysqli_query($conn, $sql);

if(mysqli_num_rows($result) == 0){
    header("Location: my_posts.php");
    exit();
}

$post = mysqli_fetch_assoc($result);

$imagePath = "uploads/" . $post['image'];
if(file_exists($imagePath)){
    unlink($imagePath);
}

$delete_sql = "DELETE FROM posts WHERE id='$post_id' AND user_id='$user_id'";
mysqli_query($conn, $delete_sql);

header("Location: my_posts.php");
exit();
?>
