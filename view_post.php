<?php
include "header.php";
include "db.php";

if(!isset($_GET['id'])){
    echo "<p>Invalid post.</p>";
    include "footer.php";
    exit();
}

$post_id = $_GET['id'];

$sql = "SELECT posts.*, users.username 
        FROM posts 
        JOIN users ON posts.user_id = users.id
        WHERE posts.id = '$post_id'";

$result = mysqli_query($conn, $sql);

if(mysqli_num_rows($result) == 0){
    echo "<p>Post not found.</p>";
    include "footer.php";
    exit();
}

$post = mysqli_fetch_assoc($result);

if($post['visibility'] == "private" && $post['user_id'] != ($_SESSION['user_id'] ?? 0)){
    echo "<p>This post is private.</p>";
    include "footer.php";
    exit();
}

$com_sql = "SELECT comments.*, users.username 
            FROM comments 
            JOIN users ON comments.user_id = users.id
            WHERE comments.post_id = '$post_id'
            ORDER BY comments.id ASC";

$com_result = mysqli_query($conn, $com_sql);
$comments = [];
$user_comments = [];
$other_comments = [];
$current_user_id = $_SESSION['user_id'] ?? 0;

if($com_result && mysqli_num_rows($com_result) > 0){
    while($c = mysqli_fetch_assoc($com_result)){
        if($c['user_id'] == $current_user_id){
            $user_comments[] = $c;
        } else {
            $other_comments[] = $c;
        }
    }
}

shuffle($other_comments);

$comments = array_merge($user_comments, $other_comments);
?>

<div class="instagram-post-container">
    <div class="post-image-section">
        <img class="post-main-image" src="uploads/<?=$post['image'];?>" alt="Post Image">
    </div>

    <div class="post-details-section">
        <div class="post-header">
            <div class="post-location">
                <span class="location-icon">📍</span>
                <span class="location-text"><?=htmlspecialchars($post['location']);?></span>
            </div>
            <div class="post-user">
                <span class="username-text">@<?=htmlspecialchars($post['username']);?></span>
            </div>
        </div>

        <div class="post-caption-section">
            <div class="caption-content">
                <strong class="caption-username">@<?=htmlspecialchars($post['username']);?></strong>
                <span class="caption-text"><?=htmlspecialchars($post['caption']);?></span>
            </div>
        </div>

        <div class="comments-container">
            <div class="comments-header">
                <h3>Comments</h3>
            </div>
            <div class="comments-list" id="commentsList">
                <?php if(!empty($comments)): ?>
                    <?php foreach($comments as $c): ?>
                        <div class="comment-item">
                            <div class="comment-content">
                                <strong class="comment-username">@<?=htmlspecialchars($c['username']);?></strong>
                                <span class="comment-text-display"><?=htmlspecialchars($c['comment']);?></span>
                            </div>
                            <?php if(isset($_SESSION['user_id']) && $_SESSION['user_id'] == $c['user_id']): ?>
                                <a class="delete-comment-btn" href="delete_comment.php?id=<?=$c['id'];?>&post_id=<?=$post_id;?>"
                                   onclick="return confirm('Delete this comment?');" title="Delete">
                                   ×
                                </a>
                            <?php endif; ?>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="no-comments">
                        <p>No comments yet. Be the first to comment!</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <?php if(isset($_SESSION['user_id'])): ?>
            <div class="add-comment-section">
                <form action="add_comment.php" method="POST" class="comment-form-whatsapp">
                    <input type="hidden" name="post_id" value="<?=$post_id;?>">
                    <input type="text" name="comment" required placeholder="Add a comment..." class="comment-input-whatsapp" autocomplete="off">
                    <button type="submit" name="submit" class="comment-send-btn">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none">
                            <path d="M22 2L11 13" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M22 2L15 22L11 13L2 9L22 2Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </button>
                </form>
            </div>
        <?php else: ?>
            <div class="login-prompt">
                <p>Please <a href="login.php">login</a> to add a comment.</p>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php include "footer.php"; ?>
