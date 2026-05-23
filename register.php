<?php include("db.php"); ?>

<?php
if (isset($_POST['register'])) {

    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $sql = "INSERT INTO users (name,email,password) VALUES ('$name','$email','$password')";
    $conn->query($sql);

    header("Location: login.php");
}
?>

<!doctype html>
<html>

<head>
    <title>Register</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />

    <style>
        body {
            background: #0f172a;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            font-family: Arial;
        }

        .card-box {
            width: 400px;
            background: white;
            padding: 20px;
            border-radius: 12px;
        }
    </style>

</head>

<body>

    <div class="card-box">

        <h3 class="text-center">Register</h3>

        <form method="POST">

            <input type="text" name="name" class="form-control mb-2" placeholder="Name" required>

            <input type="email" name="email" class="form-control mb-2" placeholder="Email" required>

            <input type="password" name="password" class="form-control mb-3" placeholder="Password" required>

            <button class="btn btn-success w-100" name="register">Register</button>

            <a href="login.php">Already have account?</a>

        </form>

    </div>

    <script>
        function toggleSidebar() {
            document.getElementById("sidebar").classList.toggle("collapsed");
        }

        function toggleDark() {
            document.body.classList.toggle("dark");
        }
    </script>

</body>

</html>