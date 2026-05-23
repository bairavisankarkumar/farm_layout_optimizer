<?php
session_start();
$theme = $_SESSION['theme'] ?? 'light';
?>

<!doctype html>
<html>

<head>
  <title>Home</title>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet" />
  <link rel="stylesheet" href="style.css">

  <!-- ✅ ANIMATION CSS -->
  <style>
    .fade-up {
      opacity: 0;
      transform: translateY(25px);
      animation: fadeUp 0.8s ease forwards;
    }

    @keyframes fadeUp {
      to {
        opacity: 1;
        transform: translateY(0);
      }
    }

    .delay-1 {
      animation-delay: 0.2s;
    }

    .delay-2 {
      animation-delay: 0.4s;
    }

    .delay-3 {
      animation-delay: 0.6s;
    }

    /* Optional premium hover effect */
    .card-pro {
      transition: all 0.3s ease;
    }

    .card-pro:hover {
      transform: translateY(-5px);
      box-shadow: 0 12px 25px rgba(0, 0, 0, 0.15);
    }
  </style>
</head>

<body>

  <?php include("header.php"); ?>
  <?php include("sidenav.php"); ?>

  <div class="content">

    <!-- TITLE -->
    <div class="card card-pro p-3 mt-3 fade-up">
      <h3>🌞 Renewable Farm Layout Optimizer</h3>
    </div>

    <!-- DESCRIPTION -->
    <div class="card card-pro p-3 mt-3 fade-up delay-1">
      <p>
        The Renewable Farm Layout Optimizer is an intelligent simulation platform designed to
        enhance the efficiency of solar farm installations. It helps engineers, planners, and
        energy companies design optimized panel layouts that maximize energy production while
        minimizing losses caused by shading and improper spacing.
      </p>

      <p>
        Traditional solar farm planning methods often result in up to <b>25% energy loss</b>
        due to shadow overlap and inefficient panel placement. This system solves that problem
        using advanced grid-based modeling and optimization techniques.
      </p>

      <p>
        The tool allows users to visualize, simulate, and analyze solar panel arrangements
        for projects ranging from <b>1MW to 10MW</b>. With a user-friendly interface and
        interactive design features, users can easily adjust panel layouts in real-time.
      </p>
    </div>

    <!-- FEATURES -->
    <div class="card card-pro p-3 mt-3 fade-up delay-2">
      <h5>🚀 Key Features</h5>
      <ul>
        <li>📊 Grid-based solar panel layout simulation</li>
        <li>🌤️ Shadow analysis and loss reduction</li>
        <li>🧩 Drag-and-drop farm design interface</li>
        <li>⚡ Energy output estimation</li>
        <li>📐 Optimal spacing calculation between panels</li>
        <li>📍 Suitable for 1MW – 10MW solar projects</li>
      </ul>
    </div>

  </div>

  <script>
    window.onload = function() {
      let theme = "<?= $theme ?>";

      if (theme === "dark") {
        document.body.classList.add("dark");
      }
    };

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