<?php
session_start();

if (isset($_SESSION['user_id'])) {
    header("Location: todolist.php");
    exit();
}

$servername = "localhost";
$username = "root";
$password = "";
$database = "to-do-list";

$conn = new mysqli($servername, $username, $password, $database);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="style.css"/>
</head>
<body>
    <h2>Situs Web Daftar Tugas sangat Gacoor</h2>
    <form id="loginForm" method="POST" action="">
        <label for="username">Nama Pengguna :</label>
        <input type="text" id="username" name="username" required>
        <br>
        <label for="password">Kata Sandi :</label>
        <input type="password" id="password" name="password" required>
        <br>
        <button type="submit">Masuk</button>
    </form>

    <!-- Sign-Up Button -->
    <form action="signup.php" method="GET">
        <button type="submit">Daftar</button>
    </form>

    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $input_username = $_POST['username'];
        $input_password = $_POST['password'];

        $stmt = $conn->prepare("SELECT * FROM user WHERE username = ?");
        $stmt->bind_param("s", $input_username);
        $stmt->execute();
        $result = $stmt->get_result();
        $user = $result->fetch_assoc();

        if ($user && password_verify($input_password, $user['password'])) {
            $_SESSION['username'] = $input_username;
            $_SESSION['user_id'] = $user['id'];
            header("Location: todolist.php");
            exit();
        } else {
            echo "<p>Nama Pengguna atau Kata Sandi salah silahkan coba kembali.</p>";
        }

        $stmt->close();
    }

    $conn->close();
    ?>
  <footer>
  <div class="small-profile-container">
    <img src="images/profile.png" alt="Foto Profil" class="small-profile-photo">
    <div class="small-profile-details">
        <p>Dibuat oleh <a href="https://wa.me/6281584344626?" target="_blank">YohanesYuan</a></p>
        <p>NIM: 225314205</p>
    </div>
    </div>
  </footer>

</body>
</html>
