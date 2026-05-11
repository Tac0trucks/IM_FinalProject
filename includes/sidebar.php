<?php
// This line gets the name of the current file (e.g., 'admin.php' or 'home.php')
$current_page = basename($_SERVER['PHP_SELF']);

// Ensure session is started to check roles
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>

<style>
    /* SIDEBAR STYLING */
    .sidebar {
        width: 280px;
        min-width: 280px;
        background: #FFFFFF;
        height: 100vh;
        border-right: 1px solid #EAEAEA;
        padding: 30px 20px;
        position: sticky;
        top: 0;
        display: flex;
        flex-direction: column;
        box-sizing: border-box;
    }

    .sidebar-logo-section {
        display: flex;
        align-items: center;
        gap: 12px;
        margin-bottom: 40px;
    }

    .sidebar-logo-section img { height: 50px; width: auto; }

    .brand { display: block; font-weight: 800; color: #A3262A; font-size: 16px; }
    .sub { font-size: 11px; color: #C5A021; }

    .sidebar-section { margin-bottom: 25px; }

    .sidebar-section h3 {
        font-size: 12px;
        color: #A0A0A0;
        text-transform: uppercase;
        letter-spacing: 1px;
        margin-bottom: 15px;
        font-weight: 500;
        padding-left: 10px;
        border-left: 3px solid transparent;
    }

    /* Links */
    .sidebar-link {
        display: flex;
        align-items: center;
        text-decoration: none;
        color: #444;
        padding: 10px 15px;
        font-size: 14px;
        font-weight: 600;
        border-radius: 8px;
        transition: 0.2s;
        margin-bottom: 5px;
    }

    .sidebar-link:hover {
        background-color: #f8f8f8;
        color: #A3262A;
    }

    /* THE RED HIGHLIGHT STYLE */
    .sidebar-link.active {
        color: #A3262A !important;
        background-color: #fdf2f2 !important;
    }

    /* Logout Styling */
    .logout-btn {
        margin-top: auto;
        color: #e74c3c;
    }
    .logout-btn:hover {
        background-color: #fff5f5;
        color: #c0392b;
    }

    /* Emoji Spacing */
    .sidebar-link span {
        margin-right: 10px;
        font-size: 16px;
    }
</style>

<aside class="sidebar">
    <div class="sidebar-logo-section">
        <!-- Make sure the path to your logo is correct -->
        <img src="/assets/cit-logo.png" alt="CIT Logo">
        <div class="logo-text">
            <span class="brand">CIT-University</span>
            <span class="sub">Enrollment System</span>
        </div>
    </div>

    <!-- MAIN MENU -->
    <div class="sidebar-section">
        <h3>Main Menu</h3>
        <a href="home.php" class="sidebar-link <?php echo ($current_page == 'home.php') ? 'active' : ''; ?>">
            <span>🏠</span> Home
        </a>
    </div>

    <!-- STUDENT MANAGEMENT -->
    <div class="sidebar-section">
        <h3>Student Management</h3>
        <?php 
            // Logical Check: Admins go to admin.php, Students go to dashboard.php
            $dash_page = ($_SESSION['role'] === 'admin') ? 'admin.php' : 'dashboard.php';
        ?>
        <a href="<?php echo $dash_page; ?>" class="sidebar-link <?php echo ($current_page == $dash_page) ? 'active' : ''; ?>">
            <span>📊</span> Dashboard
        </a>
        
        <a href="priority.php" class="sidebar-link <?php echo ($current_page == 'priority.php') ? 'active' : ''; ?>">
            <span>🕒</span> Priority Window
        </a>
        
        <a href="calculation.php" class="sidebar-link <?php echo ($current_page == 'calculation.php') ? 'active' : ''; ?>">
            <span>🧮</span> Unit Calculation
        </a>
        
        <a href="payments.php" class="sidebar-link <?php echo ($current_page == 'payments.php') ? 'active' : ''; ?>">
            <span>💳</span> Payments
        </a>
    </div>

    <!-- STUDENT TOOLS -->
    <div class="sidebar-section">
        <h3>Student Tools</h3>
        <a href="enrollment.php" class="sidebar-link <?php echo ($current_page == 'enrollment.php') ? 'active' : ''; ?>">
            <span>📝</span> Self-Enrollment
        </a>
        <a href="profile.php" class="sidebar-link <?php echo ($current_page == 'profile.php') ? 'active' : ''; ?>">
            <span>👤</span> MyProfile
        </a>
    </div>

    <!-- GENERAL -->
    <div class="sidebar-section">
        <h3>General</h3>
        <a href="announcements.php" class="sidebar-link <?php echo ($current_page == 'announcements.php') ? 'active' : ''; ?>">
            <span>📢</span> Announcement
        </a>
    </div>

    <!-- ADMINISTRATION (Only visible to Admin role) -->
    <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
    <div class="sidebar-section">
        <h3>Administration</h3>
        <a href="admin.php" class="sidebar-link <?php echo ($current_page == 'admin.php') ? 'active' : ''; ?>">
            <span>⚙️</span> AdminPanel
        </a>
    </div>
    <?php endif; ?>

    <!-- LOGOUT -->
    <a href="logout.php" class="sidebar-link logout-btn">
        <span>🚪</span> Logout
    </a>
</aside>