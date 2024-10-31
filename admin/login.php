<?php
session_start();
include '../db.php';

$error_message = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    $password = md5($password);

    $query = "SELECT * FROM admin WHERE username = '$username' AND password = '$password'";
    $result = mysqli_query($conn, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        $_SESSION['admin_logged_in'] = true;
        header('Location: admin_dashboard.php');
        exit;
    } else {
        $error_message = "Username atau password salah.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../resources/style.css">
    <title>Document</title>
</head>
<body>
    <div class="login-container">
    <img src="../resources/itech.png" alt="">
        <h2>Login Admin</h2>
<form action="login.php" method="POST">
    <label for="username">Username:</label>
    <input type="text" id="username" name="username" required>
    <label for="password">Password:</label>
    <input type="password" id="password" name="password" required>
    <button type="submit">Login</button>
</form>
    </div>

    <?php if (!empty($error_message)) : ?>
        <script>
            alert("<?php echo $error_message; ?>");
        </script>
    <?php endif; ?>

</body>
</html>
