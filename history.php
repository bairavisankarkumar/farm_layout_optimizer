<?php
session_start();
$theme = $_SESSION['theme'] ?? 'light';

include "db.php";

$result = $conn->query("SELECT * FROM simulation_history ORDER BY id DESC");
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
    <title>Simulation History</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet" />
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <?php include("header.php"); ?>
    <?php include("sidenav.php"); ?>

    <div class="content">
        <div class="card card-pro p-3 mt-3">
            <h3>📜 Simulation History</h3>

            <table class="table table-bordered mt-3">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Grid</th>
                        <th>Efficiency</th>
                        <th>Energy</th>
                        <th>Sun</th>
                        <th>Date</th>
                        <th>Action</th>
                    </tr>
                </thead>

                <tbody>
                    <?php while ($row = $result->fetch_assoc()) { ?>
                        <tr>
                            <td><?= $row['id'] ?></td>
                            <td><?= $row['rows_count'] ?> x <?= $row['cols_count'] ?></td>
                            <td><?= $row['efficiency'] ?>%</td>
                            <td><?= $row['energy'] ?> kWh</td>
                            <td><?= $row['sun_direction'] ?></td>
                            <td><?= $row['created_at'] ?></td>
                            <td>
                                <a class="btn btn-primary btn-sm" href="./simulation.php?id=<?= $row['id'] ?>">
                                    View Report
                                </a>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
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