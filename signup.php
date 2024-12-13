<?php
$servername = "localhost";
$username = "root"; // default username in XAMPP
$password = ""; // default password in XAMPP
$dbname = "myuser_db";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user = $_POST['username'];
    $pass = $_POST['password'];

    // Hash password
    $hashed_password = password_hash($pass, PASSWORD_DEFAULT);

    // Prepare and bind
    $stmt = $conn->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
    $stmt->bind_param("ss", $user, $hashed_password);

    if ($stmt->execute()) {
        echo "User registered successfully!";
        header("Location: index.html"); // Redirect to login page after successful registration
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
}

$conn->close();
?>
