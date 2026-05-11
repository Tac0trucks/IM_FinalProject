<?php 

include 'db.php'; 
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Home | CIT Enrollment System</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --cit-maroon: #A3262A;
            --cit-gold: #C5A021;
            --bg-gray: #F8F9FA;
            --text-muted: #A0A0A0;
        }

        body {
            margin: 0;
            font-family: 'Inter', sans-serif;
            display: flex; /* Creates the Side-by-Side layout */
            height: 100vh;
            background-color: var(--bg-gray);
        }

        /* Sidebar Styling */
        .sidebar {
            width: 260px;
            background: white;
            border-right: 1px solid #eee;
            padding: 20px;
            display: flex;
            flex-direction: column;
        }

        .sidebar-header {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 40px;
        }

        .sidebar-header img { height: 45px; }
        .brand { display: block; font-weight: 700; color: var(--cit-maroon); font-size: 16px; }
        .subtext { display: block; font-size: 11px; color: var(--cit-gold); }

        .menu-section { margin-bottom: 25px; border-top: 1px solid #eee; padding-top: 15px; }
        .section-title { font-size: 12px; color: var(--text-muted); text-transform: uppercase; margin-bottom: 10px; }
        
        .menu-item {
            display: block;
            text-decoration: none;
            color: #333;
            padding: 10px 0;
            font-weight: 600;
            font-size: 14px;
            transition: 0.2s;
        }

        .menu-item:hover { color: var(--cit-maroon); }
        .menu-item.active { color: var(--cit-maroon); }

        /* Main Content Area */
        .main-content {
            flex: 1;
            display: flex;
            flex-direction: column;
        }

        .top-bar {
            height: 70px;
            padding: 0 40px;
            display: flex;
            justify-content: flex-end;
            align-items: center;
            background: transparent;
        }

        .notification-bell {
            background: white;
            padding: 10px;
            border-radius: 50%;
            box-shadow: 0 4px 10px rgba(0,0,0,0.05);
            cursor: pointer;
        }

        /* The Centered Text Section */
        .hero-center {
            flex: 1;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            text-align: center;
        }

        .wits { color: var(--cit-gold); font-size: 24px; font-weight: 700; letter-spacing: 2px; margin-bottom: 5px; }
        .main-title { color: var(--cit-maroon); font-size: 42px; font-weight: 800; margin: 0; }
        .welcome-text { color: #555; font-size: 18px; margin-top: 15px; }
    </style>
</head>
<body>

    <!-- 1. Include Sidebar -->
    <?php include 'includes/sidebar.php'; ?>

    <!-- 2. Main Area -->
    <main class="main-content">
        <div class="top-bar">
            <div class="notification-bell">🔔</div>
        </div>

        <div class="hero-center">
            <div class="wits">WITS</div>
            <h1 class="main-title">CIT UNIVERSITY ENROLLMENT SYSTEM</h1>
            <p class="welcome-text">
                Welcome back, <strong><?php echo $_SESSION['username']; ?></strong>. 
                Your priority window opens soon.
            </p>
        </div>
    </main>

</body>
</html>