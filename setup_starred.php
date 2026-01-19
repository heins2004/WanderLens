<?php
include "db.php";

$sql = "CREATE TABLE IF NOT EXISTS starred_users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    starred_user_id INT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (starred_user_id) REFERENCES users(id) ON DELETE CASCADE,
    UNIQUE KEY unique_star (user_id, starred_user_id)
)";

if(mysqli_query($conn, $sql)){
    echo "Starred users table created successfully!";
} else {
    echo "Error creating starred_users table: " . mysqli_error($conn);
}
?>




