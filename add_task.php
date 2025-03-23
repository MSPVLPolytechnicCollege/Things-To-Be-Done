

<?php
session_start();
if (!isset($_SESSION['user'])) {
    header("Location: main.html"); // Redirect to login if not logged in
    exit();
}
$userEmail = $_SESSION['user']; // Get logged-in user email
?>


<?php

// MySQL connection (adjust with your details)
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "user_database"; // Your DB name

// Establish a database connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}



if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $task_name = trim($_POST['taskInput']); // Task Name
    $task_datetime = trim($_POST['taskDateTime']); // Task DateTime
    $notification = $_POST['notification']; // Notification option

    // Convert notification preference to datetime
    switch ($notification) {
        case "One hour before":
            $notification_time = date("Y-m-d H:i:s", strtotime("-1 hour", strtotime($task_datetime)));
            break;
        case "One day before":
            $notification_time = date("Y-m-d H:i:s", strtotime("-1 day", strtotime($task_datetime)));
            break;
        case "One minute before":
                $notification_time = date("Y-m-d H:i:s", strtotime("-1 minute", strtotime($task_datetime)));
                break;
        case "After completion":
            $notification_time = NULL; // No predefined time, trigger after task completion
            break;
        default:
            $notification_time = $task_datetime; // Default to task datetime
    }
    

    // Insert task into the database
    $query = "INSERT INTO $userEmail (task_name, datetime, notification) 
              VALUES ('$task_name', '$task_datetime', '$notification_time')";

    if (mysqli_query($conn, $query)) {
        echo "<script>alert('Task added successfully!'); window.location.href='add _task.php';</script>";
    } else {
        echo "Error: " . mysqli_error($conn);
    }
    
    mysqli_close($conn);
}
?>