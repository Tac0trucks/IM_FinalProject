<?php 
include 'db.php'; 

// --- LOGIC: HANDLE APPROVAL/REJECTION ---
if (isset($_GET['action']) && isset($_GET['id'])) {
    $request_id = $_GET['id'];
    $action = $_GET['action'];

    if ($action == 'approve') {
        // 1. Get the request details
        $req_query = mysqli_query($conn, "SELECT * FROM overload_requests WHERE id = $request_id");
        $req_data = mysqli_fetch_assoc($req_query);
        $student_id = $req_data['user_id'];
        $new_units = $req_data['requested_units'];

        // 2. Update student's max units in 'users' table
        mysqli_query($conn, "UPDATE users SET max_units = $new_units WHERE id = $student_id");
        
        // 3. Mark request as approved
        mysqli_query($conn, "UPDATE overload_requests SET status = 'approved' WHERE id = $request_id");
    } else {
        // Mark as rejected
        mysqli_query($conn, "UPDATE overload_requests SET status = 'rejected' WHERE id = $request_id");
    }
    header("Location: admin_overload.php?msg=success");
}

// Fetch all pending requests
$requests = mysqli_query($conn, "SELECT r.*, u.username FROM overload_requests r JOIN users u ON r.user_id = u.id WHERE r.status = 'pending'");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manage Overloads | Admin</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">
    <style>
        body { display: flex; font-family: 'Inter', sans-serif; background: #f8f9fa; margin: 0; }
        .main-content { flex: 1; padding: 40px; }
        h1 { color: #A3262A; border-left: 5px solid #A3262A; padding-left: 15px; }
        table { width: 100%; border-collapse: collapse; background: white; border-radius: 10px; overflow: hidden; margin-top: 20px; }
        th, td { padding: 15px; text-align: left; border-bottom: 1px solid #eee; }
        th { background: #fdfdfd; color: #888; text-transform: uppercase; font-size: 12px; }
        .btn { padding: 8px 15px; border-radius: 5px; text-decoration: none; font-size: 13px; font-weight: bold; }
        .btn-approve { background: #27ae60; color: white; margin-right: 10px; }
        .btn-reject { background: #e74c3c; color: white; }
    </style>
</head>
<body>
    <?php include 'includes/sidebar.php'; ?>

    <main class="main-content">
        <h1>Unit Load Overload Requests</h1>
        
        <?php if(isset($_GET['msg'])) echo "<p style='color:green;'>Action processed successfully!</p>"; ?>

        <table>
            <thead>
                <tr>
                    <th>Student</th>
                    <th>Requested Units</th>
                    <th>Reason</th>
                    <th>Date</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while($row = mysqli_fetch_assoc($requests)): ?>
                <tr>
                    <td><strong><?php echo $row['username']; ?></strong></td>
                    <td><?php echo $row['requested_units']; ?> Units</td>
                    <td><?php echo $row['reason']; ?></td>
                    <td><?php echo $row['created_at']; ?></td>
                    <td>
                        <a href="admin_overload.php?action=approve&id=<?php echo $row['id']; ?>" class="btn btn-approve">Approve</a>
                        <a href="admin_overload.php?action=reject&id=<?php echo $row['id']; ?>" class="btn btn-reject">Reject</a>
                    </td>
                </tr>
                <?php endwhile; ?>
                <?php if(mysqli_num_rows($requests) == 0) echo "<tr><td colspan='5'>No pending requests.</td></tr>"; ?>
            </tbody>
        </table>
    </main>
</body>
</html>