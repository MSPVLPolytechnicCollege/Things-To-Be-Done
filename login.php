<?php
session_start();

// Initialize variables for handling errors and form state
$activeForm = "login"; // Default form is login
$loginEmailError = $loginPasswordError = "";
$signupEmailError = $signupPasswordError = $confirmPasswordError = "";
$registrationSuccess = false; // Flag for registration success

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

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Handle login form submission
    if (isset($_POST["action"]) && $_POST["action"] === "login") {
        $email = trim($_POST["email"]);
        $password = trim($_POST["password"]);

        if (empty($email)) {
            $loginEmailError = "Email is required.";
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $loginEmailError = "Invalid email format.";
        }

        if (empty($password)) {
            $loginPasswordError = "Password is required.";
        }

        if (empty($loginEmailError) && empty($loginPasswordError)) {
            // Validate user credentials without password hashing
            $stmt = $conn->prepare("SELECT password FROM users WHERE email = ?");
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $stmt->store_result();

            if ($stmt->num_rows > 0) {
                $stmt->bind_result($storedPassword);
                $stmt->fetch();

                // Direct password comparison (no hashing)
                if ($password === $storedPassword) {
                    $_SESSION['user'] = $email;  // Store user session
                    header("Location: index.php");  // Redirect to homepage after successful login
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

    // Handle signup form submission
    if (isset($_POST["action"]) && $_POST["action"] === "signup") {
        $email = trim($_POST["signupEmail"]);
        $password = trim($_POST["signupPassword"]);
        $confirmPassword = trim($_POST["confirmPassword"]);

        if (empty($email)) {
            $signupEmailError = "Email is required.";
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $signupEmailError = "Invalid email format.";
        }

        if (empty($password)) {
            $signupPasswordError = "Password is required.";
        } elseif (strlen($password) < 6) {
            $signupPasswordError = "Password must be at least 6 characters.";
        }

        if ($password !== $confirmPassword) {
            $confirmPasswordError = "Passwords do not match.";
        }

        // If there are no errors, insert into the database
        if (empty($signupEmailError) && empty($signupPasswordError) && empty($confirmPasswordError)) {
            // Check if email already exists
            $stmt = $conn->prepare("SELECT email FROM users WHERE email = ?");
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $stmt->store_result();

            if ($stmt->num_rows > 0) {
                $signupEmailError = "Email already exists.";
            } else {
                // Insert new user into database with plain text password
                $stmt = $conn->prepare("INSERT INTO users (email, password) VALUES (?, ?)");
                $stmt->bind_param("ss", $email, $password);

                if ($stmt->execute()) {
                    $registrationSuccess = true;  // Registration successful
                    header("Location: index.php");  // Redirect to login page after successful signup
                    exit();  // Ensure no further processing happens
                } else {
                    $signupEmailError = "Error creating account. Please try again.";
                }
                $stmt->close();
            }
        }
        $activeForm = "signup";
    }
}

// Close the database connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login and Signup</title>
    <style>
        /* CSS styles */
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-image:url(../../log/logimg.jpg);
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin: 0;
        }
        .container {
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 4px 10px black;
            width: 100%;
            max-width: 380px;
            transition: all 0.3s ease;
            outline: 4px solid red;
        }
        h2 {
            text-align: center;
            color: red;
            margin-bottom: 20px;
        }
        form {
            display: flex;
            flex-direction: column;
        }
        label {
            font-size: 16px;
            color: red;
            margin-bottom: 10px;
            font-family:'Trebuchet MS', 'Lucida Sans Unicode', 'Lucida Grande', 'Lucida Sans', Arial, sans-serif;
        }
        input {
            padding: 12px;
            border: 2px solid black;
            border-radius: 8px;
            margin-bottom: 15px;
            font-size: 16px;
            transition: border-color 0.3s;
        }
        input:focus {
            border-color:red;
            outline: none;
        }
        .error {
            color: red;
            font-size: 14px;
            margin-bottom: 10px;
        }
        button {
            background-color:red;
            color: black;
            padding: 12px;
            border: none;
            width: 300px;
            margin-left:35px;
            border-radius: 10px;
            outline:2px solid black;
            cursor: pointer;
            font-size: 20px;
            font-family:
            transition: background-color 0.3s ease;
            font-family:'Helvetica Neue',Arial, Helvetica, sans-serif,system-ui;
        }
        button:hover {
            background-color:black;
            color:red;
            outline:2px solid red;
        }
        .link {
            text-align: center;
            margin-top: 10px;
        }
        .link a {
            color:red;
            text-decoration: none;
            font-weight: 500;
        }
        .link a:hover {
            text-decoration: underline;
        }
        @media (max-width: 480px) {
            .container {
                width: 90%;
                padding: 20px;
            }
            button {
                padding: 10px;
            }
        }
    </style>
</head>
<body>
    <div class="container" id="loginContainer" style="<?php echo $activeForm === 'login' ? '' : 'display: none;'; ?>">
        <h2>LOGIN</h2>
        <form method="POST" action="">
            <input type="hidden" name="action" value="login">
            <label for="email">Email</label>
            <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($_POST['email'] ?? ''); ?>" required>
            <div class="error"><?php echo $loginEmailError; ?></div>

            <label for="password">Password</label>
            <input type="password" id="password" name="password" required>
            <div class="error"><?php echo $loginPasswordError; ?></div>

            <button type="submit">Login</button>
        </form>
        <div class="link">
            <p>New user? <a href="#" onclick="switchForm('signup')">Create an account</a></p>
        </div>
    </div>

    <div class="container" id="signupContainer" style="<?php echo $activeForm === 'signup' ? '' : 'display: none;'; ?>">
        <h2>SIGN UP</h2>
        <form method="POST">
            <input type="hidden" name="action" value="signup">
            <label for="signupEmail">Email</label>
            <input type="email" id="signupEmail" name="signupEmail" value="<?php echo htmlspecialchars($_POST['signupEmail'] ?? ''); ?>" required>
            <div class="error"><?php echo $signupEmailError; ?></div>

            <label for="signupPassword">Password</label>
            <input type="password" id="signupPassword" name="signupPassword" required>
            <div class="error"><?php echo $signupPasswordError; ?></div>

            <label for="confirmPassword">Confirm Password</label>
            <input type="password" id="confirmPassword" name="confirmPassword" required>
            <div class="error"><?php echo $confirmPasswordError; ?></div>

            <button type="submit">Sign Up</button>
        </form>
        <div class="link">
            <p>Already have an account? <a href="#" onclick="switchForm('login')">Login</a></p>
        </div>

        <?php if ($registrationSuccess): ?>
            <div class="success-message" style="color: green; text-align: center; margin-top: 20px;">
                <h3>Registration successful! You can now login.</h3>
            </div>
        <?php endif; ?>
    </div>

    <script>
        function switchForm(formType) {
            document.getElementById('loginContainer').style.display = formType === 'login' ? 'block' : 'none';
            document.getElementById('signupContainer').style.display = formType === 'signup' ? 'block' : 'none';
        }
    </script>
</body>
</html>
