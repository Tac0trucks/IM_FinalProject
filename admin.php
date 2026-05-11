<?php 
include 'db.php'; 

// Protection: In a real app, you would check if the user is an 'admin' here
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Administration Panel | CIT-U</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --cit-maroon: #A3262A;
            --cit-gold: #C5A021;
            --bg-gray: #F8F9FA;
        }

        body {
            margin: 0;
            font-family: 'Inter', sans-serif;
            display: flex;
            background-color: var(--bg-gray);
            height: 100vh;
        }

        .main-content {
            flex: 1;
            padding: 40px;
            overflow-y: auto;
        }

        /* Header Section */
        .admin-header h1 { margin: 0; font-size: 32px; font-weight: 800; color: #333; }
        .admin-header p { color: #A0A0A0; font-size: 14px; margin-top: 5px; }

        /* Stats Cards - Reusing Dashboard Style */
        .stats-grid {
            display: flex;
            gap: 20px;
            margin: 30px 0;
        }

        .stat-card {
            flex: 1;
            background: white;
            padding: 25px;
            border-radius: 15px;
            border-top: 4px solid #ddd;
            box-shadow: 0 4px 10px rgba(0,0,0,0.02);
        }

        .card-red { border-top-color: #B33939; }
        .card-green { border-top-color: #27ae60; }
        .card-gold { border-top-color: #f1c40f; }
        .card-maroon { border-top-color: #7d3c3c; }

        .stat-val { font-size: 36px; font-weight: 700; color: #BD3B3B; margin-bottom: 5px; }
        .stat-label { font-size: 14px; font-weight: 700; color: #333; }
        .stat-sub { font-size: 11px; color: #A0A0A0; }

        /* Two-Column Layout */
        .admin-grid {
            display: grid;
            grid-template-columns: 1.5fr 1fr;
            gap: 40px;
        }

        .section-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 20px;
        }

        .section-header h2 { font-size: 16px; font-weight: 700; margin: 0; border-left: 4px solid var(--cit-maroon); padding-left: 15px; }

        /* Action Cards (The list on the left) */
        .action-list { display: flex; flex-direction: column; gap: 15px; }

        .action-card {
            background: white;
            padding: 20px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            text-decoration: none;
            color: inherit;
            transition: 0.3s;
            border: 1px solid transparent;
        }

        .action-card:hover { transform: translateX(5px); border-color: #eee; box-shadow: 0 5px 15px rgba(0,0,0,0.05); }

        .action-icon {
            width: 45px;
            height: 45px;
            background: #F8F9FA;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 20px;
            font-size: 20px;
        }

        .action-info { flex: 1; }
        .action-info h4 { margin: 0; font-size: 14px; color: #333; }
        .action-info p { margin: 3px 0 0; font-size: 11px; color: #A0A0A0; }

        .action-status { font-size: 12px; font-weight: 700; color: #E67E22; } /* Orange pending text */

        /* Right Panel Utility */
        .progress-box {
            background: white;
            padding: 30px;
            border-radius: 15px;
        }

        .progress-label { display: flex; justify-content: space-between; font-size: 12px; font-weight: 700; margin-bottom: 10px; }
        .progress-bar { height: 10px; background: #eee; border-radius: 5px; overflow: hidden; }
        .progress-fill { height: 100%; width: 95%; background: var(--cit-maroon); }
    </style>
</head>
<body>

    <!-- Sidebar Include -->
    <?php include 'includes/sidebar.php'; ?>

    <main class="main-content">
        <div class="admin-header">
            <h1>Administration Panel</h1>
            <p>Role: System Administrator · Admin Ramos · BR-A2</p>
        </div>

        <!-- Stats Grid -->
        <section class="stats-grid">
            <div class="stat-card card-red">
                <div class="stat-val">1,204</div>
                <div class="stat-label">Total Enrolled</div>
                <div class="stat-sub">BR-DS1</div>
            </div>
            <div class="stat-card card-green">
                <div class="stat-val" style="color: #27ae60;">67</div>
                <div class="stat-label">Flagged Sections</div>
                <div class="stat-sub">Pending Review</div>
            </div>
            <div class="stat-card card-gold">
                <div class="stat-val" style="color: #f1c40f;">21.4</div>
                <div class="stat-label">Avg Unit Load</div>
                <div class="stat-sub">Across all students</div>
            </div>
            <div class="stat-card card-maroon">
                <div class="stat-val">23</div>
                <div class="stat-label">Conflict Blocks</div>
                <div class="stat-sub">Requiring Resolution</div>
            </div>
        </section>

        <!-- Main Content Grid -->
        <div class="admin-grid">
            <!-- Left: Quick Actions -->
            <div>
                <div class="section-header">
                    <h2>Quick Actions</h2>
                </div>
                
                <div class="action-list">
                    <a href="#" class="action-card">
                        <div class="action-icon">🕒</div>
                        <div class="action-info">
                            <h4>Manage Priority Windows</h4>
                            <p>BR_PW1, BR-PW3 — Assign & configure windows</p>
                        </div>
                        <span style="color:#ccc;">></span>
                    </a>

                   <a href="admin_overload.php" class="action-card">
                    <div class="action-icon">⚖️</div>
                    <div class="action-info">
                    <h4>Override Unit Loads</h4>
                    <p>BR_UC5 — Approve overload requests</p>
                    </div>
                    <!-- We can even make this number dynamic! -->
                    <span class="action-status">
            <?php 
            $count_req = mysqli_query($conn, "SELECT id FROM overload_requests WHERE status='pending'");
            echo mysqli_num_rows($count_req); 
            ?> pending
                </span>
                    </a>

                    <a href="admin_payments.php" class="action-card">
    <div class="action-icon">💳</div>
    <div class="action-info">
        <h4>Process Payments</h4>
        <p>BR_PT6 — Mark transactions as processed by Admin</p>
    </div>
    <span class="action-status">
        <?php 
            $count_pay = mysqli_query($conn, "SELECT id FROM payments WHERE status='pending'");
            echo mysqli_num_rows($count_pay); 
        ?> pending
    </span>
    </a>
                    <a href="#" class="action-card">
                        <div class="action-icon">📊</div>
                        <div class="action-info">
                            <h4>Refresh Dashboard Stats</h4>
                            <p>BR_DS2 — Force recalculate last_refreshed</p>
                        </div>
                        <span style="color:#ccc;">></span>
                    </a>

                    <a href="#" class="action-card">
                        <div class="action-icon">⚠️</div>
                        <div class="action-info">
                            <h4>Review Flagged Sections</h4>
                            <p>BR_CS6 — 7 sections flagged_cancel = TRUE</p>
                        </div>
                        <span class="action-status" style="color: #E74C3C;">7</span>
                    </a>
                </div>
            </div>

            <!-- Right: Pending Requests -->
            <div>
                <div class="section-header">
                    <h2>Pending Overload Requests</h2>
                </div>
                <div class="progress-box">
                    <div class="progress-label">
                        <span>Enrolled Total</span>
                        <span style="color: var(--cit-maroon);">21/21 units</span>
                    </div>
                    <div class="progress-bar">
                        <div class="progress-fill"></div>
                    </div>
                </div>
            </div>
        </div>
    </main>

</body>
</html>