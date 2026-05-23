<!doctype html>
<html>

<head>
    <title>Home</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet" />
    <link rel="stylesheet" href="style.css">
</head>

<body>

    <?php include("header.php"); ?>
    <?php include("sidenav.php"); ?>

    <div class="content">
        <h3>🏠 Home</h3>

        <p>
            Solar Grid Optimizer is a simulation tool for designing efficient solar farms.
        </p>

        <p>
            It reduces shadow loss and improves energy output using grid-based modeling.
        </p>
    </div>

    <script>
        function toggleSidebar() {
            document.getElementById("sidebar").classList.toggle("collapsed");
        }

        function toggleDark() {
            document.body.classList.toggle("dark");
        }
    </script>

    <script src="script.js"></script>
</body>

</html>