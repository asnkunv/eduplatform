<?php
$conn = new mysqli('localhost', 'root', '', 'eduplatform');

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$userid = $_POST['userid'];
$courseid = $_POST['courseid'];
$background = $_POST['background'];
$duration = $_POST['duration'];

$sql = "INSERT INTO applications (userid, courseid, background, duration) VALUES ('$userid', '$courseid', '$background', '$duration')";

if ($conn->query($sql)) {
    echo "<p>Registration successful. Please wait for the teacher to assign a price.</p>";
    echo "<a href='../student/studentdashboard.php'>Go to Student Dashboard</a>";
} else {
    echo "Error: " . $conn->error;
}

$conn->close();
?>
