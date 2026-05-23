<?php
$conn = new mysqli("localhost", "root", "", "solar_db");

$rows = $_POST['rows'] ?? null;
$cols = $_POST['cols'] ?? null;
$land = $_POST['land'] ?? null;
$mode = $_POST['mode'] ?? null;
$direction = $_POST['direction'] ?? null;
$efficiency = $_POST['efficiency'] ?? null;
$energy = $_POST['energy'] ?? null;

$sql = "INSERT INTO simulation_history 
(rows_count, cols_count, land_area, sun_mode, sun_direction, efficiency, energy, created_at)
VALUES (?, ?, ?, ?, ?, ?, ?, NOW())";

$stmt = $conn->prepare($sql);
$stmt->bind_param(
    "iiddsdd",
    $rows,
    $cols,
    $land,
    $mode,
    $direction,
    $efficiency,
    $energy
);

$stmt->execute();

echo "<script>
    alert('✅ Simulation Saved Successfully!');
    window.location.href = 'history.php';
</script>";
exit;
