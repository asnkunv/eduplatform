<?php
session_start();

if (!isset($_SESSION['userid'])) {
    header("Location: ../auth/login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['priceid'], $_POST['action'])) {
    $userid = $_SESSION['userid'];
    $priceid = intval($_POST['priceid']);
    $action = $_POST['action'];

    if (!in_array($action, ['accept', 'reject'])) {
        die("Invalid action.");
    }

    $conn = new mysqli('localhost', 'root', '', 'eduplatform');
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $stmt = $conn->prepare("SELECT p.priceid 
                            FROM pricing p
                            JOIN enrollments e ON p.enrollid = e.enrollid
                            WHERE p.priceid = ? AND e.userid = ?");
    $stmt->bind_param("ii", $priceid, $userid);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $stmt = $conn->prepare("UPDATE pricing SET status = ? WHERE priceid = ?");
        $stmt->bind_param("si", $action, $priceid);

        if ($stmt->execute()) {
            header("Location: mycourses.php");
            exit();
        } else {
            echo "Error updating the pricing status: " . $stmt->error;
        }
    } else {
        echo "Error: The pricing record doesn't match the current user.";
    }

    $stmt->close();
    $conn->close();
} else {
    echo "Invalid request.";
}
?>
