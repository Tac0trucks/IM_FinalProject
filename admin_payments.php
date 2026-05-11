<?php 
include 'db.php'; 
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// 2. THE FIX: Check if the user is an admin
if ($_SESSION['role'] !== 'admin') {
    // If they are a student, kick them back to the Student Home
    header("Location: home.php?error=unauthorized");
    exit();
}
// --- LOGIC: VERIFY PAYMENT ---
if (isset($_GET['action']) && isset($_GET['id'])) {
    $pay_id = $_GET['id'];
    $action = $_GET['action'];

    if ($action == 'verify') {
        // 1. Get payment details
        $pay_query = mysqli_query($conn, "SELECT * FROM payments WHERE id = $pay_id");
        $pay_data = mysqli_fetch_assoc($pay_query);
        $student_id = $pay_data['user_id'];
        $amount_paid = $pay_data['amount'];

        // 2. Subtract the amount from the student's actual balance
        mysqli_query($conn, "UPDATE users SET balance_due = balance_due - $amount_paid WHERE id = $student_id");
        
        // 3. Mark payment as verified
        mysqli_query($conn, "UPDATE payments SET status = 'verified' WHERE id = $pay_id");
    } else {
        mysqli_query($conn, "UPDATE payments SET status = 'rejected' WHERE id = $pay_id");
    }
    header("Location: admin_payments.php?msg=processed");
}

$pending_payments = mysqli_query($conn, "SELECT p.*, u.username FROM payments p JOIN users u ON p.user_id = u.id WHERE p.status = 'pending'");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Verify Payments | Admin</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">
    <style>
        body { display: flex; font-family: 'Inter', sans-serif; background: #f8f9fa; margin: 0; }
        .main-content { flex: 1; padding: 40px; }
        h1 { color: #A3262A; border-left: 5px solid #A3262A; padding-left: 15px; }
        table { width: 100%; border-collapse: collapse; background: white; border-radius: 10px; overflow: hidden; margin-top: 20px; box-shadow: 0 4px 10px rgba(0,0,0,0.05); }
        th, td { padding: 15px; text-align: left; border-bottom: 1px solid #eee; }
        th { background: #fdfdfd; color: #888; text-transform: uppercase; font-size: 11px; letter-spacing: 1px; }
        .btn { padding: 8px 15px; border-radius: 6px; text-decoration: none; font-size: 12px; font-weight: bold; transition: 0.2s; }
        .btn-verify { background: #27ae60; color: white; margin-right: 10px; }
        .btn-verify:hover { background: #219150; }
        .btn-reject { background: #e74c3c; color: white; }
    </style>
</head>
<body>
    <?php include 'includes/sidebar.php'; ?>

    <main class="main-content">
        <h1>Process Student Payments</h1>
        
        <?php if(isset($_GET['msg'])) echo "<p style='color:green; font-weight:bold;'>Payment verified and balance updated!</p>"; ?>

        <table>
            <thead>
                <tr>
                    <th>Student</th>
                    <th>Amount</th>
                    <th>Reference #</th>
                    <th>Method</th>
                    <th>Date</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while($row = mysqli_fetch_assoc($pending_payments)): ?>
                <tr>
                    <td><strong><?php echo $row['username']; ?></strong></td>
                    <td style="color: #27ae60; font-weight: bold;">₱<?php echo number_format($row['amount'], 2); ?></td>
                    <td><code><?php echo $row['reference_number']; ?></code></td>
                    <td><?php echo $row['method']; ?></td>
                    <td><?php echo date('M d, Y', strtotime($row['created_at'])); ?></td>
                    <td>
                        <a href="admin_payments.php?action=verify&id=<?php echo $row['id']; ?>" class="btn btn-verify">Verify Payment</a>
                        <a href="admin_payments.php?action=reject&id=<?php echo $row['id']; ?>" class="btn btn-reject">Reject</a>
                    </td>
                </tr>
                <?php endwhile; ?>
                <?php if(mysqli_num_rows($pending_payments) == 0) echo "<tr><td colspan='6' style='text-align:center; padding:30px; color:#aaa;'>No pending payments to process.</td></tr>"; ?>
            </tbody>
        </table>
    </main>
</body>
</html>