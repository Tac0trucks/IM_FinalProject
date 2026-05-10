<?php include 'includes/header.php'; ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CIT University | Portal</title>
    <!-- Importing a clean professional font -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&display=swap" rel="stylesheet">
    
    <style>
        :root {
            --cit-maroon: #A3262A; /* The exact maroon from the logo */
            --cit-gold: #F8B61C;
            --text-dark: #2D3436;
            --text-grey: #636E72;
            --bg-light: #FCFCFC;
        }

        body {
            margin: 0;
            font-family: 'Inter', sans-serif;
            background-color: white;
            color: var(--text-dark);
            overflow-x: hidden;
        }

        /* Hero Section Container */
        .hero-container {
            display: flex;
            align-items: center;
            justify-content: space-between;
            min-height: 80vh;
            padding: 0 10%;
            max-width: 1400px;
            margin: 0 auto;
        }

        .hero-text {
            flex: 1;
            padding-right: 50px;
        }

        .hero-text h1 {
            font-size: 3.5rem;
            line-height: 1.1;
            margin-bottom: 20px;
            font-weight: 700;
            color: var(--text-dark);
        }

        .hero-text h1 span {
            color: var(--cit-maroon);
        }

        .hero-text p {
            font-size: 1.1rem;
            color: var(--text-grey);
            line-height: 1.6;
            margin-bottom: 40px;
            max-width: 500px;
        }

        /* The "View Admissions" Button */
        .cta-group {
            display: flex;
            gap: 20px;
        }

        .btn-primary {
            background-color: var(--cit-maroon);
            color: white;
            padding: 16px 35px;
            border-radius: 12px;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s ease;
            box-shadow: 0 10px 20px rgba(163, 38, 42, 0.2);
        }

        .btn-primary:hover {
            transform: translateY(-3px);
            box-shadow: 0 15px 30px rgba(163, 38, 42, 0.3);
        }

        /* Right side: Visual Element */
        .hero-image {
            flex: 1;
            display: flex;
            justify-content: flex-end;
            position: relative;
        }

        /* This creates a stylish "Box" for where an image would go */
        .image-placeholder {
            width: 100%;
            height: 450px;
            background: linear-gradient(135deg, #f5f5f5 0%, #e0e0e0 100%);
            border-radius: 30px;
            position: relative;
            overflow: hidden;
            border: 1px solid #eee;
        }

        /* Floating Badge Touch */
        .badge {
            position: absolute;
            bottom: 30px;
            left: -40px;
            background: white;
            padding: 20px;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .badge-icon {
            width: 40px;
            height: 40px;
            background: var(--cit-gold);
            border-radius: 50%;
        }

        /* Quick Links Footer-ish area */
        .bottom-nav {
            padding: 40px 10%;
            background: #fff;
            display: flex;
            gap: 50px;
            border-top: 1px solid #f0f0f0;
        }

        .stat-item h4 { margin: 0; font-size: 1.5rem; color: var(--cit-maroon); }
        .stat-item p { margin: 5px 0 0; color: var(--text-grey); font-size: 0.9rem; }

        @media (max-width: 992px) {
            .hero-container { flex-direction: column; text-align: center; padding-top: 50px; }
            .hero-text { padding-right: 0; margin-bottom: 50px; }
            .hero-text p { margin: 0 auto 40px; }
            .cta-group { justify-content: center; }
            .hero-image { display: none; }
        }
    </style>
</head>
<body>

    <main class="hero-container">
        <div class="hero-text">
            <h1>Cebu Institute of <span>Technology</span></h1>
            <p>Providing top-quality education and technological innovation for the leaders of tomorrow. Explore our programs and join a community of excellence.</p>
            
            <div class="cta-group">
                <a href="admissions.php" class="btn-primary">View Admissions</a>
            </div>
        </div>

        <div class="hero-image">
            <div class="image-placeholder">
                <!-- If you have a campus photo, put it here: <img src="campus.jpg" style="width:100%; height:100%; object-fit:cover;"> -->
            </div>
            <div class="badge">
                <div class="badge-icon"></div>
                <div>
                    <strong style="display:block">Top Rated</strong>
                    <span style="font-size: 0.8rem; color: #777;">Center of Excellence</span>
                </div>
            </div>
        </div>
    </main>

    <section class="bottom-nav">
        <div class="stat-item">
            <h4>75+</h4>
            <p>Years of Excellence</p>
        </div>
        <div class="stat-item">
            <h4>15k+</h4>
            <p>Active Students</p>
        </div>
        <div class="stat-item">
            <h4>95%</h4>
            <p>Employment Rate</p>
        </div>
    </section>

</body>
</html>