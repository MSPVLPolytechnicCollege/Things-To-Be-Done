<?php
session_start();
if (!isset($_SESSION['user'])) {
    header("Location: main.html"); // Redirect to login if not logged in
    exit();
}
$userEmail = $_SESSION['user']; // Get logged-in user email
?>


<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <title>Smart To-Do List</title>
    <link rel="stylesheet" href="menu.css">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            text-align: center;
            margin: 50px;
            background: url('download.gif') no-repeat center center fixed;
            background-size: cover;
        }
        .container {
            width: 50%;
            margin: auto;
            background: #fff;
            padding: 20px;
            border-radius: 15px;
            box-shadow: 0px 5px 15px rgba(0, 0, 0, 0.2);
            animation: fadeIn 0.6s ease-in-out;
        }
        h2 { 
            color: #333; 
            font-weight: 600;
        }

        .tabs {
            display: flex;
            justify-content: center;
            margin-bottom: 15px;
        }
        .tab {
            padding: 10px 20px;
            margin: 0 5px;
            cursor: pointer;
            border-radius: 20px;
            background: #ddd;
            font-size: 16px;
            transition: all 0.3s ease-in-out;
        }
        .tab.active {
            background: #007bff;
            color: white;
            transform: scale(1.1);
        }
        .tab:hover {
            background: #0056b3;
            color: white;
        }

        input, button {
            width: 80%;
            padding: 12px;
            margin: 10px 0;
            border: none;
            border-radius: 5px;
            font-size: 16px;
        }
        input {
            border: 1px solid #ccc;
            transition: all 0.3s ease-in-out;
        }
        input:focus {
            outline: none;
            border: 1px solid #007bff;
            box-shadow: 0 0 5px rgba(0, 123, 255, 0.5);
        }
        button {
            background: #007bff;
            color: white;
            cursor: pointer;
            transition: 0.3s;
        }
        button:hover {
            background: #0056b3;
            transform: scale(1.05);
        }

        .task-container {
            margin-top: 15px;
            max-height: 250px;
            overflow-y: auto;
            border: 1px solid #ddd;
            border-radius: 5px;
            background: #fff;
        }
        .task-item {
            padding: 12px;
            border-bottom: 1px solid #eee;
            font-size: 16px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            background: #f9f9f9;
            transition: transform 0.3s ease-in-out, opacity 0.3s ease-in-out;
        }
        .task-item:hover {
            background: #e9f7ff;
            transform: scale(1.02);
        }
        .task-item.completed {
            background: #d4f8d4;
            text-decoration: line-through;
            color: gray;
        }
        .task-item.fade-out {
            transform: translateX(100%);
            opacity: 0;
        }

        .task-actions button {
            padding: 6px 10px;
            font-size: 14px;
            margin-left: 5px;
            cursor: pointer;
            border-radius: 5px;
            border: none;
            transition: 0.3s;
        }
        .complete-btn {
            background: #28a745;
            color: white;
        }
        .complete-btn:hover {
            background: #1e7e34;
        }
        .delete-btn {
            background: red;
            color: white;
        }
        .delete-btn:hover {
            background: darkred;
        }

        .task-time {
            font-size: 12px;
            color: gray;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .user-info {
    position: absolute;
    top: 20px;
    right: 20px;
    font-weight: bold;
    background: rgba(255, 255, 255, 0.2); /* Light semi-transparent background */
    padding: 12px 18px;
    border-radius: 10px;
    color: white;
    font-size: 16px;
    box-shadow: 0px 4px 10px rgba(255, 255, 255, 0.3); /* Light glow */
    backdrop-filter: blur(8px); /* Frosted glass effect */
    transition: transform 0.3s ease-in-out, box-shadow 0.3s ease-in-out;
}

.user-info:hover {
    transform: scale(1.05);
    box-shadow: 0px 6px 15px rgba(255, 255, 255, 0.5); /* Glow effect on hover */
}

    </style>
</head>
<>

<div class="user-info">👤 Logged in as: <?php echo htmlspecialchars($userEmail); ?></div>


<div id="mySidenav" class="sidenav">
    <a href="home.php" title=" Home" id="home" class="cta-button">         Home   <i class="fa-solid fa-house"></i></a>
    <a href="add _task.html" class="cta-button" title=" Add Task"  id="addtask">    Add Task     <i class="fa-solid fa-circle-plus"></i></a>
    <a href="load.php" class="cta-button" title=" Remainder Details" id="remainder">         View Task <i class="fa-solid fa-calendar-week"></i> </a>
    <a href="contact.html" class="cta-button" title="Contact" id="contact">         Contact       <i class="fa-solid fa-mobile-retro"></i></a>
    <a href="logout.html" class="cta-button" title="Log Out" id="logout">         Log Out      <i class="fa-solid fa-person-through-window"></i></a>
     
  </div> 
  <div class="container">
  
    
        <h2> Smart To-Do List</h2>
    <form action="add_task.php" method="POST">
        <input type="text" id="taskInput" name="taskInput" placeholder=" Add a new task" required>
        <input type="datetime-local" id="taskDateTime" name="taskDateTime" required>
        <!-- Task List -->
        <div class="task-container" id="taskList"></div>
    <div id="notificationDiv">
            <label>Notification:</label>
            <select name="notification" required>
                <option value="One hour before">One hour before</option>
                <option value="One day before">One day before</option>
                <option value="One minute before">One minute before</option>
                <option value="After completion">After completion</option>
            </select>
            <button type="submit">Add Task</button>
        </div>

    </form>
    </div>
</body>
</html>