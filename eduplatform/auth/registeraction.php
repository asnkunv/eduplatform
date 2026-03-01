<?php
$conn = new mysqli('localhost', 'root', '', 'eduplatform');
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$firstname = $conn->real_escape_string($_POST['firstname']);
$lastname = $conn->real_escape_string($_POST['lastname']);
$email = $conn->real_escape_string($_POST['email']);
$phone = $conn->real_escape_string($_POST['phone']);
$password = $conn->real_escape_string($_POST['password']);
$type = $_POST['type']; 

$check = $conn->query("SELECT * FROM users WHERE email = '$email'");
if ($check && $check->num_rows > 0) {
    echo "<p>User already exists with this email.</p>";
    echo "<a href='register.html'>Try Again</a>";
    exit;
}

$sql = "INSERT INTO users (firstname, lastname, email, phone, password, type) 
        VALUES ('$firstname', '$lastname', '$email', '$phone', '$password', '$type')";

if ($conn->query($sql)) {
    echo "<p>Registration successful!</p>";
    echo "<a href='login.html'>Login Now</a>";
} else {
    echo "<p>Error: " . $conn->error . "</p>";
}

$conn->close();
?>
