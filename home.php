<?php
session_start();
if (!isset($_SESSION['user'])) {
    header("Location: main.html"); // Redirect to login if not logged in
    exit();
}
$userEmail = $_SESSION['user']; // Get logged-in user email
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

        /* Main Content */
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
    top: 60px; /* Adjusted to be below the nav */
    right: 20px;
    display: flex;
    flex-direction: column;
    align-items: flex-end;
    gap: 10px; /* Space between elements */
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

    pre{
        font-size:18px;
    }

    </style>
</head>
<body>
 

    <!-- Navigation Menu -->
    <nav>
       
        <a href=".html" target="frame2">Features</a>
        
        <a href="C:\Users\student\Desktop\contact\main.html" target="frame2">Contact</a>
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
        <h1>our Solution for Everything</h1>
        <p><pre>Setting goals is the first step in turning the invisible into the visible.
💨User authentication 
💨Task storage
💨Task prioritization
💨Time notification
💨Avoid web page complexity
💨Feedback by user</pre>
        </p>
        <a href="add _task.php" class="cta-button">Get Started</a>
    </div>

    <!-- Footer Section -->
    <footer >
        <p>&copy; 2025 Your Company. All Rights Reserved.</p>
    </footer>

</body>
</html>
