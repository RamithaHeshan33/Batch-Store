<?php
    session_start();
    require 'connection.php';
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $email = $conn->real_escape_string($_POST['email']);
        $password = $_POST['password'];
    
        // Fetch user data
        $query = $conn->query("SELECT * FROM user WHERE email='$email'");
        if ($query->num_rows > 0) {
            $user = $query->fetch_assoc();
            // Verify password
            if (password_verify($password, $user['password'])) {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['user_name'] = $user['name'];
                $_SESSION['email'] = $user['email'];
                header('Location: dashboard.php');
            } else {
                echo "Invalid credentials.";
            }
        } else {
            echo "No user found with this email.";
        }
    }
    
    $conn->close();
    ?>

    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Document</title>
    </head>
    <body>
    <form action="login.php" method="POST">
        <label for="email">Email:</label>
        <input type="email" name="email" required>
        <label for="password">Password:</label>
        <input type="password" name="password" required>
        <button type="submit">Login</button>
    </form>

    </body>
    </html>

