<?php
include "header.php";
include "db.php";

if(!isset($_SESSION['user_id'])){
    header("Location: login.php");
    exit();
}

$message = "";

if(isset($_POST['submit'])){

    $caption = mysqli_real_escape_string($conn, $_POST['caption']);
    $location = mysqli_real_escape_string($conn, $_POST['location']);
    $visibility = isset($_POST['visibility_value']) ? mysqli_real_escape_string($conn, $_POST['visibility_value']) : 'public';
    $user_id = $_SESSION['user_id'];

    $imageName = $_FILES['image']['name'];
    $imageTmp = $_FILES['image']['tmp_name'];
    $uploadPath = "uploads/" . $imageName;

    $allowed = ['jpg','jpeg','png','gif'];
    $ext = strtolower(pathinfo($imageName, PATHINFO_EXTENSION));

    if(!in_array($ext, $allowed)){
        $message = "Only JPG, JPEG, PNG, GIF allowed.";
    } else {
        if(move_uploaded_file($imageTmp, $uploadPath)){
            
            $sql = "INSERT INTO posts (user_id, image, caption, location, visibility)
                    VALUES ('$user_id', '$imageName', '$caption', '$location', '$visibility')";
            
            if(mysqli_query($conn, $sql)){
                header("Location: my_posts.php");
                exit();
            } else {
                $message = "Database Error: " . mysqli_error($conn);
            }

        } else {
            $message = "Image upload failed.";
        }
    }
}
?>

<div class="instagram-create-container">
    <div class="create-header">
        <h2>Share Your Trip</h2>
    </div>

    <?php if($message != ""): ?>
        <div class="create-message">
            <p class="<?=strpos($message, 'successfully') !== false ? 'success-box' : 'error-box';?>"><?= $message ?></p>
        </div>
    <?php endif; ?>

    <form action="" method="POST" enctype="multipart/form-data" class="create-post-form" id="createPostForm">
        <div class="create-content-wrapper">
            <div class="create-image-section">
                <div class="image-upload-area" id="imageUploadArea">
                    <input type="file" name="image" id="imageInput" accept="image/*" required style="display: none;">
                    <label for="imageInput" class="upload-label">
                        <svg width="64" height="64" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <rect x="3" y="3" width="18" height="18" rx="2" ry="2"/>
                            <circle cx="8.5" cy="8.5" r="1.5"/>
                            <polyline points="21 15 16 10 5 21"/>
                        </svg>
                        <span>Select Image</span>
                    </label>
                    <img id="imagePreview" style="display: none; width: 100%; height: 100%; object-fit: contain;">
                </div>
            </div>

            <div class="create-details-section">
                <div class="create-form-group">
                    <label for="caption">Caption</label>
                    <textarea name="caption" id="caption" placeholder="Write a caption..." required rows="4"></textarea>
                </div>

                <div class="create-form-group">
                    <label for="location">📍 Location</label>
                    <input type="text" name="location" id="location" placeholder="Eg: Kerala, Goa, Mumbai..." required>
                </div>

                <div class="create-form-group">
                    <label class="toggle-label">
                        <span>🔒 Make Private</span>
                        <input type="checkbox" name="visibility" id="visibility" value="private" class="toggle-input">
                        <span class="toggle-slider"></span>
                    </label>
                    <input type="hidden" name="visibility_value" id="visibility_value" value="public">
                </div>

                <button type="submit" name="submit" class="create-submit-btn">
                    <span>Share</span>
                </button>
            </div>
        </div>
    </form>
</div>

<script>
document.getElementById('imageInput').addEventListener('change', function(e) {
    const file = e.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            const preview = document.getElementById('imagePreview');
            const uploadArea = document.getElementById('imageUploadArea');
            preview.src = e.target.result;
            preview.style.display = 'block';
            uploadArea.querySelector('.upload-label').style.display = 'none';
        };
        reader.readAsDataURL(file);
    }
});

document.getElementById('visibility').addEventListener('change', function(e) {
    document.getElementById('visibility_value').value = e.target.checked ? 'private' : 'public';
});
</script>

<?php include "footer.php"; ?>
