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
    <title>Analytics</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet" />
    <link rel="stylesheet" href="style.css">

    <!-- CARD ANIMATION ONLY -->
    <style>
        .card-pro {
            animation: slideUp 0.6s ease forwards;
            opacity: 0;
            transform: translateY(20px);
        }

        .card-pro:nth-child(1) {
            animation-delay: 0.1s;
        }

        .card-pro:nth-child(2) {
            animation-delay: 0.2s;
        }

        .card-pro:nth-child(3) {
            animation-delay: 0.3s;
        }

        .card-pro:nth-child(4) {
            animation-delay: 0.4s;
        }

        @keyframes slideUp {
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>

</head>

<body>

    <?php include("header.php"); ?>
    <?php include("sidenav.php"); ?>

    <div class="content">

        <!-- ================= CARD 1 (TITLE) ================= -->
        <div class="card card-pro p-4 mb-3">
            <h3 style="color:#ff9100c5;">📈 Solar Farm Analytics</h3>
            <p>
                The analytics module provides detailed insights into efficiency,
                energy output, and solar optimization.
            </p>
        </div>

        <!-- ================= CARD 2 (INSIGHTS) ================= -->
        <div class="card card-pro p-4 mb-3">
            <h5 style="color:#ff9100c5;">🧠 Performance Insights</h5>
            <ul>
                <li>Higher efficiency = better sunlight utilization</li>
                <li>Energy output depends on grid density and sun direction</li>
                <li>Shadow overlap reduces performance</li>
                <li>Optimized spacing improves energy yield</li>
            </ul>
        </div>

        <!-- ================= CARD 3 (STATUS) ================= -->
        <div class="card card-pro p-4 mb-3">
            <h5 style="color:#ff9100c5;">📊 System Status</h5>

            <p id="statusMessage" class="fw-bold text-info">
                Run simulation to view analytics insights.
            </p>
        </div>

        <!-- ================= CARD 4 (SUGGESTIONS) ================= -->
        <div class="card card-pro p-4 mb-3">
            <h5 style="color:#ff9100c5;">💡 Optimization Suggestions</h5>
            <ul id="suggestionList">
                <li>Adjust panel spacing to reduce shadow loss</li>
                <li>Use Auto Optimize for better layout arrangement</li>
                <li>Align panels based on sun direction</li>
                <li>Avoid overcrowding panels in limited land area</li>
            </ul>
        </div>

        <!-- ================= CARD 5 (WARNING) ================= -->
        <div class="card card-pro p-3">
            <div class="alert alert-warning mb-0">
                ⚠️ Real-world performance may vary based on weather, terrain,
                and installation conditions.
            </div>
        </div>

    </div>

    <!-- SCRIPT -->
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