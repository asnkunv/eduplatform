<?php
session_start();

$conn = new mysqli('localhost', 'root', '', 'eduplatform');
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$email = $_POST['email'];
$password = $_POST['password'];

$sql = "SELECT * FROM users WHERE email = '$email' AND password = '$password'";
$result = $conn->query($sql);

if ($result && $result->num_rows == 1) {
    $user = $result->fetch_assoc();
    $_SESSION['userid'] = $user['userid'];
    $_SESSION['user_type'] = $user['type'];

    if ($user['type'] == 'student') {
        header("Location: ../student/studentdashboard.php");
    } elseif ($user['type'] == 'teacher') {
        header("Location: ../teacher/teacherdashboard.php");
    } elseif ($user['type'] == 'admin') {
        header("Location: ../admin/admindashboard.php");
    } else {
        echo "Unknown user type.";
    }
} else {
    echo "<p>Invalid email or password.</p>";
    echo "<a href='login.html'>Try Again</a>";
}

$conn->close();
?>
