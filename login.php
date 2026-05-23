<?php
session_start();
include("db.php");

if (isset($_POST['login'])) {

    $email = $_POST['email'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM users WHERE email='$email'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {

        $user = $result->fetch_assoc();

        if (password_verify($password, $user['password'])) {

            $_SESSION['user'] = $user['name'];

            header("Location: dashboard.php");
        } else {
            $error = "Wrong Password";
        }
    } else {
        $error = "User not found";
    }
}
?>

<!doctype html>
<html>

<head>
    <title>Login</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />

    <style>
        body {
            background: #0f172a;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
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

        <h3 class="text-center">Login</h3>

        <?php if (isset($error)) echo "<p class='text-danger'>$error</p>"; ?>

        <form method="POST">

            <input type="email" name="email" class="form-control mb-2" placeholder="Email" required>

            <input type="password" name="password" class="form-control mb-3" placeholder="Password" required>

            <button class="btn btn-primary w-100" name="login">Login</button>

            <a href="register.php">Create account</a>

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