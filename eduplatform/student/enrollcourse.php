<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();

if (!isset($_SESSION['userid'])) {
    header("Location: ../auth/login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $userid = $_SESSION['userid'];

    if (isset($_POST['courseid']) && is_numeric($_POST['courseid'])) {
        $courseid = intval($_POST['courseid']);
        $duration = intval($_POST['duration']);  
        $background = trim($_POST['background']);  

        $conn = new mysqli('localhost', 'root', '', 'eduplatform');
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        $checkCourseSql = "SELECT * FROM courses WHERE courseid = ?";
        $stmt = $conn->prepare($checkCourseSql);
        $stmt->bind_param("i", $courseid);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows === 0) {
            echo "Error: The selected course does not exist.";
            exit();
        }

        $insertSql = "INSERT INTO enrollments (userid, courseid, duration, background) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($insertSql);
        $stmt->bind_param("iiis", $userid, $courseid, $duration, $background);

        if ($stmt->execute()) {
            header("Location: mycourses.php"); 
            exit();
        } else {
            echo "Error: " . $stmt->error;
        }

        $stmt->close();
        $conn->close();
    } else {
        echo "Error: Invalid course selection.";
    }
} else {
    echo "Invalid request.";
}
?>
