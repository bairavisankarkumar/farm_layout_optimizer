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
    <title>Dashboard</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet" />
    <link rel="stylesheet" href="style.css">
</head>

<body>

    <?php include("header.php"); ?>
    <?php include("sidenav.php"); ?>

    <div class="content">
        <div class="card card-pro p-3 mt-3">
            <h3>📊 Dashboard</h3>

            <div>

                <p>
                    Displays real-time solar environment data like sun direction, weather, and location.
                </p>

                <ul>
                    <li>Sun direction tracking</li>
                    <li>Temperature monitoring</li>
                    <li>Location detection</li>
                </ul>
            </div>
        </div>


    </div>

    <script>
        function toggleSidebar() {
            document.getElementById("sidebar").classList.toggle("collapsed");
        }

        function toggleDark() {
            let isDark = document.body.classList.toggle("dark");

            let theme = isDark ? "dark" : "light";

            fetch("theme.php?theme=" + theme);
        }
    </script>

    <script src="script.js"></script>
</body>

</html>