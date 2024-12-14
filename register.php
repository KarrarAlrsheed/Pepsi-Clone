<?php
error_reporting(E_ALL); 
ini_set('display_errors', 1);

// Database connection
$servername = "localhost";
$username = "root";
$password = ""; // Default password for XAMPP is empty
$dbname = "user_registration";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get form data
$user = $_POST['username'];
$email = $_POST['email'];
$pass = $_POST['password'];

// Validate inputs
if (empty($user) || empty($email) || empty($pass)) {
    die("Please fill in all fields.");
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    die("Invalid email format.");
}

// Hash the password before storing it
$hashed_password = password_hash($pass, PASSWORD_DEFAULT);

// Use prepared statements to avoid SQL injection
$stmt = $conn->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
$stmt->bind_param("sss", $user, $email, $hashed_password);

if ($stmt->execute()) {
    echo "Registration successful!";
} else {
    echo "Error during registration. Please try again later.";
}

$stmt->close();
$conn->close();
?>
