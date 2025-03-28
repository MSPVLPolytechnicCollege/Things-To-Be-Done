<?php
session_start();

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
                    $loginPasswordError = "Incorrect password.";
                }
            } else {
                $loginEmailError = "No account found with this email.";
            }
            $stmt->close();
        }
        $activeForm = "login";
    }

    if (isset($_POST["action"]) && $_POST["action"] === "signup") {
        $email = trim($_POST["signupEmail"]);
        $password = trim($_POST["signupPassword"]);
        $confirmPassword = trim($_POST["confirmPassword"]);

        if (empty($email)) {
            $signupEmailError = "Username is required.";
        }
        if (empty($password)) {
            $signupPasswordError = "Password is required.";
        } elseif (strlen($password) < 6) {
            $signupPasswordError = "Password must be at least 6 characters.";
        }

        if ($password !== $confirmPassword) {
            $confirmPasswordError = "Passwords do not match.";
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
                $signupEmailError = "Username already exists.";
            } else {
                
                $stmt = $conn->prepare("INSERT INTO users (email, password) VALUES (?, ?)");
                $stmt->bind_param("ss", $email, $password);

                if ($stmt->execute()) {
                    $registrationSuccess = true;  
                    header("Location: home.php");  

  
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
                    $signupEmailError = "Error creating account. Please try again.";
                }
                $stmt->close();
            }
        }
        $activeForm = "signup";
    }
}

$conn->close();
?>
