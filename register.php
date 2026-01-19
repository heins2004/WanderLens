<?php
include "db.php";
include "header.php";

$message = "";

if(isset($_POST['register'])){

    $fname = mysqli_real_escape_string($conn, $_POST['fname']);
    $lname = mysqli_real_escape_string($conn, $_POST['lname']);
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);
    $password = $_POST['password'];
    $cpassword = $_POST['cpassword'];

    if($password != $cpassword){
        $message = "Passwords do not match!";
    } else {

        $check = mysqli_query($conn, "SELECT * FROM users WHERE email='$email'");
        if(mysqli_num_rows($check) > 0){
            $message = "Email already registered!";
        } else {

            $hashed_pass = password_hash($password, PASSWORD_DEFAULT);

            $sql = "INSERT INTO users (fname, lname, username, email, phone, password)
                    VALUES ('$fname', '$lname', '$username', '$email', '$phone', '$hashed_pass')";

            if(mysqli_query($conn, $sql)){
                $message = "Registration successful! You can log in now.";
            } else {
                $message = "Error: " . mysqli_error($conn);
            }
        }
    }
}
?>

<div class="auth-container">
    <div class="auth-card register-card">
        <div class="auth-header">
            <div class="auth-icon">
                <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                    <circle cx="8.5" cy="7" r="4"></circle>
                    <line x1="20" y1="8" x2="20" y2="14"></line>
                    <line x1="23" y1="11" x2="17" y2="11"></line>
                </svg>
            </div>
            <h2 class="auth-title">Join WanderLens</h2>
            <p class="auth-subtitle">Start sharing your travel adventures</p>
        </div>

        <?php if($message != ""): ?>
            <div class="auth-message <?=strpos($message, 'successful') !== false ? 'success' : 'error';?>">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <?php if(strpos($message, 'successful') !== false): ?>
                        <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
                        <polyline points="22 4 12 14.01 9 11.01"></polyline>
                    <?php else: ?>
                        <circle cx="12" cy="12" r="10"></circle>
                        <line x1="12" y1="8" x2="12" y2="12"></line>
                        <line x1="12" y1="16" x2="12.01" y2="16"></line>
                    <?php endif; ?>
                </svg>
                <span><?php echo $message; ?></span>
            </div>
        <?php endif; ?>

        <form action="" method="POST" class="auth-form">
            <div class="form-row">
                <div class="form-group">
                    <label for="fname">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                            <circle cx="12" cy="7" r="4"></circle>
                        </svg>
                        First Name
                    </label>
                    <input type="text" id="fname" name="fname" placeholder="John" required>
                </div>

                <div class="form-group">
                    <label for="lname">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                            <circle cx="12" cy="7" r="4"></circle>
                        </svg>
                        Last Name
                    </label>
                    <input type="text" id="lname" name="lname" placeholder="Doe" required>
                </div>
            </div>

            <div class="form-group">
                <label for="username">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                        <circle cx="12" cy="7" r="4"></circle>
                    </svg>
                    Username
                </label>
                <input type="text" id="username" name="username" placeholder="johndoe" required>
            </div>

            <div class="form-group">
                <label for="email">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path>
                        <polyline points="22,6 12,13 2,6"></polyline>
                    </svg>
                    Email
                </label>
                <input type="email" id="email" name="email" placeholder="john@example.com" required>
            </div>

            <div class="form-group">
                <label for="phone">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path>
                    </svg>
                    Phone Number
                </label>
                <input type="text" id="phone" name="phone" placeholder="+1234567890" required>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="password">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect>
                            <path d="M7 11V7a5 5 0 0 1 10 0v4"></path>
                        </svg>
                        Password
                    </label>
                    <input type="password" id="password" name="password" placeholder="••••••••" required>
                </div>

                <div class="form-group">
                    <label for="cpassword">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect>
                            <path d="M7 11V7a5 5 0 0 1 10 0v4"></path>
                        </svg>
                        Confirm Password
                    </label>
                    <input type="password" id="cpassword" name="cpassword" placeholder="••••••••" required>
                </div>
            </div>

            <button type="submit" name="register" class="auth-btn">
                <span>Create Account</span>
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M5 12h14M12 5l7 7-7 7"></path>
                </svg>
            </button>
        </form>

        <div class="auth-footer">
            <p>Already have an account? <a href="login.php">Sign in</a></p>
        </div>
    </div>
</div>

<?php include "footer.php"; ?>
