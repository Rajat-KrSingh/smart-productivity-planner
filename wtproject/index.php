<?php
session_start();
$conn = mysqli_connect("localhost","root","","todo_project");

if(isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $result = mysqli_query($conn, "SELECT * FROM users WHERE username='$username' AND password='$password'");
    
    if(mysqli_num_rows($result) > 0) {
        $user = mysqli_fetch_assoc($result);
        $_SESSION['user_id'] = $user['id'];
        header("Location: description.php"); // Redirects to Description
        exit();
    } else {
        $error = "Invalid Username or Password!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login - Productivity Planner</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;500;700&display=swap" rel="stylesheet">
    <style>
        body {
            margin:0; padding:0; font-family:'Poppins',sans-serif;
            background: #0f172a; height: 100vh; display: flex; align-items: center; justify-content: center;
        }
        .login-card {
            background: white; padding: 40px; border-radius: 20px; width: 350px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.3); text-align: center;
        }
        input {
            width: 100%; padding: 12px; margin: 10px 0; border: 1px solid #ddd;
            border-radius: 10px; box-sizing: border-box;
        }
        button {
            width: 100%; padding: 12px; background: #1e3a8a; color: white;
            border: none; border-radius: 10px; font-weight: bold; cursor: pointer;
        }
        .error { color: red; font-size: 14px; margin-bottom: 10px; }
    </style>
</head>
<body>
    <div class="login-card">
        <h2>Admin Login</h2>
        <?php if(isset($error)) echo "<p class='error'>$error</p>"; ?>
        <form method="POST">
            <input type="text" name="username" placeholder="Username" required>
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit" name="login">Login</button>
        </form>
    </div>
</body>
</html>