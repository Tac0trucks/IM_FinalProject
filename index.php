<?php 
// We add "includes/" before the filename so PHP knows where to look
include 'includes/header.php'; 
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Home | CIT University</title>
    <style>
        .hero-section {
            height: 80vh;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            text-align: center;
            background-color: #fdfdfd;
            font-family: sans-serif;
        }
        .hero-section h1 { font-size: 3rem; color: #333; }
        .hero-section p { font-size: 1.2rem; color: #666; max-width: 700px; margin-bottom: 30px; }
        .main-btn {
            background-color: #b33939;
            color: white;
            padding: 15px 40px;
            text-decoration: none;
            border-radius: 5px;
            font-weight: bold;
        }
    </style>
</head>
<body>

    <section class="hero-section">
        <h1>Cebu Institute of Technology</h1>
        <p>Providing top-quality education and technological innovation for the leaders of tomorrow.</p>
        <a href="admissions.php" class="main-btn">View Admissions</a>
    </section>

</body>
</html>