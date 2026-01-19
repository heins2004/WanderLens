<?php
include 'header.php';
include 'db.php';

if(!isset($_SESSION['user_id'])){
    header("Location: login.php");
    exit();
}

$search_query = isset($_GET['search']) ? trim($_GET['search']) : '';
$search_type = '';
$search_results = [];
$searched_user_id = 0;
$searched_username = '';

if(!empty($search_query)) {

    if(strpos($search_query, '#') === 0) {

        $location = mysqli_real_escape_string($conn, substr($search_query, 1));
        $search_type = 'location';

        $sql = "SELECT posts.*, users.username 
                FROM posts 
                JOIN users ON posts.user_id = users.id
                WHERE posts.location LIKE '%$location%'
                AND (posts.visibility='public' OR posts.user_id='{$_SESSION['user_id']}')
                ORDER BY posts.id DESC";

        $result = mysqli_query($conn, $sql);
        while($result && $row = mysqli_fetch_assoc($result)) {
            $search_results[] = $row;
        }
    }

    else {

        $username = mysqli_real_escape_string($conn, $search_query);
        $search_type = 'user';

        $user_sql = "SELECT id, username FROM users WHERE username LIKE '%$username%' LIMIT 1";
        $user_result = mysqli_query($conn, $user_sql);

        if($user_result && mysqli_num_rows($user_result) > 0) {

            $row = mysqli_fetch_assoc($user_result);
            $searched_user_id = $row['id'];
            $searched_username = $row['username'];

            $sql = "SELECT posts.*, users.username 
                    FROM posts 
                    JOIN users ON posts.user_id = users.id
                    WHERE posts.user_id='$searched_user_id'
                    AND (posts.visibility='public' OR posts.user_id='{$_SESSION['user_id']}')
                    ORDER BY posts.id DESC";

            $result = mysqli_query($conn, $sql);
            while($result && $row = mysqli_fetch_assoc($result)) {
                $search_results[] = $row;
            }
        }
    }
}

$starred_check = [];
if($searched_user_id > 0){
    $star_sql = "SELECT starred_user_id FROM starred_users 
                 WHERE user_id='{$_SESSION['user_id']}'
                 AND starred_user_id='$searched_user_id'";

    $star_result = mysqli_query($conn, $star_sql);
    $starred_check[$searched_user_id] = mysqli_num_rows($star_result) > 0;
}
?>

