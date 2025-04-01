<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Centered Tab Switcher</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            background-color: #f4f4f4;
        }
        .container {
            text-align: center;
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 90%;
            height: 80%;
            overflow-y: auto;
        }
        .tabs {
            margin-bottom: 10px;
        }
        .tab-button {
            padding: 10px 20px;
            cursor: pointer;
            border: none;
            background-color: lightgray;
            margin: 5px;
            border-radius: 5px;
        }
        .tab-button.active {
            background-color: dodgerblue;
            color: white;
        }
        .tab-content {
            display: none;
            padding: 20px;
            border-top: 2px solid #ddd;
        }
        .tab-content.active {
            display: block;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: left;
        }
        th {
            background-color: dodgerblue;
            color: white;
        }
    </style>
</head>
<body>

    <div class="container">
        <div class="tabs">
            <button class="tab-button active" onclick="switchTab('tab1')">Sign Up Users</button>
            <button class="tab-button" onclick="switchTab('tab2')">Feedback By Users</button>
        </div>

        <div id="tab1" class="tab-content active">
            <h2>Users Signed Up</h2>
            <table>
                <tr>
                    <th>ID</th>
                    <th>USERNAME</th>
                    <th>PASSWORD</th>
                    <th>CREATED_ON</th>
                </tr>
                <?php
                $conn = new mysqli("localhost", "root", "", "user_database");

                if ($conn->connect_error) {
                    die("Connection failed: " . $conn->connect_error);
                }

                $sql = "SELECT id, email, password,created FROM users"; 
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>
                                <td>{$row['id']}</td>
                                <td>{$row['email']}</td>
                                <td>{$row['password']}</td>
                                <td>{$row['created']}</td>
                              </tr>";
                    }
                } else {
                    echo "<tr><td colspan='4'>No users found</td></tr>";
                }

                // Close connection
                $conn->close();
                ?>
            </table>
        </div>

        <div id="tab2" class="tab-content">
            <h2>Feedback by Users</h2>
            <table>
                <tr>
                    <th>LOGIN USERNAME</th>
                    <th>NAME</th>
                    <th>EMAIL</th>
                    <th>MESSAGE</th>
                </tr>
                <?php
                $conn = new mysqli("localhost", "root", "", "user_database");

                if ($conn->connect_error) {
                    die("Connection failed: " . $conn->connect_error);
                }

                $sql = "SELECT login_name, name, email,message FROM feedback"; 
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>
                                <td>{$row['login_name']}</td>
                                <td>{$row['name']}</td>
                                <td>{$row['email']}</td>
                                <td>{$row['message']}</td>
                              </tr>";
                    }
                } else {
                    echo "<tr><td colspan='4'>No users found</td></tr>";
                }

                // Close connection
                $conn->close();
                ?>
            </table>
        </div>
    </div>

    <script>
        function switchTab(tabId) {
            document.querySelectorAll('.tab-button').forEach(btn => btn.classList.remove('active'));
            document.querySelectorAll('.tab-content').forEach(content => content.classList.remove('active'));

            document.querySelector(`[onclick="switchTab('${tabId}')"]`).classList.add('active');
            document.getElementById(tabId).classList.add('active');
        }
    </script>

</body>
</html>
