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
$username = "root"; // Change if needed
$password = ""; // Change if needed
$database = "user_database"; // Your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get today's date
$today = date('Y-m-d');

// Fetch all tasks
$sql = "SELECT * FROM `$userEmail` ORDER BY datetime ASC";
$result = $conn->query($sql);
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <title>To-Do List</title>
    <style>
        /* Import Google Font */
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap');

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }

        /* Body Styling */
        body {
            background-color: #d8b9ff;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        /* Container */
        .container {
            width: 80%;
            height: 80vh;
            display: flex;
            background: #fff;
            border-radius: 15px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }

        /* Sidebar */
        .sidebar {
            width: 25%;
            background: #8e44ad;
            padding: 20px;
            color: white;
        }

        .sidebar h2 {
            margin-bottom: 30px;
        }

        .sidebar ul {
            list-style: none;
        }

        .sidebar ul li {
            padding: 10px;
            font-size: 16px;
            cursor: pointer;
            border-radius: 8px;
            transition: 0.3s;
        }

        .sidebar ul li:hover,
        .sidebar ul li.active {
            background: #6c3483;
            color: white;
        }

        /* Main Content */
        .main-content {
            flex: 1;
            padding: 30px;
            background: #f8f9fa;
        }

        /* Header */
        .header h2 {
            font-weight: 600;
            color: #333;
        }

        .header h3 {
            color: #6c3483;
            font-weight: 500;
        }

        /* Task List */
        .task-list {
            margin-top: 20px;
            display: flex;
            flex-direction: column;
            gap: 15px;
        }

        /* Task Box */
        .task {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 12px;
            border-radius: 8px;
            background: white;
            box-shadow: 0px 2px 6px rgba(0, 0, 0, 0.1);
            transition: transform 0.2s ease-in-out;
        }

        .task:hover {
            transform: scale(1.02);
            background: #f0e6ff;
        }

        /* Task Name */
        .task-name {
            font-size: 16px;
            font-weight: 500;
            color: #333;
        }

        /* Task Time */
        .task-time {
            font-size: 14px;
            color: #777;
        }

        /* Task Icons */
        .task-icons {
            display: flex;
            gap: 10px;
            align-items: center;
        }

        .task-icons i {
            font-size: 16px;
            cursor: pointer;
            transition: 0.3s;
        }

        /* Icon Colors */
        .notify:hover { color: #f39c12; } /* Orange */
        .edit:hover { color: #3498db; } /* Blue */
        .delete:hover { color: #e74c3c; } /* Red */

        /* Checkbox */
        .task-check {
            width: 18px;
            height: 18px;
            cursor: pointer;
        }

        /* Strike-through completed tasks */
        .task-check:checked + .task-name {
            text-decoration: line-through;
            color: #999;
        }

        /* Hide all tasks by default */
        .task {
            display: none;
        }

        /* Show tasks when active */
        .task.active {
            display: flex;
        }
    </style>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body>

<div class="container">
        <div class="sidebar">
            <h2>📋 To-Do</h2>
            <ul>
                <li class="active tab-link" data-filter="today">📌 Today's Tasks</li>
                <li class="tab-link" data-filter="all">📋 All Tasks</li>
                <li class="tab-link" data-filter="completed">✅ Completed Tasks</li>
            </ul>
            <div class="notification-toggle">
    <label>
        <input type="checkbox" id="notificationToggle" checked>
        Enable Notifications
    </label>
</div>

        </div>

        <div class="main-content">
            <div class="header">
                <h2>Task List</h2>
            </div>

            <div class="task-list">
            <?php
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $taskDate = date('Y-m-d', strtotime($row['datetime']));
        $taskClass = ($taskDate === $today) ? 'task today' : 'task all';
?>
        <div class="<?= $taskClass ?>">
            <span class="task-name"><?= htmlspecialchars($row['task_name']) ?></span>
            <span class="task-time"><?= date('Y-m-d H:i A', strtotime($row['datetime'])) ?></span>
            <div class="task-icons">
                <i class="fas fa-bell notify" title="<?= htmlspecialchars($row['notification']) ?>"></i>
                <span class="notify_time" hidden><?= date('Y-m-d H:i A', strtotime($row['notification'])) ?></span>
                <i class="fas fa-edit edit" data-id="<?= $row['task_id'] ?>"></i>
                <i class="fas fa-trash delete" data-id="<?= $row['task_id'] ?>"></i>
                <input type="checkbox" class="task-check" data-id="<?= $row['task_id'] ?>">
            </div>
        </div>
<?php
    }
} else {
    echo "<p>No tasks found.</p>";
}
?>
            </div>
        </div>
    </div>

    <script>
        // Tab Switching Logic
        document.querySelectorAll(".tab-link").forEach(tab => {
            tab.addEventListener("click", function() {
                document.querySelectorAll(".tab-link").forEach(item => item.classList.remove("active"));
                this.classList.add("active");

                let filter = this.getAttribute("data-filter");

                document.querySelectorAll(".task").forEach(task => {
                    if (filter === "all") {
                        task.style.display = "flex";
                    } else if (filter === "completed") {
                        task.style.display = task.querySelector(".task-check").checked ? "flex" : "none";
                    } else if (filter === "today") {
                        task.style.display = task.classList.contains("today") ? "flex" : "none";
                    }
                });
            });
        });

        // Edit Task Functionality
        document.querySelectorAll(".edit").forEach(editBtn => {
            editBtn.addEventListener("click", function() {
                let taskId = this.getAttribute("data-id");
                let newTaskName = prompt("Edit Task Name:");
                if (newTaskName !== null && newTaskName.trim() !== "") {
                    fetch('edit_task.php', {
                        method: 'POST',
                        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                        body: `task_id=${taskId}&task_name=${encodeURIComponent(newTaskName)}`
                    }).then(response => response.text()).then(data => location.reload());
                }
            });
        });

        // Delete Task Functionality
        document.querySelectorAll(".delete").forEach(deleteBtn => {
            deleteBtn.addEventListener("click", function() {
                let taskId = this.getAttribute("data-id");
                if (confirm("Are you sure you want to delete this task?")) {
                    fetch('delete_task.php', {
                        method: 'POST',
                        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                        body: `task_id=${taskId}`
                    }).then(response => response.text()).then(data => location.reload());
                }
            });
        });

        window.onload = function() {
        document.querySelector('.tab-link[data-filter="today"]').click();
    };

    let notificationEnabled = localStorage.getItem("notifications") !== "off"; // Store user preference

    document.getElementById("notificationToggle").addEventListener("change", function() {
        notificationEnabled = this.checked;
        localStorage.setItem("notifications", this.checked ? "on" : "off");
    });

    // Load saved setting
    document.getElementById("notificationToggle").checked = notificationEnabled;

    function checkNotifications() {
    if (!notificationEnabled) return;

    let now = new Date();
    let formattedNow = now.getFullYear() + "-" +
        ("0" + (now.getMonth() + 1)).slice(-2) + "-" +
        ("0" + now.getDate()).slice(-2) + " " +
        ("0" + now.getHours()).slice(-2) + ":" +
        ("0" + now.getMinutes()).slice(-2);

    console.log("Checking for notifications at:", formattedNow); // Debugging

    document.querySelectorAll(".task").forEach(task => {
        let taskTime = task.querySelector(".notify_time").innerText.trim().slice(0, 16); // Ensure format matches

        console.log("Task Time:", taskTime); // Debugging

        if (taskTime === formattedNow && !task.dataset.notified) {
            task.dataset.notified = "true"; // Mark as notified
            let message = task.querySelector(".task-name").innerText;
            playNotification(message);
        }
    });
}

function playNotification(message) {
    let audio = new Audio("notification.mp3");
    audio.play();

    // Show a browser notification
    if (Notification.permission === "granted") {
        new Notification("Task Reminder", { body: message });
    } else {
        alert("⏰ Task Due: " + message);
    }
}

// Request Notification Permission
if (Notification.permission !== "granted") {
    Notification.requestPermission();
}

// Run check every 10 seconds for testing (Change to 60000 for 1 min in production)
setInterval(checkNotifications, 10000);

    </script>

</body>
</html>

<?php
$conn->close();
?>
