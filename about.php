<?php
session_start();
$theme = $_SESSION['theme'] ?? 'light';
?>

<script>
    window.onload = function() {
        let theme = "<?= $theme ?>";
        if (theme === "dark") {
            document.body.classList.add("dark");
        }
    }
</script>

<!doctype html>
<html>

<head>
    <title>About</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet" />
    <link rel="stylesheet" href="style.css">

    <!-- ================= ANIMATION CSS ================= -->
    <style>
        .fade-up {
            opacity: 0;
            transform: translateY(25px);
            animation: fadeUp 0.7s ease forwards;
        }

        @keyframes fadeUp {
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* CLEAN DELAYS */
        .delay-1 {
            animation-delay: 0.1s;
        }

        .delay-2 {
            animation-delay: 0.2s;
        }

        .delay-3 {
            animation-delay: 0.3s;
        }

        .delay-4 {
            animation-delay: 0.4s;
        }

        .delay-5 {
            animation-delay: 0.5s;
        }

        .delay-6 {
            animation-delay: 0.6s;
        }

        .delay-7 {
            animation-delay: 0.7s;
        }

        /* CARD HOVER */
        .card-pro {
            transition: 0.3s ease;
        }

        .card-pro:hover {
            transform: translateY(-5px);
            box-shadow: 0 12px 25px rgba(0, 0, 0, 0.15);
        }

        /* CARD TITLE STYLE */
        .card-title {
            font-weight: 600;
            margin-bottom: 10px;
            color: #ff9100c5;
        }
    </style>
</head>

<body>

    <?php include("header.php"); ?>
    <?php include("sidenav.php"); ?>

    <div class="content">

        <!-- ================= ABOUT ================= -->
        <div class="card card-pro p-4 mt-3 fade-up delay-1">
            <h4 class="card-title">ℹ️ About Project</h4>
            <p>
                Renewable Farm Layout Optimizer is a smart simulation tool designed
                to improve solar farm efficiency by optimizing panel placement and reducing shadow loss.
            </p>
            <p>
                It uses grid-based modeling and real-time solar analysis to design high-performance layouts.
            </p>
        </div>

        <!-- ================= MISSION ================= -->
        <div class="card card-pro p-4 mt-3 fade-up delay-2">
            <h4 class="card-title">🎯 Mission</h4>
            <p>
                To provide a smart platform that helps engineers maximize solar energy production
                with optimized design strategies.
            </p>
        </div>

        <!-- ================= FEATURES ================= -->
        <div class="card card-pro p-4 mt-3 fade-up delay-3">
            <h4 class="card-title">⚙️ Key Features</h4>
            <ul>
                <li>Interactive grid-based solar layout</li>
                <li>Sun direction simulation</li>
                <li>Auto spacing optimization</li>
                <li>Energy & efficiency calculation</li>
                <li>Real-time analysis system</li>
            </ul>
        </div>

        <!-- ================= TECHNOLOGY ================= -->
        <div class="card card-pro p-4 mt-3 fade-up delay-4">
            <h4 class="card-title">🧠 Technology Used</h4>
            <ul>
                <li>HTML, CSS, Bootstrap, JavaScript</li>
                <li>PHP Backend</li>
                <li>SunCalc Library (solar position)</li>
            </ul>
        </div>

        <!-- ================= APPLICATIONS ================= -->
        <div class="card card-pro p-4 mt-3 fade-up delay-5">
            <h4 class="card-title">🌍 Applications</h4>
            <ul>
                <li>Solar farm planning</li>
                <li>Renewable energy projects</li>
                <li>Education & research</li>
                <li>Energy optimization studies</li>
            </ul>
        </div>

        <!-- ================= FUTURE ================= -->
        <div class="card card-pro p-4 mt-3 fade-up delay-6">
            <h4 class="card-title">🚀 Future Enhancements</h4>
            <ul>
                <li>GIS map integration</li>
                <li>AI-based optimization</li>
                <li>Advanced analytics charts</li>
                <li>Cloud storage system</li>
            </ul>
        </div>

        <!-- ================= NOTE ================= -->
        <div class="card card-pro p-4 mt-3 fade-up delay-7">
            <h4 class="card-title">💡 Note</h4>
            <div class="alert alert-info mb-0">
                This project focuses on improving solar efficiency and supporting sustainable energy development.
            </div>
        </div>

    </div>

    <script>
        function toggleDark() {
            let isDark = document.body.classList.toggle("dark");
            let theme = isDark ? "dark" : "light";
            fetch("theme.php?theme=" + theme);
        }
    </script>

    <script src="script.js"></script>

</body>

</html>