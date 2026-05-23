let rows = 6;
let cols = 7;
let cells = [];

let sunDirection = "top";
let sunElevation = 85;
let userLat = 10;
let sunMode = "auto";
let isNight = false;

const grid = document.getElementById("grid");

// ================= CORE SYSTEM REFRESH =================
function refreshSystem() {
    updateDayNightMode();

    document.getElementById("sunDirText").innerText =
        isNight ? "NIGHT" : sunDirection.toUpperCase();

    calculateEfficiency();
}

// ================= DAY / NIGHT MODE =================
function updateDayNightMode() {
    if (sunElevation < 0) {
        isNight = true;
        enableNightMode();
    } else {
        isNight = false;
        enableDayMode();
    }
}

function enableNightMode() {
    document.body.classList.add("dark");

    document.getElementById("suggestions").innerText =
        "🌙 Night Mode - No Solar Production";

    document.getElementById("efficiency").innerText = "0%";
    document.getElementById("energy").innerText = "0 kWh";

    cells.forEach(c => {
        c.style.pointerEvents = "none";
        c.classList.remove("panel", "shadow");
    });
}

function enableDayMode() {
    document.body.classList.remove("dark");

    cells.forEach(c => {
        c.style.pointerEvents = "auto";
    });

    document.getElementById("suggestions").innerText =
        "☀️ Day Mode Active";
}

// ================= GRID CREATION =================
function createGrid() {
    grid.innerHTML = "";
    cells = [];

    rows = parseInt(document.getElementById("rowsInput").value);
    cols = parseInt(document.getElementById("colsInput").value);

    grid.style.gridTemplateColumns = `repeat(${cols}, 40px)`;

    for (let i = 0; i < rows * cols; i++) {
        let div = document.createElement("div");
        div.classList.add("cell");

        div.addEventListener("click", () => {
            div.classList.toggle("panel");
            calculateEfficiency();
        });

        grid.appendChild(div);
        cells.push(div);
    }
}

// ================= SUN MODE SWITCH =================
function changeSunMode() {
    sunMode = document.getElementById("sunMode").value;

    let manual = document.getElementById("manualSun");

    if (sunMode === "manual") {
        manual.disabled = false;
        setManualSun();
    } else {
        manual.disabled = true;
        getSunDirection();
    }

    refreshSystem();
}

// ================= MANUAL SUN =================
function setManualSun() {
    if (sunMode !== "manual") return;

    sunDirection = document.getElementById("manualSun").value;

    switch (sunDirection) {
        case "top": sunElevation = 85; break;
        case "bottom": sunElevation = 30; break;
        case "left":
        case "right": sunElevation = 45; break;
    }

    refreshSystem();
}

// ================= GRID FROM LAND =================
function calculateGridFromLand() {
    let land = parseFloat(document.getElementById("landArea").value);

    if (!land || land <= 0) {
        alert("Enter valid land area!");
        return;
    }

    const PANEL_FOOTPRINT = 4;

    let totalPanels = Math.floor(land / PANEL_FOOTPRINT);

    let r = Math.floor(Math.sqrt(totalPanels));
    let c = Math.ceil(totalPanels / r);

    document.getElementById("gridSuggest").innerText = `${r} × ${c}`;

    document.getElementById("rowsInput").value = r;
    document.getElementById("colsInput").value = c;

    createGrid();
    calculateEfficiency();
}

// ================= AUTO SUN (REAL LOCATION) =================
function getSunDirection() {
    if (sunMode === "manual") return;

    navigator.geolocation.getCurrentPosition(pos => {

        let lat = pos.coords.latitude;
        let lng = pos.coords.longitude;

        userLat = lat;

        let sun = SunCalc.getPosition(new Date(), lat, lng);

        let az = (sun.azimuth * 180 / Math.PI + 180) % 360;

        if (az >= 45 && az < 135) sunDirection = "right";
        else if (az >= 135 && az < 225) sunDirection = "bottom";
        else if (az >= 225 && az < 315) sunDirection = "left";
        else sunDirection = "top";

        sunElevation = sun.altitude * (180 / Math.PI);

        updateDayNightMode();
        refreshSystem();
    });
}

