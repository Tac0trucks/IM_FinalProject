<?php 
include 'db.php'; 

// Protection: Redirect if not logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Student Dashboard | CIT Enrollment System</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --cit-maroon: #A3262A;
            --cit-gold: #C5A021;
            --bg-gray: #F8F9FA;
            --text-main: #333;
            --text-muted: #888;
        }

        body {
            margin: 0;
            font-family: 'Inter', sans-serif;
            display: flex;
            background-color: var(--bg-gray);
            height: 100vh;
        }

        /* Content Area */
        .main-content {
            flex: 1;
            padding: 40px;
            overflow-y: auto;
        }

        .dashboard-header h1 { margin: 0; font-size: 32px; color: var(--text-main); }
        .academic-info { color: var(--text-muted); font-size: 14px; margin-top: 5px; }

        /* Stats Cards Section */
        .stats-grid {
            display: flex;
            gap: 20px;
            margin: 30px 0;
        }

        .stat-card {
            flex: 1;
            background: white;
            padding: 20px;
            border-radius: 15px;
            border-top: 4px solid #ddd;
            box-shadow: 0 4px 10px rgba(0,0,0,0.02);
        }

        /* Specific accent colors from image */
        .card-red { border-top-color: #B33939; }
        .card-green { border-top-color: #27ae60; }
        .card-gold { border-top-color: #f1c40f; }
        .card-dark { border-top-color: #7d3c3c; }

        .stat-val { font-size: 36px; font-weight: 700; color: var(--text-main); margin-bottom: 5px; }
        .stat-label { font-size: 14px; font-weight: 700; color: #333; }
        .stat-sub { font-size: 11px; color: var(--text-muted); }

        /* Alert Bar */
        .alert-bar {
            background: #FFF9E6;
            border: 1px solid #FFE6A1;
            padding: 15px 25px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            gap: 15px;
            margin-bottom: 40px;
            font-size: 14px;
        }

        /* Bottom Section Grid */
        .dashboard-grid {
            display: grid;
            grid-template-columns: 2fr 1fr;
            gap: 40px;
        }

        /* Table Styling */
        .section-title { font-size: 16px; font-weight: 700; margin-bottom: 20px; border-left: 4px solid var(--cit-maroon); padding-left: 10px; }
        
        table { width: 100%; border-collapse: collapse; background: white; border-radius: 10px; overflow: hidden; font-size: 13px; border: 1px solid #eee; }
        th { background: #fdfdfd; padding: 15px; text-align: left; border-bottom: 2px solid #eee; text-transform: uppercase; color: #555; }
        td { padding: 15px; border-bottom: 1px solid #f0f0f0; color: #666; }

        /* Right Panel Styling */
        .progress-container { background: white; padding: 25px; border-radius: 15px; margin-bottom: 30px; }
        .progress-header { display: flex; justify-content: space-between; font-size: 12px; font-weight: 700; margin-bottom: 10px; }
        .progress-bar { height: 10px; background: #eee; border-radius: 5px; overflow: hidden; }
        .progress-fill { height: 100%; width: 95%; background: var(--cit-maroon); }

        /* Quick Action Buttons */
        .btn-action {
            display: block;
            width: 100%;
            padding: 15px;
            margin-bottom: 10px;
            border-radius: 10px;
            text-align: center;
            text-decoration: none;
            font-weight: 600;
            font-size: 14px;
            transition: 0.3s;
        }

        .btn-primary { background: #BD6E6E; color: white; }
        .btn-outline { border: 1px solid #333; color: var(--cit-maroon); background: white; }
    </style>
</head>
<body>

    <!-- Reuse the Sidebar we created -->
    <?php include 'includes/sidebar.php'; ?>

    <main class="main-content">
        <!-- Header -->
        <div class="dashboard-header">
            <h1>Student Dashboard</h1>
            <p class="academic-info">AY 2025–2026 • Semester 2 • BS Computer Science • 2nd Year</p>
        </div>

        <!-- Stats Cards -->
        <section class="stats-grid">
            <div class="stat-card card-red">
                <div class="stat-val">21</div>
                <div class="stat-label">Enrolled Units</div>
                <div class="stat-sub">of 21 maximum units</div>
            </div>
            <div class="stat-card card-green">
                <div class="stat-val">1</div>
                <div class="stat-label">Active Sections</div>
                <div class="stat-sub">No Conflicts</div>
            </div>
            <div class="stat-card card-gold">
                <div class="stat-val">4.6</div>
                <div class="stat-label">GPA</div>
                <div class="stat-sub">67 Units Done</div>
            </div>
        
            <?php
    // Fetch the LATEST data for the logged-in user
    $uid = $_SESSION['user_id'];
    $user_query = mysqli_query($conn, "SELECT balance_due, max_units FROM users WHERE id = $uid");
    $user_data = mysqli_fetch_assoc($user_query);
            ?>

      <div class="stat-card card-dark">
    <div class="stat-val">₱<?php echo number_format($user_data['balance_due'], 2); ?></div>
    <div class="stat-label">Balance Due</div>
    <div class="stat-sub">Updated from Database</div>
</div>

<!-- FIND THE UNITS CARD AND UPDATE IT TOO -->
<div class="stat-card card-red">
    <div class="stat-val"><?php echo $user_data['max_units']; ?></div>
    <div class="stat-label">Max Units</div>
    <div class="stat-sub">of 21 maximum units</div>
</div>
        </section>

        <!-- Alert Bar -->
        <div class="alert-bar">
            <span>🕒</span>
            <div>
                <strong>Priority Window opens soon.</strong> 
                <span style="color: #666;">You are eligible for Type A (Graduating/Honors).</span>
                <a href="#" style="color: var(--cit-maroon); font-weight: 700; margin-left: 10px; text-decoration: none;">View schedule →</a>
            </div>
        </div>

        <!-- Bottom Layout -->
        <div class="dashboard-grid">
            <!-- Left Side: Table -->
            <div class="table-section">
                <div class="section-title">My Enrolled Sections</div>
                <table>
                    <thead>
                        <tr>
                            <th>Course</th>
                            <th>Schedule</th>
                            <th>Room</th>
                            <th>Units</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- This is where we will later use PHP loops to pull from MySQL -->
                        <tr><td>CS-221 Data Structures</td><td>MWF 1:30PM - 2:30PM</td><td>R-401</td><td>3</td><td>Enrolled</td></tr>
                        <tr><td>CS-222 Web Dev 1</td><td>TTH 9:00AM - 10:30AM</td><td>L-202</td><td>3</td><td>Enrolled</td></tr>
                        <tr><td>MATH-21 Statistics</td><td>MWF 8:00AM - 9:00AM</td><td>R-102</td><td>3</td><td>Enrolled</td></tr>
                        <tr><td>GE-101 Ethics</td><td>TTH 1:00PM - 2:30PM</td><td>R-505</td><td>3</td><td>Enrolled</td></tr>
                    </tbody>
                </table>
            </div>

            <!-- Right Side: Utils -->
            <div class="utils-section">
                <div class="section-title">Unit Load</div>
                <div class="progress-container">
                    <div class="progress-header">
                        <span>Enrolled</span>
                        <span style="color: var(--cit-maroon);">21/21 units</span>
                    </div>
                    <div class="progress-bar">
                        <div class="progress-fill"></div>
                    </div>
                </div>

                <div class="section-title">Quick Actions</div>
                <a href="enrollment.php" class="btn-action btn-primary">Self-Enrollment</a>
                <a href="calculation.php" class="btn-action btn-outline">Unit-Calculation</a>
                <a href="payments.php" class="btn-action btn-outline">Payment</a>
            </div>
        </div>
    </main>

</body>
</html>