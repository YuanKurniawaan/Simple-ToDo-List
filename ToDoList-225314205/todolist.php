<?php
session_start();

// Redirect to login page if the user is not logged in
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

// Handle form submission for adding new tasks
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['new_task'])) {
    $new_task = $_POST['new_task'];
    $username = $_SESSION['username'];

    $stmt = $conn->prepare("INSERT INTO tasks (username, task) VALUES (?, ?)");
    $stmt->bind_param("ss", $username, $new_task);
    $stmt->execute();
    $stmt->close();

    // Redirect to the same page to prevent form resubmission and refresh the task list
    header("Location: todolist.php");
    exit();
}

// Fetch tasks for the logged-in user
$username = $_SESSION['username'];
$stmt = $conn->prepare("SELECT * FROM tasks WHERE username = ?");
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your To-Do List</title>
    <link rel="stylesheet" href="style.css"/>
</head>
<body>
    <h2>Selamat Datang, <?php echo htmlspecialchars($_SESSION['username']); ?>! Ini Tugas anda :</h2>
    
    <ul>
    <?php while ($row = $result->fetch_assoc()): ?>
        <li class="<?php echo $row['completed'] ? 'completed' : ''; ?>">
            <span class="task-text"><?php echo htmlspecialchars($row['task']); ?></span>
            <div class="task-actions">
                <?php if (!$row['completed']): ?>
                    <a href="completed.php?task_id=<?php echo $row['id']; ?>">Selesai</a>
                    <a href="update.php?task_id=<?php echo $row['id']; ?>">Perbarui</a>
                <?php endif; ?>
                <a href="delete.php?task_id=<?php echo $row['id']; ?>">Hapus</a>
            </div>
        </li>
    <?php endwhile; ?>
</ul>


    <form method="POST" action="">
        <label for="new_task">Tambahkan tugas baru :</label>
        <input type="text" id="new_task" name="new_task" required>
        <button type="submit">Tambahkan tugas</button>
    </form>

    <a href="logout.php" class="back-link">Keluar</a>
</body>
</html>
