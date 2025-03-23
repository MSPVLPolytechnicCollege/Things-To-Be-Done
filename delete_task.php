<?php
session_start();
if (!isset($_SESSION['user'])) {
    header("Location: main.html"); // Redirect to login if not logged in
    exit();
}
$userEmail = $_SESSION['user']; // Get logged-in user email
?>

<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "user_database";

$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_POST['task_id'])) {
    $task_id = intval($_POST['task_id']);
    $sql = "DELETE FROM `$userEmail` WHERE task_id=$task_id";

    if ($conn->query($sql) === TRUE) {
        echo "Task deleted successfully";
    } else {
        echo "Error deleting task: " . $conn->error;
    }
}

$conn->close();
?>