<?php
// Include the database connection file
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "user_database"; 

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $task = trim($_POST['task']);
    $date = trim($_POST['date']);
    $time = trim($_POST['time']);
    $userId = 1; // Replace with actual user id from session

    if (!empty($task) && !empty($date) && !empty($time)) {
        // Insert the task into the database
        $stmt = $conn->prepare("INSERT INTO task (user_id, name, date, time) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("isss", $userId, $task, $date, $time);

        if ($stmt->execute()) {
            echo "<script>alert('Task added successfully!'); window.location.href='index.php';</script>";
        } else {
            echo "<script>alert('Error adding task. Please try again.'); window.location.href='index.php';</script>";
        }

        $stmt->close();
    } else {
        echo "<script>alert('Invalid task data.'); window.location.href='index.php';</script>";
    }
}

$conn->close();
?>


<html>
    <head>
        <style>
            .left {
                margin: 0 0 0 0;
                display: inline-block;
                padding: 0 100px 100% 0;
                border: 1px solid skyblue;
                background-color: skyblue;
                color: aliceblue;
                position: fixed;
            }
            .anchor {
                overflow: hidden;
                background-color: #333;
            }

            .anchor a {
                float: left;
                color: #f2f2f2;
                text-align: center;
                padding: 14px 16px;
                text-decoration: none;
                font-size: 17px;
            }

            .anchor a:hover {
                background-color: #ddd;
                color: black;
            }

            .anchor a.active {
                background-color: #04AA6D;
                color: white;
            }
            .right {
                margin-left: 400px;
            }
            #task {
                font-size: 30px;
                font-family: 'Times New Roman', Times, serif;
            }
            #add {
                font-size: 30px;
                font-family: 'Times New Roman', Times, serif;
                background-color: deepskyblue;
                color: black;
                cursor: pointer;
            }
            #add:hover {
                opacity: 40%;
            }
            #user {
                float: right;
            }
            .tab-content {
                display: none;
            }
            .tab-link.active {
                background-color: #04AA6D;
                color: white;
            }
            .tab-content.active {
                display: block;
            }

            /* Styling for Date & Time inputs */
            #date-time-container {
                margin-top: 20px;
            }

            #date-time-container input {
                padding: 10px;
                font-size: 18px;
                margin-right: 10px;
                border-radius: 8px;
                border: 2px solid black;
            }

            #date-time-container button {
                padding: 10px 20px;
                background-color: darkorange;
                color: white;
                border: none;
                border-radius: 8px;
                cursor: pointer;
            }

            #date-time-container button:hover {
                opacity: 0.8;
            }

            .error {
                color: red;
                font-size: 14px;
                margin-top: 10px;
            }
        </style>
    </head>
    <body>
        <div class="container">
            <div class="left">
                <h2>Things To Be Done</h2>
            </div>
            <div class="right">
                <div class="anchor">
                    <a href="#home" class="tab-link active" title="Home" onclick="showTab('home')"><i class="fa-sharp fa-solid fa-house"></i></a>
                    <a href="#View" title="View" class="tab-link" onclick="showTab('view')"><i class="fa-solid fa-eye"></i></a>
                    <a href="#SetRemainder" class="tab-link" title="SetRemainder" onclick="showTab('setremainder')"><i class="fa-solid fa-clock"></i></a>
                    <a href="#Priority" class="tab-link" title="Priority" onclick="showTab('priority')"><i class="fa-solid fa-star"></i></a>
                </div>
                <div id="home" class="tab-content active">
                    <br><br><br>
                    <form method="POST" action="add_task.php">
                        <input type="text" placeholder="Add Task.." size="50" id="task" name="task">
                        <button type="button" id="add" onclick="addTask()">ADD</button>
                        <!-- Date and Time Inputs -->
                        <div id="date-time-container" style="display: none;">
                            <input type="date" id="taskDate" name="date" required>
                            <input type="time" id="taskTime" name="time" required>
                            <button type="submit">Set Task Date & Time</button>
                        </div>
                    </form>
                    <div class="error" id="dateTimeError"></div>
                </div>
                <div id="view" class="tab-content">
                    hii
                </div>
            </div>
        </div>
        
        <script>
            function showTab(tabName) {
                // Hide all tab content
                const allTabs = document.querySelectorAll('.tab-content');
                allTabs.forEach(tab => tab.classList.remove('active'));

                // Remove active class from all tab links
                const allLinks = document.querySelectorAll('.tab-link');
                allLinks.forEach(link => link.classList.remove('active'));

                // Show the selected tab content
                document.getElementById(tabName).classList.add('active');
                
                // Set the active class to the clicked link
                const activeLink = document.querySelector(`[href='#${tabName}']`);
                activeLink.classList.add('active');
            }

            // This function is called when the "ADD" button is clicked
            function addTask() {
                const taskInput = document.getElementById('task').value;
                
                // Validate if the task input is not empty
                if (taskInput.trim() === "") {
                    alert("Please enter a task.");
                    return;
                }
                
                // Display the date and time controls
                document.getElementById('date-time-container').style.display = "block";
            }
        </script>
    </body>
</html>


