<?php
// session_start();
$userName = $_SESSION['user'] ?? 'Guest';
?>

<!-- HEADER -->
<div class="header">
    <div class="d-flex align-items-center gap-2">
        <button class="btn btn-sm btn-light" onclick="toggleSidebar()">
            <i class="bi bi-list"></i>
        </button>
        <b>Solar Grid Optimizer Pro</b>
    </div>

    <div class="d-flex align-items-center gap-3 position-relative">

        <i class="bi bi-bell fs-5"></i>
        <i class="bi bi-moon" onclick="toggleDark()" style="cursor:pointer"></i>

        <!-- USER DROPDOWN -->
        <div class="user-box">
            <i class="bi bi-person-circle fs-4"></i>

            <div class="user-dropdown">
                <p class="mb-1"><b><?php echo $userName; ?></b></p>
                <hr class="my-1">
                <a href="logout.php">🚪 Logout</a>
            </div>
        </div>

    </div>
</div>