<div class="main-content-area" id="mainContent">

    <div class="slideshow-container">
        <div class="slideshow-wrapper">

            <div class="slide active"
                 style="background-image: url('https://images.unsplash.com/photo-1502602898657-3e91760cbb34?w=1200&q=80&auto=format&fit=crop'); cursor: pointer;"
                 onclick="window.location.href='index.php?search=' + encodeURIComponent('#Paris, France')">
                <div class="slide-content-bottom"><h2>Paris, France – Eiffel Tower</h2></div>
            </div>

            <div class="slide"
                 style="background-image: url('https://images.unsplash.com/photo-1477959858617-67f85cf4f1df?w=1200&q=80&auto=format&fit=crop'); cursor: pointer;"
                 onclick="window.location.href='index.php?search=' + encodeURIComponent('#New York, USA')">
                <div class="slide-content-bottom"><h2>New York, USA – Times Square</h2></div>
            </div>

            <div class="slide"
                 style="background-image: url('https://images.unsplash.com/photo-1469474968028-56623f02e42e?w=1200&q=80&auto=format&fit=crop'); cursor: pointer;"
                 onclick="window.location.href='index.php?search=' + encodeURIComponent('#London, UK')">
                <div class="slide-content-bottom"><h2>London, UK – Big Ben</h2></div>
            </div>

            <div class="slide"
                 style="background-image: url('https://images.unsplash.com/photo-1549692520-acc6669e2f0c?w=1200&q=80&auto=format&fit=crop'); cursor: pointer;"
                 onclick="window.location.href='index.php?search=' + encodeURIComponent('#Tokyo, Japan')">
                <div class="slide-content-bottom"><h2>Tokyo, Japan – Shibuya Crossing</h2></div>
            </div>

            <div class="slide"
                 style="background-image: url('https://images.unsplash.com/photo-1506973035872-a4ec16b8e8d9?w=1200&q=80&auto=format&fit=crop'); cursor: pointer;"
                 onclick="window.location.href='index.php?search=' + encodeURIComponent('#Sydney, Australia')">
                <div class="slide-content-bottom"><h2>Sydney, Australia – Opera House</h2></div>
            </div>

            <div class="slide"
                 style="background-image: url('https://images.unsplash.com/photo-1438283173091-5dbf5c5a3206?w=1200&q=80&auto=format&fit=crop'); cursor: pointer;"
                 onclick="window.location.href='index.php?search=' + encodeURIComponent('#Dubai, UAE')">
                <div class="slide-content-bottom"><h2>Dubai, UAE – Burj Khalifa</h2></div>
            </div>

            <div class="slide"
                 style="background-image: url('https://images.unsplash.com/photo-1483721310020-03333e577078?w=1200&q=80&auto=format&fit=crop'); cursor: pointer;"
                 onclick="window.location.href='index.php?search=' + encodeURIComponent('#Rio de Janeiro, Brazil')">
                <div class="slide-content-bottom"><h2>Rio de Janeiro, Brazil – Christ the Redeemer</h2></div>
            </div>

            <div class="slide"
                 style="background-image: url('https://images.unsplash.com/photo-1526481280695-3c687fd543c0?w=1200&q=80&auto=format&fit=crop'); cursor: pointer;"
                 onclick="window.location.href='index.php?search=' + encodeURIComponent('#Rome, Italy')">
                <div class="slide-content-bottom"><h2>Rome, Italy – Colosseum</h2></div>
            </div>

            <div class="slide"
                 style="background-image: url('https://images.unsplash.com/photo-1506439772285-413bf058f6c5?w=1200&q=80&auto=format&fit=crop'); cursor: pointer;"
                 onclick="window.location.href='index.php?search=' + encodeURIComponent('#Santorini, Greece')">
                <div class="slide-content-bottom"><h2>Santorini, Greece</h2></div>
            </div>

            <div class="slide"
                 style="background-image: url('https://images.unsplash.com/photo-1500534314211-0a24cd03f2c0?w=1200&q=80&auto=format&fit=crop'); cursor: pointer;"
                 onclick="window.location.href='index.php?search=' + encodeURIComponent('#Bali, Indonesia')">
                <div class="slide-content-bottom"><h2>Bali, Indonesia</h2></div>
            </div>

            <div class="slide"
                 style="background-image: url('https://images.unsplash.com/photo-1500375592092-40eb2168fd21?w=1200&q=80&auto=format&fit=crop'); cursor: pointer;"
                 onclick="window.location.href='index.php?search=' + encodeURIComponent('#Maldives')">
                <div class="slide-content-bottom"><h2>Maldives</h2></div>
            </div>

            <div class="slide"
                 style="background-image: url('https://images.unsplash.com/photo-1519681393784-d120267933ba?w=1200&q=80&auto=format&fit=crop'); cursor: pointer;"
                 onclick="window.location.href='index.php?search=' + encodeURIComponent('#Swiss Alps, Switzerland')">
                <div class="slide-content-bottom"><h2>Swiss Alps, Switzerland</h2></div>
            </div>

            <div class="slide"
                 style="background-image: url('https://images.unsplash.com/photo-1582719478250-c89cae4dc85b?w=1200&q=80&auto=format&fit=crop'); cursor: pointer;"
                 onclick="window.location.href='index.php?search=' + encodeURIComponent('#Great Wall of China')">
                <div class="slide-content-bottom"><h2>Great Wall of China</h2></div>
            </div>

            <div class="slide"
                 style="background-image: url('https://images.unsplash.com/photo-1519681392709-870f97e5c82b?w=1200&q=80&auto=format&fit=crop'); cursor: pointer;"
                 onclick="window.location.href='index.php?search=' + encodeURIComponent('#Machu Picchu, Peru')">
                <div class="slide-content-bottom"><h2>Machu Picchu, Peru</h2></div>
            </div>

            <div class="slide"
                 style="background-image: url('https://images.unsplash.com/photo-1516574187841-cb9cc2ca948b?w=1200&q=80&auto=format&fit=crop'); cursor: pointer;"
                 onclick="window.location.href='index.php?search=' + encodeURIComponent('#Grand Canyon, USA')">
                <div class="slide-content-bottom"><h2>Grand Canyon, USA</h2></div>
            </div>

        </div>

        <div class="slideshow-indicators"></div>
    </div>
