<?php
require 'connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $conn->real_escape_string($_POST['name']);
    $email = $conn->real_escape_string($_POST['email']);
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);

    $checkQuery = $conn->query("SELECT * FROM user WHERE email='$email'");
    if (!$checkQuery) {
        die("Error: " . $conn->error);
    }

    if ($checkQuery->num_rows > 0) {
        $message = "Email already registered.";
    } else {
        // Insert user data
        $query = "INSERT INTO user (name, email, password) VALUES ('$name', '$email', '$password')";
        if (!$conn->query($query)) {
            $message = "Error: " . $conn->error;
        } else {
            $message = "Registration successful!";
        }
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Registration</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            margin: 0;
            padding: 0;
            background: #f4f4f9;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .container {
            background: #fff;
            padding: 2rem;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px;
        }
        h1 {
            font-size: 24px;
            margin-bottom: 1rem;
            color: #333;
            text-align: center;
        }
        .form-group {
            margin-bottom: 1rem;
        }
        .form-group label {
            display: block;
            font-weight: 700;
            margin-bottom: 0.5rem;
            color: #555;
        }
        .form-group input {
            width: 100%;
            padding: 0.75rem;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 16px;
        }
        .form-group input:focus {
            border-color: #007bff;
            outline: none;
        }
        .form-group button {
            width: 100%;
            padding: 0.75rem;
            background: #007bff;
            border: none;
            color: #fff;
            font-size: 16px;
            border-radius: 4px;
            cursor: pointer;
            font-weight: bold;
        }
        .form-group button:hover {
            background: #0056b3;
        }
        .message {
            margin-top: 1rem;
            text-align: center;
            font-weight: bold;
            color: #d9534f;
        }
        .success {
            color: #5cb85c;
        }
        p {
            text-align: center;
            text-decoration: none;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>User Registration</h1>
        <?php if (!empty($message)) : ?>
            <div class="message <?= strpos($message, 'successful') !== false ? 'success' : '' ?>">
                <?= $message ?>
            </div>
        <?php endif; ?>
        <form action="register.php" method="POST">
            <div class="form-group">
                <label for="name">Name:</label>
                <input type="text" name="name" id="name" required>
            </div>
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" name="email" id="email" required>
            </div>
            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" name="password" id="password" required>
            </div>
            <div class="form-group">
                <button type="submit">Register</button>
            </div>

            <p>Already Registered? Please <a href="login.php">Login</a></p>
        </form>
    </div>
</body>
</html>
