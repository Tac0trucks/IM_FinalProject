<?php 
include 'db.php'; 

if (!isset($_SESSION['user_id'])) { header("Location: login.php"); exit(); }

$uid = $_SESSION['user_id'];
$message = "";

// 1. Get Student's Current Stats
$user_q = mysqli_query($conn, "SELECT max_units FROM users WHERE id = $uid");
$user_data = mysqli_fetch_assoc($user_q);
$max_allowed = $user_data['max_units'];

// Calculate currently enrolled units
$current_units_q = mysqli_query($conn, "SELECT SUM(s.units) as total FROM enrollments e JOIN subjects s ON e.subject_id = s.id WHERE e.user_id = $uid");
$unit_data = mysqli_fetch_assoc($current_units_q);
$current_total = $unit_data['total'] ?? 0;

// 2. LOGIC: Handle Adding a Subject
if (isset($_GET['add_id'])) {
    $sid = $_GET['add_id'];

    // Get units of the subject they want to add
    $sub_q = mysqli_query($conn, "SELECT units FROM subjects WHERE id = $sid");
    $sub_data = mysqli_fetch_assoc($sub_q);
    $sub_units = $sub_data['units'];

    // Check for Duplicates
    $dup_check = mysqli_query($conn, "SELECT id FROM enrollments WHERE user_id = $uid AND subject_id = $sid");
    
    if (mysqli_num_rows($dup_check) > 0) {
        $message = "<div style='color:orange;'>You are already enrolled in this subject.</div>";
    } elseif (($current_total + $sub_units) > $max_allowed) {
        // CHECK MAX UNITS
        $message = "<div style='color:red;'>Failed: You would exceed your limit of $max_allowed units. Request an override from Admin.</div>";
    } else {
        mysqli_query($conn, "INSERT INTO enrollments (user_id, subject_id) VALUES ($uid, $sid)");
        header("Location: enrollment.php?success=1");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Self-Enrollment | CIT-U</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        body { display: flex; font-family: 'Inter', sans-serif; background: #f8f9fa; margin: 0; }
        .main-content { flex: 1; padding: 40px; }
        .stats-bar { background: white; padding: 20px; border-radius: 12px; display: flex; gap: 40px; margin-bottom: 30px; box-shadow: 0 2px 10px rgba(0,0,0,0.05); }
        .stat-item b { color: #A3262A; font-size: 20px; }
        table { width: 100%; border-collapse: collapse; background: white; border-radius: 10px; overflow: hidden; }
        th, td { padding: 15px; text-align: left; border-bottom: 1px solid #eee; }
        th { background: #fdfdfd; color: #888; font-size: 12px; text-transform: uppercase; }
        .btn-add { background: #A3262A; color: white; padding: 8px 15px; border-radius: 5px; text-decoration: none; font-size: 13px; font-weight: bold; }
    </style>
</head>
<body>
    <?php include 'includes/sidebar.php'; ?>

    <main class="main-content">
        <h1>Self-Enrollment</h1>
        
        <div class="stats-bar">
            <div class="stat-item">Current Units: <b><?php echo $current_total; ?></b></div>
            <div class="stat-item">Max Allowed: <b><?php echo $max_allowed; ?></b></div>
            <div class="stat-item">Available: <b><?php echo ($max_allowed - $current_total); ?></b></div>
        </div>

        <?php echo $message; ?>
        <?php if(isset($_GET['success'])) echo "<div style='color:green; margin-bottom:15px;'>Subject added successfully!</div>"; ?>

        <table>
            <thead>
                <tr>
                    <th>Code</th>
                    <th>Subject Name</th>
                    <th>Units</th>
                    <th>Schedule</th>
                    <th>Room</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                $all_subs = mysqli_query($conn, "SELECT * FROM subjects");
                while($s = mysqli_fetch_assoc($all_subs)): 
                ?>
                <tr>
                    <td><strong><?php echo $s['subject_code']; ?></strong></td>
                    <td><?php echo $s['subject_name']; ?></td>
                    <td><?php echo $s['units']; ?></td>
                    <td><?php echo $s['schedule']; ?></td>
                    <td><?php echo $s['room']; ?></td>
                    <td><a href="enrollment.php?add_id=<?php echo $s['id']; ?>" class="btn-add">+ Enroll</a></td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </main>
</body>
</html>