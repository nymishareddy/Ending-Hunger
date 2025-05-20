<?php
session_start();
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $password = md5($_POST['password']); // Hash the input password to compare with the hashed password in the database

    // Database connection
    $servername = "localhost";
    $username = "root";
    $dbpassword = "";  // Changed variable name to avoid conflict with $password
    $dbname = "only_hunger_db";
    $port = 3307;

    $conn = new mysqli($servername, $username, $dbpassword, $dbname, $port);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "SELECT * FROM volunteers WHERE email='$email' AND password='$password'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $_SESSION['email'] = $email;
        header('Location: welcome.php'); // Redirect to a welcome page or dashboard
        exit();
    } else {
        echo "Invalid email or password.";
    }

    $conn->close();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Volunteer Login</title>
</head>
<body>
    <h2>Volunteer Login</h2>
    <form method="POST" action="login.php">
        <label for="email">Email:</label>
        <input type="email" name="email" required><br>
        <label for="password">Password:</label>
        <input type="password" name="password" required><br>
        <button type="submit">Login</button>
    </form>
</body>
</html>
