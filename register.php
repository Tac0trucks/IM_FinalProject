<?php
include 'db.php';

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = $_POST['password'];

    // 1. Check if user already exists
    $check = "SELECT * FROM users WHERE username='$username' OR email='$email'";
    $result = mysqli_query($conn, $check);

    if (mysqli_num_rows($result) > 0) {
        $message = "<p style='color:red;'>Username or Email already taken!</p>";
    } else {
        // 2. Hash password for security
        $hashed_pass = password_hash($password, PASSWORD_DEFAULT);

        // 3. Insert into database
        $sql = "INSERT INTO users (username, email, password) VALUES ('$username', '$email', '$hashed_pass')";
        
        if (mysqli_query($conn, $sql)) {
            $message = "<p style='color:green;'>Registration successful! <a href='login.php'>Login here</a></p>";
        } else {
            $message = "<p style='color:red;'>Error: " . mysqli_error($conn) . "</p>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Register | CIT University</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; background-color: #fcfcfc; display: flex; justify-content: center; align-items: center; height: 100vh; margin: 0; }
        .card { background: white; padding: 40px; border-radius: 20px; box-shadow: 0 15px 35px rgba(0,0,0,0.1); width: 100%; max-width: 400px; text-align: center; }
        .card h2 { color: #A3262A; margin-bottom: 20px; }
        input { width: 100%; padding: 12px; margin: 10px 0; border: 1px solid #ddd; border-radius: 10px; box-sizing: border-box; }
        .btn-reg { background: #A3262A; color: white; border: none; padding: 14px; width: 100%; border-radius: 10px; cursor: pointer; font-weight: bold; font-size: 16px; margin-top: 10px; }
        .btn-reg:hover { background: #8e2125; }
        a { color: #A3262A; text-decoration: none; font-weight: 600; }
    </style>
</head>
<body>
    <div class="card">
        <img src="/assets/cit-logo.png" alt="CIT Logo" style="height: 60px; margin-bottom: 10px;">
        <h2>Create Account</h2>
        <?php echo $message; ?>
        <form method="POST">
            <input type="text" name="username" placeholder="Username" required>
            <input type="email" name="email" placeholder="Email Address" required>
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit" class="btn-reg">Register</button>
        </form>
        <p style="margin-top: 20px; font-size: 14px; color: #777;">Already have an account? <a href="login.php">Login</a></p>
    </div>
</body>
</html>