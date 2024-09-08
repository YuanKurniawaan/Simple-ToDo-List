<?php
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: index.php");
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

if (isset($_GET['task_id'])) {
    $task_id = $_GET['task_id'];

    $stmt = $conn->prepare("DELETE FROM tasks WHERE id = ? AND username = ?");
    $stmt->bind_param("is", $task_id, $_SESSION['username']);
    $stmt->execute();
    $stmt->close();
}

$conn->close();
header("Location: todolist.php");
exit();
?>
