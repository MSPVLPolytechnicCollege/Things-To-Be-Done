<?php
session_start();

date_default_timezone_set('Asia/Kolkata'); // Change to your region
$activeForm = "login"; 
$loginEmailError = $loginPasswordError = "";
$signupEmailError = $signupPasswordError = $confirmPasswordError = "";
$registrationSuccess = false;


$servername = "localhost";
$username = "root";
$password = "";
$dbname = "user_database"; 


$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (isset($_POST["action"]) && $_POST["action"] === "login") {
        $email = trim($_POST["email"]);
        $password = trim($_POST["password"]);

        if (empty($email)) {
            $loginEmailError = "Username is required.";
        }

        if (empty($password)) {
            $loginPasswordError = "Password is required.";
        }
       
        if (empty($loginEmailError) && empty($loginPasswordError)) {
            $stmt = $conn->prepare("SELECT password FROM users WHERE email = ?");
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $stmt->store_result();

            if ($stmt->num_rows > 0) {
                $stmt->bind_result($storedPassword);
                $stmt->fetch();

               
                if ($password === $storedPassword) {
                    $_SESSION['user'] = $email;  
                    header("Location: home.php");  
                    exit();
                } else {
                    $loginError = "Incorrect password.";
                }
            } else {
                $loginError = "No account found with this Username.";
            }
            echo "<script>alert('$loginError'); window.location.href='main.html';</script>";
            $stmt->close();
        }
        $activeForm = "login";
    }

    if (isset($_POST["action"]) && $_POST["action"] === "signup") {
        $email = trim($_POST["signupEmail"]);
        $password = trim($_POST["signupPassword"]);
        $confirmPassword = trim($_POST["confirmPassword"]);
        $created_time=date("Y-m-d H:i:s");
        if (empty($email)) {
            $signupEmailError = "Username is required.";
        }
        if (empty($password)) {
            echo "<script>alert('Password is Required'); window.location.href='main.html';</script>";
            exit();
        } elseif (strlen($password) < 6) {
            echo "<script>alert('Password atleast must be 6 characters.'); window.location.href='main.html';</script>";
            exit();
        }

        if ($password !== $confirmPassword) {
            echo "<script>alert('Confirm Password Does not match'); window.location.href='main.html';</script>";
            exit();
        }
        if($email==="admin" && $password==="mspvlce1052" && $confirmPassword==="mspvlce1052"){
            header("Location:admin.php");
            exit();
        }
      
        if (empty($signupEmailError) && empty($signupPasswordError) && empty($confirmPasswordError)) {
            
            $stmt = $conn->prepare("SELECT email FROM users WHERE email = ?");
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $stmt->store_result();

            if ($stmt->num_rows > 0) {
                echo "<script>alert('Username Already exists.'); window.location.href='main.html';</script>";
                exit();
            } else {
                
                $query = "INSERT INTO users (email, password, created) 
              VALUES ('$email', '$password', '$created_time')";

            if (mysqli_query($conn, $query)) {
                    $registrationSuccess = true;  
                    header("Location: main.html");  

  
    $sql = "CREATE TABLE `$email` (
        task_id INT AUTO_INCREMENT PRIMARY KEY,
        task_name VARCHAR(50) NOT NULL,
        datetime DATETIME NOT NULL,
        notification DATETIME NOT NULL
    )";
    $conn->query($sql);

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $_SESSION['userText'] = $_POST['userText'];
    }
    

                    exit();  
                } else {
                    echo "<script>alert('Error Creating Account Please try again.'); window.location.href='main.html';</script>";
                }
                $stmt->close();
            }
        }
        $activeForm = "signup";
    }
}

$conn->close();
?>
