<?php
include "header.php";
include "db.php";

if(!isset($_SESSION['user_id'])){
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

$starred_sql = "SELECT u.id, u.username FROM starred_users su 
                JOIN users u ON su.starred_user_id = u.id 
                WHERE su.user_id='$user_id' 
                ORDER BY su.created_at DESC";
$starred_result = mysqli_query($conn, $starred_sql);
$starred_users = [];
if($starred_result){
    while($s = mysqli_fetch_assoc($starred_result)){
        $starred_users[] = $s;
    }
}

$sql = "SELECT * FROM posts WHERE user_id='$user_id' ORDER BY id DESC";
$result = mysqli_query($conn, $sql);
?>

<div class="my-posts-page">
    <div class="my-page-top">
        <?php if(isset($_SESSION['username'])): ?>
        <div class="my-username-box">
            <span class="my-username-label">Traveler</span>
            <span class="my-username-value">@<?= htmlspecialchars($_SESSION['username']); ?></span>
        </div>
        <?php endif; ?>
        <div class="starred-launch">
            <button class="starred-launch-btn" onclick="openStarredOverlay()">
                <span class="starred-launch-label">Starred Users</span>
                <span class="starred-launch-count">(<?=count($starred_users);?>)</span>
            </button>
        </div>
    </div>

    <h2 class="page-title">My Adventures</h2>

    <div class="gallery-grid">

    <?php
    if(mysqli_num_rows($result) > 0){
        while($row = mysqli_fetch_assoc($result)){
    ?>
        <div class="gallery-card-compact">
            <div class="card-image-section">
                <a href="view_post.php?id=<?=$row['id'];?>">
                    <img src="uploads/<?=$row['image'];?>" alt="Image">
                </a>
            </div>
            <div class="card-location-section">
                <p class="location-only">📍 <?=htmlspecialchars($row['location']);?></p>
            </div>
            <div class="card-menu-dots" onclick="toggleMenu(<?=$row['id'];?>)">
                <span></span>
                <span></span>
                <span></span>
            </div>
            <div class="card-menu-dropdown" id="menu-<?=$row['id'];?>">
                <a href="edit_post.php?id=<?=$row['id'];?>" class="menu-item">Edit</a>
                <a href="delete_post.php?id=<?=$row['id'];?>" 
                   class="menu-item delete-item"
                   onclick="return confirm('Are you sure you want to delete this post?');">
                   Delete
                </a>
            </div>
        </div>

    <?php
        }
    } else {
        echo "<p>You haven't uploaded any photos yet.</p>";
    }
    ?>

    </div>
</div>

<div class="starred-overlay" id="starredOverlay" aria-hidden="true">
    <div class="starred-overlay-backdrop" onclick="closeStarredOverlay()"></div>
    <div class="starred-overlay-card" role="dialog" aria-modal="true">
        <div class="starred-overlay-header">
            <div class="starred-overlay-title">
                <span>Starred Users</span>
                <span class="starred-overlay-subcount"><?=count($starred_users);?> saved</span>
            </div>
            <button class="starred-overlay-close" onclick="closeStarredOverlay()">×</button>
        </div>
        <div class="starred-overlay-list">
            <?php if(!empty($starred_users)): ?>
                <?php foreach($starred_users as $su): ?>
                    <a href="index.php?search=<?=urlencode($su['username']);?>" class="starred-overlay-item">
                        <span class="starred-user-icon">👤</span>
                        <span class="starred-user-name"><?=htmlspecialchars($su['username']);?></span>
                        <span class="starred-view-hint">View</span>
                    </a>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="starred-users-empty">No starred users yet</div>
            <?php endif; ?>
        </div>
    </div>
</div>

<script>
function toggleMenu(postId) {
    const menu = document.getElementById('menu-' + postId);
    const allMenus = document.querySelectorAll('.card-menu-dropdown');
    
    allMenus.forEach(m => {
        if(m.id !== 'menu-' + postId) {
            m.classList.remove('active');
        }
    });
    
    menu.classList.toggle('active');
}

document.addEventListener('click', function(event) {
    if (!event.target.closest('.card-menu-dots') && !event.target.closest('.card-menu-dropdown')) {
        document.querySelectorAll('.card-menu-dropdown').forEach(menu => {
            menu.classList.remove('active');
        });
    }
});

function openStarredOverlay(){
    const overlay = document.getElementById('starredOverlay');
    overlay.classList.add('active');
    overlay.setAttribute('aria-hidden', 'false');
    document.body.classList.add('starred-overlay-open');
}

function closeStarredOverlay(){
    const overlay = document.getElementById('starredOverlay');
    overlay.classList.remove('active');
    overlay.setAttribute('aria-hidden', 'true');
    document.body.classList.remove('starred-overlay-open');
}

document.addEventListener('keydown', function(event) {
    if(event.key === 'Escape'){
        closeStarredOverlay();
    }
});
</script>

<?php include "footer.php"; ?>
