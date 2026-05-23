function updateSystem() {

    let hours;

    // ================= TIME =================
    if (mode === "auto") {

        let now = new Date();

        hours =
            now.getHours() +
            now.getMinutes() / 60;

    } else {

        hours = manualTime;
    }

    // ================= SUN PATH =================
    let normalized =
        (hours - 6) / 12;

    let angle =
        normalized * Math.PI;

    let radius = 40;

    let x = 0;
    let z = 0;

    // ================= SUN DIRECTION =================
    if (sunDirection === "east") {

        x = Math.cos(angle) * radius;
        z = 15;

    }

    else if (sunDirection === "west") {

        x = -Math.cos(angle) * radius;
        z = -15;

    }

    else if (sunDirection === "north") {

        x = 15;
        z = Math.cos(angle) * radius;

    }

    else if (sunDirection === "south") {

        x = -15;
        z = -Math.cos(angle) * radius;
    }

    // SUN HEIGHT
    let y =
        Math.sin(angle) * radius;

    // ================= SUN POSITION =================
    sunLight.position.set(x, y, z);

    // ================= INFO PANEL =================
    document.getElementById("sunDir")
        .innerText =
        sunDirection.toUpperCase();

    document.getElementById("sunAngle")
        .innerText =
        (normalized * 180).toFixed(1) + "°";

    // ================= OPTIMIZER =================
    let data =
        solarOptimizer(hours);

    // ================= AUTO SUN TRACKING =================
    panels.forEach(group => {

        // SUN DIFFERENCE
        let dx =
            sunLight.position.x -
            group.position.x;

        let dz =
            sunLight.position.z -
            group.position.z;

        // ================= HORIZONTAL TWIST =================
        let rotateAngle =
            Math.atan2(dx, dz);

        // ROTATE WHOLE LAYOUT
        group.rotation.y =
            rotateAngle;

        // ================= PANEL TILT =================
        group.children[0].rotation.x =
            THREE.MathUtils.degToRad(
                -parseFloat(data.bestTilt)
            );

        // KEEP STAND STRAIGHT
        group.children[1].rotation.x = 0;

        // KEEP STRAIGHT
        group.rotation.z = 0;
    });

    // ================= DYNAMIC PANEL COLOR =================
    panels.forEach(group => {

        let panel =
            group.children[0];

        let intensity =
            data.sunlight / 100;

        panel.material.color.setRGB(

            0,

            0.2 + intensity * 0.5,

            0.5 + intensity * 0.5
        );
    });

    // ================= NIGHT MODE =================
    if (hours < 6 || hours > 18) {

        sunLight.intensity = 0.2;

    } else {

        sunLight.intensity = 1.5;
    }
}