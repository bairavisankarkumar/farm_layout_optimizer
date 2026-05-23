<?php
session_start();

$conn = new mysqli("localhost", "root", "", "solar_db");

$theme = $_SESSION['theme'] ?? 'light';

$simulation = null;

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);

    $stmt = $conn->prepare("SELECT * FROM simulation_history WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();

    $result = $stmt->get_result();
    $simulation = $result->fetch_assoc();
}
?>
<script>
    const simulation = <?= json_encode($simulation) ?>;
</script>
<script>
    window.onload = function() {
        let theme = "<?= $theme ?>";

        if (theme === "dark") {
            document.body.classList.add("dark");
        }

        if (simulation) {
            document.getElementById("rowsInput").value = simulation.rows_count;
            document.getElementById("colsInput").value = simulation.cols_count;
            document.getElementById("landArea").value = simulation.land_area;

            document.getElementById("sunMode").value = simulation.sun_mode;
            document.getElementById("manualSun").value = simulation.sun_direction;
            document.getElementById("manualSun").disabled = (simulation.sun_mode !== "manual");
            // IMPORTANT: wait for JS functions
            setTimeout(() => {
                createGrid();
                calculateEfficiency();
            }, 100);
        }
    };
</script>

<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <title>Ultra Pro Solar Grid Dashboard</title>
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet" />
    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css"
        rel="stylesheet" />

    <script src="https://cdn.jsdelivr.net/npm/suncalc@1.9.0/suncalc.js"></script>
    <link rel="stylesheet" href="./style.css">
</head>

<body>

    <?php include('./header.php'); ?>
    <?php include('./sidenav.php'); ?>

    <!-- CONTENT -->
    <div class="content">
        <h4 class="mb-3">☀️ Solar Grid Optimizer</h4>

        <div class="row g-3">
            <!-- ================= LEFT SIDE ================= -->
            <div class="col-lg-4">
                <!-- CONTROLS -->
                <div class="card card-pro p-3 mb-3">
                    <h6>⚙️ Controls</h6>
                    <div class="row mb-2">
                        <div class="col-6">
                            <label>Rows</label>
                            <input type="number" id="rowsInput" value="<?= $simulation['rows_count'] ?? 6 ?>" class="form-control" />

                        </div>
                        <div class="col-6">
                            <label>Cols</label>
                            <input type="number" id="colsInput" value="<?= $simulation['cols_count'] ?? 7 ?>" class="form-control" />

                        </div>
                    </div>

                    <div class="mb-2">
                        <label>Land (sq.ft)</label>
                        <input type="number" id="landArea" value="<?= $simulation['land_area'] ?? 1000 ?>" class="form-control" />

                    </div>
                    <div class="row mt-3">
                        <div class="col-6">
                            <button class="btn btn-primary" onclick="createGrid()">
                                Create Grid
                            </button>
                        </div>
                        <div class="col-6">
                            <button
                                class="btn btn-success"
                                onclick="calculateGridFromLand()">
                                Auto Grid
                            </button>
                        </div>
                    </div>
                    <div class="mt-3 d-grid gap-2 mb-3">
                        <button class="btn btn-info" onclick="calculateEfficiency()">
                            Analyze
                        </button>
                    </div>

                    <div class="row mb-3">
                        <div class="col-6">
                            <label>Sun Mode</label>
                            <select
                                id="sunMode"
                                class="form-select"
                                onchange="changeSunMode()">
                                <option value="auto" <?= ($simulation['sun_mode'] ?? '') == 'auto' ? 'selected' : '' ?>>Auto</option>
                                <option value="manual" <?= ($simulation['sun_mode'] ?? '') == 'manual' ? 'selected' : '' ?>>Manual</option>
                            </select>
                        </div>
                        <div class="col-6">
                            <label>Direction</label>
                            <select
                                id="manualSun"
                                class="form-select"
                                onchange="setManualSun()"
                                disabled>
                                <option value="top" <?= ($simulation['sun_direction'] ?? '') == 'top' ? 'selected' : '' ?>>Top</option>
                                <option value="bottom" <?= ($simulation['sun_direction'] ?? '') == 'bottom' ? 'selected' : '' ?>>Bottom</option>
                                <option value="left" <?= ($simulation['sun_direction'] ?? '') == 'left' ? 'selected' : '' ?>>Left</option>
                                <option value="right" <?= ($simulation['sun_direction'] ?? '') == 'right' ? 'selected' : '' ?>>Right</option>
                            </select>
                        </div>
                    </div>

                    <div class="mt-3 d-grid gap-2">
                        <button class="btn btn-warning" onclick="autoOptimize()">
                            Auto Optimize
                        </button>

                        <button class="btn btn-danger" onclick="resetGrid()">
                            Reset
                        </button>
                        <form method="POST" action="save_simulation.php" onsubmit="fillFormData()">

                            <input type="hidden" name="rows" id="form_rows">
                            <input type="hidden" name="cols" id="form_cols">
                            <input type="hidden" name="land" id="form_land">
                            <input type="hidden" name="mode" id="form_mode">
                            <input type="hidden" name="direction" id="form_direction">
                            <input type="hidden" name="efficiency" id="form_efficiency">
                            <input type="hidden" name="energy" id="form_energy">

                            <button type="submit" class="btn btn-success">
                                💾 Save Simulation
                            </button>

                        </form>
                    </div>
                </div>
            </div>

            <!-- ================= RIGHT SIDE ================= -->
            <div class="col-lg-8">
                <!-- INFO -->

                <div class="card card-pro p-3">
                    <h6>📊 Info Panel</h6>
                    <div class="row">
                        <div class="col-4">
                            <p>☀️ Sun Direction: <b id="sunDirText">TOP</b></p>
                            <p>🧭 Sun Angle: <span id="sunAngleText">--</span></p>
                            <p>Tilt: <span id="tiltAngle">0</span>°</p>
                        </div>
                        <div class="col-4">
                            <p>Height: <span id="autoHeight">0</span> m</p>
                            <p>Spacing: <span id="autoSpacing">0</span> m</p>
                        </div>
                        <div class="col-4">
                            <p>📍 Location: <span id="locationName">-</span></p>
                            <p>🌡 Temp: <span id="temperature">-</span> °C</p>
                            <p>Suggested Grid: <span id="gridSuggest">-</span></p>
                        </div>
                    </div>
                </div>
                <!-- GRID -->
                <div class="card card-pro p-3 mt-3">
                    <h6>🟩 Solar Panel Grid</h6>

                    <div id="grid"></div>
                </div>

                <!-- RESULT -->
                <div class="card card-pro p-3 mt-3">
                    <h6>📈 Results</h6>
                    <div class="row">
                        <div class="col-4">
                            <h5>Efficiency: <span id="efficiency"><?= $simulation['efficiency'] ?? 0 ?>%</span></h5>
                        </div>
                        <div class="col-4">
                            <h5>Energy: <span id="energy"><?= $simulation['energy'] ?? 0 ?> kWh</span></h5>
                        </div>
                        <div class="col-4">
                            <h5 id="suggestions"></h5>
                        </div>
                    </div>
                </div>
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

    <!-- YOUR ORIGINAL LOGIC FILE -->

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
<script src="script.js"></script>

</html>