<?php
session_start();
if (!isset($_SESSION['user'])) {
    header("Location: main.html"); 
    exit();
}
$userEmail = $_SESSION['user']; 
?>




<!DOCTYPE html>
<html lang="en">
<head>
	 <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <title> Homepage</title>
    <link rel="stylesheet" href="menu.css">
    <style>
       
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
            color: white;
             height: 100vh;
            margin: 0;
            background-image: url('back.jpg'); 
            background-size: cover;  
            background-position: center; 
            background-repeat: no-repeat;  
        }
       

       
        nav {
            background-color: #444;
            padding: 10px 0;
            text-align: right;
        }

        nav a {
            color: white;
            text-decoration: none;
            padding: 10px 20px;
            margin: 0 10px;
            font-size: 16px;
        }

        nav a:hover {
            background-color: #575757;
            border-radius: 5px;
        }

        
        .main-content {
            text-align: center;
            padding: 40px 20px;
        }

        .main-content h1 {
            font-size: 2.5em;
            margin-bottom: 20px;
        }

        .main-content p {
            font-size: 1.2em;
            line-height: 1.6;
            margin-bottom: 30px;
        }

        .cta-button {
            background-color: #f44336;
            color: white;
            padding: 15px 30px;
            font-size: 18px;
            text-decoration: none;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }

        .cta-button:hover {
            background-color:  #fec27c;
        }

        footer {
	        margin-bottom:0%;
            background-color: #333;
            color: white;
            text-align: center;
            padding: 10px 0;
        }

.user-actions {
    position: absolute;
    top: 60px; 
    right: 20px;
    display: flex;
    flex-direction: column;
    align-items: flex-end;
    gap: 10px; 
}

.user-info {
    font-weight: bold;
    background-color: #444;
    padding: 8px 12px;
    border-radius: 5px;
    color: white;
}

.logout-btn a {
    display: block;
    text-align: center;
    background-color: #f44336;
    color: white;
    padding: 8px 12px;
    text-decoration: none;
    border-radius: 5px;
    transition: background-color 0.3s ease;
}

.logout-btn a:hover {
    background-color: #d32f2f;
}

    </style>
</head>
<body>
 
    <nav>
        <a href="features.html">Features</a>
        <a href="contact.html" >Contact</a>
    </nav>

    <div class="user-actions">
    <div class="user-info">👤 Logged in as: <?php echo htmlspecialchars($userEmail); ?></div>
    <div class="logout-btn"><a href="logout.php">🚪 Logout</a></div>
</div>




<div id="mySidenav" class="sidebar">
  <a href="home.php" title=" Home" id="home" class="cta-button">         Home   <i class="fa-solid fa-house"></i></a>
  <a href="add _task.php" class="cta-button" title=" Add Task"  id="addtask">    Add Task     <i class="fa-solid fa-circle-plus"></i></a>
  <a href="load.php" class="cta-button" title=" Remainder Details" id="remainder">         View Task <i class="fa-solid fa-calendar-week"></i> </a>
  <a href="contact.html" class="cta-button" title="Contact" id="contact">         Contact       <i class="fa-solid fa-mobile-retro"></i></a>
</div> 
    <div class="main-content" id="main">
       <body background="background.jpg" width="100%" height="100%"  text="white">
        <h1>Our Solution for Everything</h1>
        <p>Setting goals is the first step in turning the invisible into the visible.</p>
<ul style="list-style: none; padding: 0; font-size: 18px; line-height: 2; text-align: center;">
    <li>💨 User Authentication</li>
    <li>💨 Task Storage</li>
    <li>💨 Task Prioritization</li>
    <li>💨 Time Notification</li>
    <li>💨 Avoid Web Page Complexity</li>
    <li>💨 Feedback by User</li>
</ul>


        <a href="add _task.php" class="cta-button">Get Started</a>
    </div>

    <footer >
        <p>&copy; 2025 Your Company. All Rights Reserved.</p>
    </footer>

</body>
</html>
