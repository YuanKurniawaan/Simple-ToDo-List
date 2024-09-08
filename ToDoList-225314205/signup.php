<?php
session_start();

$servername = "localhost";
$username = "root";
$password = "";
$database = "to-do-list";

$conn = new mysqli($servername, $username, $password, $database);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle form submission for user registration
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['signup'])) {
    $new_username = $_POST['username'];
    $new_password = $_POST['password'];

    // Hash the password
    $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);

    // Prepare a statement to insert the new user
    $stmt = $conn->prepare("INSERT INTO user (username, password) VALUES (?, ?)");
    $stmt->bind_param("ss", $new_username, $hashed_password);
    
    if ($stmt->execute()) {
        header("Location: signup.php?success=1");
        exit();
    } else {
        echo "<p>Proses Pembuatan akun terjadi masalah, silahkan coba kembali.</p>";
    }

    $stmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pendaftaran Akun</title>
    <link rel="stylesheet" href="style.css"/>
</head>
<body>
    <h2>Laman Pendaftaran Akun</h2>

    <?php
    if (isset($_GET['success']) && $_GET['success'] == 1) {
        echo "<p style='color: green;'>Akun berhasil terbuat, sekarang anda bisa <a href='index.php'>Masuk</a>.</p>";
    }
    ?>

    <form method="POST" action="">
        <label for="username">Nama Pengguna :</label>
        <input type="text" id="username" name="username" required>
        <br>
        <label for="password">Kata Sandi :</label>
        <input type="password" id="password" name="password" required>
        <br>
        <button type="submit" name="signup">! Daftar Sekarang !</button>
    </form>

    <a href="index.php" class="back-link">Kembali ke Laman Awal</a>
</body>
</html>