// ================= WEATHER =================
async function getWeather() {
    if (!navigator.geolocation) return;

    navigator.geolocation.getCurrentPosition(async pos => {

        let lat = pos.coords.latitude;
        let lon = pos.coords.longitude;

        try {
            let locRes = await fetch(
                `https://nominatim.openstreetmap.org/reverse?lat=${lat}&lon=${lon}&format=json`
            );
            let locData = await locRes.json();

            document.getElementById("locationName").innerText =
                locData.address.city ||
                locData.address.town ||
                locData.address.village ||
                "Unknown";

            let weatherRes = await fetch(
                `https://api.open-meteo.com/v1/forecast?latitude=${lat}&longitude=${lon}&current_weather=true`
            );

            let weatherData = await weatherRes.json();

            document.getElementById("temperature").innerText =
                weatherData.current_weather?.temperature ?? "N/A";

        } catch (err) {
            document.getElementById("locationName").innerText = "Unavailable";
            document.getElementById("temperature").innerText = "--";
        }
    });
}

// ================= SPACING =================
function autoCalculateSpacing() {
    let height = 2;
    let tilt = Math.abs(userLat) * 0.9;

    document.getElementById("tiltAngle").innerText = tilt.toFixed(2);

    let effAngle = sunElevation - tilt;
    if (effAngle < 5) effAngle = 5;

    let spacing = height / Math.tan((effAngle * Math.PI) / 180);
    spacing = Math.max(1, Math.min(spacing, 10));

    document.getElementById("autoHeight").innerText = height;
    document.getElementById("autoSpacing").innerText = spacing.toFixed(2);

    return spacing;
}

// ================= AUTO OPTIMIZE =================
function autoOptimize() {
    if (isNight) {
        alert("Night Mode Active - Optimization Disabled 🌙");
        return;
    }

    resetGrid();

    let spacing = autoCalculateSpacing();
    let gap = Math.ceil(spacing / 1.5);

    for (let i = 0; i < rows; i += gap) {
        for (let j = 0; j < cols; j += gap) {
            let index = i * cols + j;
            if (cells[index]) cells[index].classList.add("panel");
        }
    }

    calculateEfficiency();
}

// ================= EFFICIENCY ENGINE =================
function calculateEfficiency() {

    // reset shadows
    cells.forEach(c => c.classList.remove("shadow"));

    let selected = cells.filter(c => c.classList.contains("panel"));
    let total = selected.length;

    if (total === 0) {
        document.getElementById("efficiency").innerText = "0%";
        document.getElementById("energy").innerText = "0 kWh";
        return;
    }

    if (isNight) {
        cells.forEach(c => c.classList.remove("panel", "shadow"));
        return;
    }

    let spacing = autoCalculateSpacing();

    let shadowFactor = (90 - sunElevation) / 90;
    let shadowCells = Math.max(0, Math.ceil((spacing / 1.5) * shadowFactor));

    let shadow = 0;

    for (let i = 0; i < cells.length; i++) {

        if (!cells[i].classList.contains("panel")) continue;

        for (let d = 1; d <= shadowCells; d++) {

            let s = null;

            if (sunDirection === "top") s = i + cols * d;
            if (sunDirection === "bottom") s = i - cols * d;
            if (sunDirection === "left") s = i + d;
            if (sunDirection === "right") s = i - d;

            if (cells[s] && cells[s].classList.contains("panel")) {
                cells[s].classList.add("shadow");
                shadow++;
                break;
            }
        }
    }

    let eff = ((total - shadow) / total) * 100;

    document.getElementById("efficiency").innerText = eff.toFixed(2) + "%";
    document.getElementById("energy").innerText =
        ((total - shadow) * 2).toFixed(2) + " kWh";

    document.getElementById("suggestions").innerText =
        shadow === 0 ? "Perfect Layout ✅" : "Adjust spacing ⚠️";
        
}
function fillFormData() {
    document.getElementById("form_rows").value = rows;
    document.getElementById("form_cols").value = cols;
    document.getElementById("form_land").value = document.getElementById("landArea").value;
    document.getElementById("form_mode").value = document.getElementById("sunMode").value;
    document.getElementById("form_direction").value = sunDirection;

    document.getElementById("form_efficiency").value =
        document.getElementById("efficiency").innerText.replace("%", "").trim();

    document.getElementById("form_energy").value =
        document.getElementById("energy").innerText.replace(" kWh", "").trim();
}
// ================= RESET =================
function resetGrid() {
    cells.forEach(c => c.classList.remove("panel", "shadow"));
}

// ================= INIT =================
createGrid();
getSunDirection();
getWeather();