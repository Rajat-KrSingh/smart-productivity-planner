<?php
session_start();
// Security Check: Kick out anyone who hasn't logged in
if(!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>About - Smart Productivity Planner</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;500;700&display=swap" rel="stylesheet">
    <style>
        body {
            margin:0; padding:0; font-family:'Poppins',sans-serif;
            background: linear-gradient(-45deg,#0f172a,#1e3a8a,#f97316,#ffffff);
            background-size: 400% 400%; animation: bgMove 12s ease infinite;
            height: 100vh; display: flex; align-items: center; justify-content: center;
        }
        @keyframes bgMove{ 0%{background-position:0% 50%;} 50%{background-position:100% 50%;} 100%{background-position:0% 50%;} }
        .hero {
            background: white; padding: 50px; border-radius: 25px;
            text-align: center; max-width: 600px; box-shadow: 0 10px 35px rgba(0,0,0,0.2);
            position: relative;
        }
        h1 { color: #1e3a8a; margin-bottom: 20px; }
        p { color: #555; line-height: 1.6; margin-bottom: 30px; }
        .btn {
            background: #f97316; color: white; padding: 15px 30px; display: inline-block;
            text-decoration: none; border-radius: 12px; font-weight: bold; transition: 0.3s;
        }
        .btn:hover { background: #ea580c; }
        .logout-link {
            position: absolute; top: 20px; right: 20px; color: #dc2626; text-decoration: none; font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="hero">
        <a href="toodoo.php?logout=true" class="logout-link">Logout</a>
        <h1>Project Description</h1>
        <p>Welcome to the <strong>Smart Productivity Planner</strong>. This web application helps users categorize tasks by priority, track tight deadlines, and monitor performance progress with real-time dynamic statistics. Stay focused, stay organized.</p>
        <a href="toodoo.php" class="btn">Launch Planner</a>
    </div>
</body>
</html>