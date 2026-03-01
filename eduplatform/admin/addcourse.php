<?php
$conn = new mysqli('localhost', 'root', '', 'eduplatform');
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$coursename = $_POST['coursename'];
$sql = "INSERT INTO courses (coursename) VALUES ('$coursename')";

if ($conn->query($sql)) {
    echo "<p>Course added successfully.</p>";
    echo "<a href='admindashboard.php'>Back to Admin Dashboard</a>";
} else {
    echo "Error: " . $conn->error;
}

$conn->close();
?>
