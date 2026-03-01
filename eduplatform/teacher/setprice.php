<?php
session_start();
if (!isset($_SESSION['userid']) || $_SESSION['user_type'] !== 'teacher') {
    header("Location: ../auth/login.php");
    exit();
}

$teacherid = $_SESSION['userid'];

$conn = new mysqli('localhost', 'root', '', 'eduplatform');
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$enrollid = $_POST['enrollid'];
$price = $_POST['price'];

$check = $conn->query("SELECT * FROM pricing WHERE enrollid = '$enrollid' AND teacherid = '$teacherid'");
if ($check->num_rows > 0) {
    $sql = "UPDATE pricing SET suggestedprice = '$price' WHERE enrollid = '$enrollid' AND teacherid = '$teacherid'";
} else {
    $sql = "INSERT INTO pricing (enrollid, teacherid, suggestedprice) VALUES ('$enrollid', '$teacherid', '$price')";
}

if ($conn->query($sql)) {
    header("Location: teacherdashboard.php");
} else {
    echo "Error: " . $conn->error;
}

$conn->close();
?>