</div>


<?php if(!empty($search_query)): ?>
<div class="search-overlay">

    <div class="overlay-backdrop" onclick="window.location.href='index.php'"></div>

    <div class="overlay-content-full-width">

        <div class="overlay-header">
            <div class="overlay-title-section">

                <?php if($search_type == 'location'): ?>
                    <h2 class="overlay-title">📍 <?= htmlspecialchars(substr($search_query,1)) ?></h2>

                <?php else: ?>
                    <h2 class="overlay-title">👤 <?= htmlspecialchars($searched_username ?: $search_query) ?></h2>

                    <?php if($searched_user_id > 0): ?>
                    <button class="star-user-btn <?= ($starred_check[$searched_user_id]??false)?'starred':'' ?>"
                            onclick="toggleStar(this, <?= $searched_user_id ?>)">
                        ⭐
                    </button>
                    <?php endif; ?>

                <?php endif; ?>

            </div>

            <a href="index.php" class="close-overlay">×</a>
        </div>

        <div class="overlay-gallery">
            <?php if(!empty($search_results)): ?>
                <?php foreach($search_results as $row): ?>
                <div class="gallery-card-compact">
                    <div class="card-image-section">
                        <a href="view_post.php?id=<?= $row['id'] ?>">
                            <img src="uploads/<?= $row['image'] ?>" alt="">
                        </a>
                    </div>
                    <div class="card-location-section">
                        <p class="location-only">📍 <?= htmlspecialchars($row['location']) ?></p>
                    </div>
                </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p class="no-results">No results found.</p>
            <?php endif; ?>
        </div>

    </div>

</div>
<?php endif; ?>


<script>
document.addEventListener('DOMContentLoaded', () => {

    const slides = document.querySelectorAll('.slide');
    const dotsContainer = document.querySelector('.slideshow-indicators');
    let current = 0;

    slides.forEach((_, i) => {
        const dot = document.createElement('span');
        if(i === 0) dot.classList.add('active');
        dot.onclick = () => goTo(i);
        dotsContainer.appendChild(dot);
    });

    const dots = dotsContainer.querySelectorAll('span');

    function showSlide(i){
        slides.forEach(s => s.classList.remove('active'));
        dots.forEach(d => d.classList.remove('active'));

        slides[i].classList.add('active');
        dots[i].classList.add('active');
    }

    function next(){
        current = (current + 1) % slides.length;
        showSlide(current);
    }

    function goTo(i){
        current = i;
        showSlide(i);
    }

    setInterval(next, 4000);
    showSlide(0);
});

function toggleStar(btn, id){
    const form = new FormData();
    form.append('starred_user_id', id);
    form.append('action', btn.classList.contains('starred') ? 'unstar' : 'star');

    fetch('star_user.php', { method:'POST', body:form })
    .then(r => r.json())
    .then(data => {
        if(data.success){
            btn.classList.toggle('starred', data.starred);
        }
    });
}
</script>

<?php include 'footer.php'; ?>
