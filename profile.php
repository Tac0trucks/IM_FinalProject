<?php 
include 'db.php'; // Updated path

if (!isset($_SESSION['user_id'])) { header("Location: login.php"); exit(); }

$uid = $_SESSION['user_id'];
$message = "";

// 1. Fetch current user data
$user_q = mysqli_query($conn, "SELECT * FROM users WHERE id = $uid");
$user = mysqli_fetch_assoc($user_q);

// 2. Handle Password Update
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update_password'])) {
    $new_pass = $_POST['new_password'];
    $confirm_pass = $_POST['confirm_password'];

    if ($new_pass !== $confirm_pass) {
        $message = "<div style='color:red; margin-bottom:15px;'>Passwords do not match!</div>";
    } else {
        $hashed = password_hash($new_pass, PASSWORD_DEFAULT);
        mysqli_query($conn, "UPDATE users SET password = '$hashed' WHERE id = $uid");
        $message = "<div style='color:green; margin-bottom:15px;'>Password updated successfully!</div>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>My Profile | CIT-U</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        body { display: flex; font-family: 'Inter', sans-serif; background: #f8f9fa; margin: 0; }
        .main-content { flex: 1; padding: 40px; }
        .profile-container { display: grid; grid-template-columns: 1fr 1fr; gap: 30px; }
        .card { background: white; padding: 30px; border-radius: 15px; box-shadow: 0 4px 15px rgba(0,0,0,0.05); }
        .card h2 { color: #A3262A; font-size: 18px; border-bottom: 2px solid #f4f4f4; padding-bottom: 15px; margin-bottom: 20px; }
        .info-group { margin-bottom: 20px; }
        .info-group label { display: block; font-size: 12px; color: #aaa; text-transform: uppercase; margin-bottom: 5px; }
        .info-group p { font-size: 16px; font-weight: 600; color: #333; margin: 0; }
        input { width: 100%; padding: 12px; margin: 10px 0; border: 1px solid #ddd; border-radius: 8px; box-sizing: border-box; }
        .btn-update { background: #A3262A; color: white; border: none; padding: 12px 25px; border-radius: 8px; cursor: pointer; font-weight: bold; width: 100%; }
    </style>
</head>
<body>
    <?php include 'includes/sidebar.php'; ?>

    <main class="main-content">
        <h1>My Profile</h1>
        <?php echo $message; ?>

        <div class="profile-container">
            <!-- Account Information -->
            <div class="card">
                <h2>Account Details</h2>
                <div class="info-group">
                    <label>Username</label>
                    <p><?php echo $user['username']; ?></p>
                </div>
                <div class="info-group">
                    <label>Email Address</label>
                    <p><?php echo $user['email']; ?></p>
                </div>
                <div class="info-group">
                    <label>Account Role</label>
                    <p style="text-transform: capitalize;"><?php echo $user['role']; ?></p>
                </div>
                <div class="info-group">
                    <label>Student ID</label>
                    <p>#CIT-2025-<?php echo $user['id']; ?></p>
                </div>
            </div>

            <!-- Security / Password Update -->
            <div class="card">
                <h2>Security</h2>
                <form method="POST">
                    <div class="info-group">
                        <label>New Password</label>
                        <input type="password" name="new_password" placeholder="Enter new password" required>
                    </div>
                    <div class="info-group">
                        <label>Confirm New Password</label>
                        <input type="password" name="confirm_password" placeholder="Repeat new password" required>
                    </div>
                    <button type="submit" name="update_password" class="btn-update">Update Password</button>
                </form>
            </div>
        </div>
    </main>
</body>
</html>