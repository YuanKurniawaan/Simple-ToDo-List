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

// Fetch the task details if the task_id is set
if (isset($_GET['task_id'])) {
    $task_id = $_GET['task_id'];

    // Prepare a statement to fetch the task details
    $stmt = $conn->prepare("SELECT * FROM tasks WHERE id = ? AND username = ?");
    $stmt->bind_param("is", $task_id, $_SESSION['username']);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $task = $result->fetch_assoc();  // Fetch the task data
    } else {
        // If no task found or not owned by the user, redirect to the list
        header("Location: todolist.php");
        exit();
    }
    $stmt->close();
}

// Handle form submission to update the task
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['updated_task'])) {
    $updated_task = $_POST['updated_task'];
    $task_id = $_POST['task_id'];

    $stmt = $conn->prepare("UPDATE tasks SET task = ? WHERE id = ? AND username = ?");
    $stmt->bind_param("sis", $updated_task, $task_id, $_SESSION['username']);
    $stmt->execute();
    $stmt->close();

    // Redirect to the to-do list page after updating
    header("Location: todolist.php");
    exit();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Task</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h2>Perbarui nama Tugas anda</h2>

    <form method="POST" action="">
        <input type="hidden" name="task_id" value="<?php echo htmlspecialchars($task['id']); ?>">
        <label for="updated_task">Nama tugas baru :</label>
        <input type="text" id="updated_task" name="updated_task" value="<?php echo htmlspecialchars($task['task']); ?>" required>
        <button type="submit">Perbarui</button>
    </form>

    <a href="todolist.php" class="back-link">Kembali ke laman daftar tugas</a>
</body>
</html>
