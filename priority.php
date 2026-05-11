<?php 
include 'db.php'; 
if (!isset($_SESSION['user_id'])) { header("Location: login.php"); exit(); }

// Simulated Windows
$window_a_time = "2026-05-15 08:00:00";
$now = new DateTime();
$target = new DateTime($window_a_time);
$interval = $now->diff($target);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Priority Enrollment | CIT-U</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        body { display: flex; font-family: 'Inter', sans-serif; background: #f8f9fa; margin: 0; }
        .main-content { flex: 1; padding: 40px; }
        .header h1 { margin: 0; font-size: 32px; font-weight: 700; }
        .header p { color: #888; font-size: 14px; }

        .countdown-card { background: #FFF0F0; border: 1px solid #FFD1D1; padding: 40px; border-radius: 20px; display: flex; justify-content: space-between; align-items: center; margin-top: 30px; }
        .timer { font-size: 64px; font-weight: 800; color: #333; margin: 10px 0; }
        
        .window-item { background: white; padding: 20px; border-radius: 15px; margin-bottom: 15px; display: flex; justify-content: space-between; align-items: center; border-left: 5px solid #eee; }
        .active-window { border-left-color: #27ae60; }
        .btn-browse { background: #BD6E6E; color: white; padding: 15px 30px; border-radius: 10px; text-decoration: none; font-weight: 600; }
    </style>
</head>
<body>
    <?php include 'includes/sidebar.php'; ?>
    <main class="main-content">
        <div class="header">
            <h1>Priority Enrollment Window</h1>
            <p>AY 2025–2026 • Semester 2 - Assigned by Administrator</p>
        </div>

        <div class="countdown-card">
            <div>
                <span style="font-weight: 600; font-size: 18px;">Your window (Type A) opens in:</span>
                <div class="timer"><?php echo $interval->format('%H:%I:%S'); ?></div>
                <span style="color: #888;">Graduating/Honors • Jan 15, 2026 • 8:00 AM</span>
            </div>
            <a href="enrollment.php" class="btn-browse">Browse Courses →</a>
        </div>

        <h3 style="margin-top: 40px;">Enrollment Windows</h3>
        
        <div class="window-item active-window">
            <div>
                <strong>Type A - Graduating & Honors</strong><br>
                <small>Assigned by Admin • Ramos • BR-PW3</small>
            </div>
            <div style="text-align: right">
                <span style="color: #27ae60; font-weight:bold;">• Active</span><br>
                <small>Jan 15 • 8:00 - 5:00 PM</small>
            </div>
        </div>

        <div class="window-item">
            <div>
                <strong>Type B - 3rd & 4th Year</strong><br>
                <small>Assigned by Admin • Ramos • BR-PW3</small>
            </div>
            <div style="text-align: right">
                <span style="color: #f1c40f; font-weight:bold;">• Upcoming</span><br>
                <small>Jan 16 • 8:00 - 5:00 PM</small>
            </div>
        </div>
    </main>
</body>
</html>