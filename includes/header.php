<style>
    /* This section handles the design so you don't need a separate CSS file */
    .main-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 10px 50px;
        background-color: white;
        font-family: sans-serif;
        border-bottom: 1px solid #eee;
    }

    .logo img {
        height: 60px;
    }

    .nav-links a {
        text-decoration: none;
        color: #777;
        margin: 0 20px;
        font-size: 16px;
    }

    .btn-login {
        background-color: #b33939; /* The maroon color */
        color: white !important;
        padding: 10px 25px;
        border-radius: 8px;
        text-decoration: none;
        font-weight: bold;
    }
</style>

<header class="main-header">
    <div class="logo">
       <img src="/assets/cit-logo.png" alt="CIT Logo">
    </div>

    <nav class="nav-links">
        <a href="admissions.php">Admissions Policy</a>
        <a href="schedule.php">Schedule</a>
        <a href="help.php">Help</a>
    </nav>

    <div class="header-actions">
        <a href="login.php" class="btn-login">Login</a>
    </div>
</header>