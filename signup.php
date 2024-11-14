<?php
require 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $region = $_POST['region'];

    try {
        $stmt = $db->prepare("INSERT INTO users (email, password, region) VALUES (:email, :password, :region)");
        $stmt->execute([':email' => $email, ':password' => $password, ':region' => $region]);
        header("Location: login.php");
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Sign Up</title>
    <link rel="stylesheet" href="css/login.css">
</head>
<body>
    <form method="POST" action="signup.php">
        <input type="email" name="email" placeholder="Email" required>
        <input type="password" name="password" placeholder="Password" required>
        <input type="text" name="region" placeholder="Region" required>
        <button type="submit">Sign Up</button>
    </form>
</body>
</html>
