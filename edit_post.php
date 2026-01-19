<?php
include "header.php";
include "db.php";

if(!isset($_SESSION['user_id'])){
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

if(!isset($_GET['id'])){
    echo "<p>Invalid Post.</p>";
    include "footer.php";
    exit();
}

$post_id = $_GET['id'];

$sql = "SELECT * FROM posts WHERE id='$post_id' AND user_id='$user_id'";
$result = mysqli_query($conn, $sql);

if(mysqli_num_rows($result) == 0){
    echo "<p>You cannot edit this post.</p>";
    include "footer.php";
    exit();
}

$post = mysqli_fetch_assoc($result);

$message = "";

if(isset($_POST['update'])){

    $caption = mysqli_real_escape_string($conn, $_POST['caption']);
    $visibility = isset($_POST['visibility_value']) ? mysqli_real_escape_string($conn, $_POST['visibility_value']) : 'public';
    $location = mysqli_real_escape_string($conn, $_POST['location']);

    $update = "UPDATE posts 
               SET caption='$caption', location='$location', visibility='$visibility'
               WHERE id='$post_id' AND user_id='$user_id'";
    

    if(mysqli_query($conn, $update)){
        header("Location: my_posts.php");
        exit();
    } else {
        $message = "Error updating post.";
    }
}
?>

<div class="instagram-create-container">
    <div class="create-header">
        <h2>Edit Your Trip</h2>
    </div>

    <?php if($message != ""): ?>
        <div class="create-message">
            <p class="<?=strpos($message, 'successfully') !== false ? 'success-box' : 'error-box';?>"><?=$message;?></p>
        </div>
    <?php endif; ?>

    <form action="" method="POST" class="create-post-form">
        <div class="create-content-wrapper">
            <div class="create-image-section">
                <div class="image-upload-area">
                    <img src="uploads/<?=$post['image'];?>" id="imagePreview" alt="Current Image" style="width: 100%; height: 100%; object-fit: contain;">
                </div>
            </div>

            <div class="create-details-section">
                <div class="create-form-group">
                    <label for="caption">Caption</label>
                    <textarea name="caption" id="caption" placeholder="Write a caption..." required rows="4"><?=htmlspecialchars($post['caption']);?></textarea>
                </div>

                <div class="create-form-group">
                    <label for="location">📍 Location</label>
                    <input type="text" name="location" id="location" value="<?=htmlspecialchars($post['location']);?>" required>
                </div>

                <div class="create-form-group">
                    <label class="toggle-label">
                        <span>🔒 Make Private</span>
                        <input type="checkbox" name="visibility" id="visibility" value="private" class="toggle-input" <?=$post['visibility']=="private" ? "checked" : "";?>>
                        <span class="toggle-slider"></span>
                    </label>
                    <input type="hidden" name="visibility_value" id="visibility_value" value="<?=$post['visibility'];?>">
                </div>

                <button type="submit" name="update" class="create-submit-btn">
                    <span>Update Post</span>
                </button>
            </div>
        </div>
    </form>
</div>

<script>
document.getElementById('visibility').addEventListener('change', function(e) {
    document.getElementById('visibility_value').value = e.target.checked ? 'private' : 'public';
});
</script>

<?php include "footer.php"; ?>
