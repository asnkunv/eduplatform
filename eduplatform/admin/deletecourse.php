<?php
$conn = new mysqli('localhost', 'root', '', 'eduplatform');
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$courseid = $_POST['courseid'];
$sql = "DELETE FROM courses WHERE courseid = '$courseid'";

if ($conn->query($sql)) {
    echo "<p>Course deleted successfully.</p>";
    echo "<a href='admindashboard.php'>Back to Admin Dashboard</a>";
} else {
    echo "Error: " . $conn->error;
}

$conn->close();
?>
