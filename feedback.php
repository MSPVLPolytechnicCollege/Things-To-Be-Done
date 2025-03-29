<?php
session_start();
if (!isset($_SESSION['user'])) {
    header("Location: main.html"); 
    exit();
}
$userEmail = $_SESSION['user']; 
?>

<?php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "user_database"; 

$conn = new mysqli($servername, $username, $password, $dbname);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = trim($_POST['name']); 
    $email = trim($_POST['email']); 
    $message = $_POST['message']; 

    $query ="INSERT INTO feedback (login_name,name,email,message) VALUES ('$userEmail', '$name', '$email', '$message')";

    if (mysqli_query($conn, $query)) {
        echo "<script>alert('feedback submitted successfully'); window.location.href='contact.php';</script>";
    } else {
        echo "Error: " . mysqli_error($conn);
    }
    
    mysqli_close($conn);
}
?>