<?php 
include 'db.php'; 
if (!isset($_SESSION['user_id'])) { header("Location: login.php"); exit(); }

$uid = $_SESSION['user_id'];
$message = "";

$user_q = mysqli_query($conn, "SELECT max_units FROM users WHERE id = $uid");
$user_data = mysqli_fetch_assoc($user_q);
$max_allowed = $user_data['max_units'];

$current_units_q = mysqli_query($conn, "SELECT SUM(s.units) as total FROM enrollments e JOIN subjects s ON e.subject_id = s.id WHERE e.user_id = $uid");
$unit_data = mysqli_fetch_assoc($current_units_q);
$units_current = $unit_data['total'] ?? 0;

$units_requested = 0; // In a full system, this would track "cart" items
$units_projected = $units_current + $units_requested;
$is_overload = ($units_projected > $max_allowed);

if (isset($_POST['request_override'])) {
    $reason = "Auto-requested via calculation panel";
    $req_units = $units_projected + 3; // Requesting a bump
    mysqli_query($conn, "INSERT INTO overload_requests (user_id, requested_units, reason, status) VALUES ($uid, $req_units, '$reason', 'pending')");
    $message = "Request submitted to Admin.";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Unit Load Calculation | CIT-U</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        body { display: flex; font-family: 'Inter', sans-serif; background: #f8f9fa; margin: 0; }
        .main-content { flex: 1; padding: 40px; }
        .calc-header h1 { margin: 0; font-size: 32px; font-weight: 700; }
        .calc-header p { color: #888; font-size: 14px; }
        
        .stats-grid { display: flex; gap: 20px; margin: 30px 0; }
        .stat-card { flex: 1; background: white; padding: 20px; border-radius: 15px; border-top: 4px solid #ddd; box-shadow: 0 2px 10px rgba(0,0,0,0.02); }
        .card-red { border-top-color: #A3262A; }
        .card-green { border-top-color: #27ae60; }
        .stat-val { font-size: 36px; font-weight: 700; color: #A3262A; }
        .stat-label { font-size: 14px; font-weight: 700; }

        .warning-box { background: #FFF9E6; border: 1px solid #FFE6A1; padding: 15px; border-radius: 10px; display: flex; align-items: center; gap: 10px; margin-bottom: 30px; font-size: 14px; }
        
        .gauge-container { background: white; padding: 30px; border-radius: 15px; display: flex; justify-content: space-between; align-items: center; }
        .gauge-bar { flex: 1; height: 12px; background: #eee; border-radius: 6px; overflow: hidden; position: relative; max-width: 500px;}
        .gauge-fill { height: 100%; background: #A3262A; width: <?php echo ($units_projected / 24) * 100; ?>%; }
        
        .btn-request { background: #BD6E6E; color: white; padding: 15px 30px; border-radius: 10px; text-decoration: none; font-weight: 600; border: none; cursor: pointer; }
    </style>
</head>
<body>
    <?php include 'includes/sidebar.php'; ?>
    <main class="main-content">
        <div class="calc-header">
            <h1>Unit Load Calculation</h1>
            <p>AY 2025–2026 • Semester 2 • BS Computer Science • 2nd Year</p>
        </div>

        <div class="stats-grid">
            <div class="stat-card card-red"><div class="stat-val"><?php echo $units_requested; ?></div><div class="stat-label">Units Requested</div></div>
            <div class="stat-card card-green"><div class="stat-val" style="color:#27ae60"><?php echo $units_current; ?></div><div class="stat-label">Units Current</div></div>
            <div class="stat-card card-gold"><div class="stat-val" style="color:#f1c40f"><?php echo $units_projected; ?></div><div class="stat-label">Units Projected</div></div>
            <div class="stat-card"><div class="stat-val" style="color:#333"><?php echo $max_allowed; ?></div><div class="stat-label">Max Allowed</div></div>
        </div>

        <?php if($is_overload): ?>
        <div class="warning-box">
            <span>⚠️</span>
            <div><strong>Overload Warning.</strong> Admin Override Required.</div>
        </div>
        <?php endif; ?>

        <div class="gauge-container">
            <div>
                <h3 style="margin:0 0 10px 0;">Unit Load Gauge</h3>
                <div class="gauge-bar"><div class="gauge-fill"></div></div>
                <div style="display:flex; justify-content: space-between; margin-top:10px; font-size:12px; color:#888;">
                    <span>units</span>
                    <span style="color:#A3262A; font-weight:bold;"><?php echo $is_overload ? 'FULL / OVERLOAD' : 'NORMAL'; ?></span>
                </div>
            </div>
            
            <form method="POST">
                <button type="submit" name="request_override" class="btn-request">Request Overload Override</button>
            </form>
        </div>
        <p><?php echo $message; ?></p>
    </main>
</body>
</html>