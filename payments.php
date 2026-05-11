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
    <title>Payment Transactions | CIT Enrollment System</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --cit-maroon: #A3262A;
            --cit-gold: #C5A021;
            --cit-green: #27ae60;
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

        /* Header Area */
        .page-header h1 { margin: 0; font-size: 32px; font-weight: 800; color: #333; }
        .page-header p { color: #A0A0A0; font-size: 14px; margin-top: 5px; }

        /* Stats Grid */
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
        .card-green { border-top-color: var(--cit-green); }
        .card-gold { border-top-color: var(--cit-gold); }

        .stat-val { font-size: 36px; font-weight: 700; color: #333; margin-bottom: 5px; }
        .val-red { color: #A3262A; }
        .val-green { color: var(--cit-green); }

        .stat-label { font-size: 14px; font-weight: 700; color: #333; }
        .stat-sub { font-size: 11px; color: #A0A0A0; }

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

        .alert-bar strong { font-weight: 700; }
        .alert-bar a { color: var(--cit-maroon); font-weight: 700; text-decoration: none; }

        /* Layout Grid */
        .payment-grid {
            display: grid;
            grid-template-columns: 2fr 1fr;
            gap: 40px;
        }

        .section-title { font-size: 16px; font-weight: 700; margin-bottom: 20px; border-left: 4px solid var(--cit-maroon); padding-left: 15px; }

        /* Table */
        table { width: 100%; border-collapse: collapse; background: white; border-radius: 10px; overflow: hidden; font-size: 13px; border: 1px solid #eee; }
        th { background: #fdfdfd; padding: 15px; text-align: left; border-bottom: 2px solid #eee; text-transform: uppercase; color: #555; }
        td { padding: 15px; border-bottom: 1px solid #f0f0f0; color: #666; }

        /* Status Side Card */
        .status-box {
            background: white;
            padding: 30px;
            border-radius: 15px;
            text-align: center;
            box-shadow: 0 4px 15px rgba(0,0,0,0.03);
        }

        .status-badge {
            display: inline-block;
            border: 1px solid var(--cit-gold);
            color: var(--cit-gold);
            background: #fffdf5;
            padding: 8px 25px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 700;
            margin-bottom: 30px;
        }

        .status-list { text-align: left; margin-top: 20px; border-top: 1px solid #eee; padding-top: 20px; }
        .status-item { display: flex; justify-content: space-between; font-size: 12px; margin-bottom: 15px; }
        .item-label { color: #A0A0A0; font-weight: 500; }
        .item-val { color: #555; font-weight: 600; }
    </style>
</head>
<body>

    <!-- Dynamic Sidebar -->
    <?php include 'includes/sidebar.php'; ?>

    <main class="main-content">
        <div class="page-header">
            <h1>Payment Transactions</h1>
            <p>Semester 2 · AY 2025–2026 · Ref: TXN-0019283 · Processed by Admin Ramos</p>
        </div>

        <!-- Summary Cards -->
        <section class="stats-grid">
            <div class="stat-card card-red">
                <div class="stat-val val-red">₱6,700</div>
                <div class="stat-label">Balance Due</div>
                <div class="stat-sub">Balance Due</div>
            </div>
            <div class="stat-card card-red">
                <div class="stat-val val-red">₱46,700</div>
                <div class="stat-label">Total Assessed</div>
                <div class="stat-sub">Total Assessed</div>
            </div>
            <div class="stat-card card-green">
                <div class="stat-val val-green">₱40,000</div>
                <div class="stat-label">Amount Paid</div>
                <div class="stat-sub">Amount Paid</div>
            </div>
            <div class="stat-card card-gold">
                <div class="stat-val">21</div>
                <div class="stat-label">Units Billed</div>
                <div class="stat-sub">Units Billed</div>
            </div>
        </section>

        <!-- Outstanding Balance Alert -->
        <div class="alert-bar">
            <span>⚠️</span>
            <div>
                <strong>Outstanding Balance.</strong> 
                <span style="color: #666;">Please settle ₱4,200 to avoid enrollment hold.</span>
                <a href="#">Pay now →</a>
            </div>
        </div>

        <!-- Main Details Grid -->
        <div class="payment-grid">
            <!-- Left: Table -->
            <div>
                <div class="section-title">Transactions Details</div>
                <table>
                    <thead>
                        <tr>
                            <th>Description</th>
                            <th>Amount</th>
                            <th>Date</th>
                            <th>Method</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr><td>Tuition Fee Installment</td><td>₱20,000</td><td>2026-01-10</td><td>Bank Transfer</td><td>Success</td></tr>
                        <tr><td>Laboratory Fees</td><td>₱15,000</td><td>2026-01-10</td><td>Over-the-counter</td><td>Success</td></tr>
                        <tr><td>Miscellaneous Fees</td><td>₱5,000</td><td>2026-01-10</td><td>G-Cash</td><td>Success</td></tr>
                    </tbody>
                </table>
            </div>

            <!-- Right: Status -->
            <div>
                <div class="section-title">Payment Status</div>
                <div class="status-box">
                    <p style="font-size: 11px; color: #888; margin-bottom: 5px;">Payment Status</p>
                    <div class="status-badge">Partial Payment</div>

                    <div class="status-list">
                        <div class="status-item">
                            <span class="item-label">assessed_at</span>
                            <span class="item-val">2026-01-10 09:00</span>
                        </div>
                        <div class="status-item">
                            <span class="item-label">paid_at</span>
                            <span class="item-val">2026-01-10 11:32</span>
                        </div>
                        <div class="status-item">
                            <span class="item-label">processed_by</span>
                            <span class="item-val">Admin Ramos</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

</body>
</html>