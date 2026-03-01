<?php
session_start();
if (!isset($_SESSION['userid'])) {
    header("Location: ../auth/login.php");
    exit();
}

$userid = $_SESSION['userid'];
$conn = new mysqli('localhost', 'root', '', 'eduplatform');
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT c.courseid, c.coursename, e.duration, e.background, p.suggestedprice, p.status, p.priceid
        FROM enrollments e
        JOIN courses c ON e.courseid = c.courseid
        LEFT JOIN pricing p ON p.enrollid = e.enrollid
        WHERE e.userid = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $userid);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="../assets/style.css">
    <title>My Courses</title>
</head>
<body>

<div class="container">
    <h2>My Enrolled Courses</h2>

    <?php
    if ($result && $result->num_rows > 0) {
        echo "<table>
                <tr>
                    <th>Course</th>
                    <th>Duration (weeks)</th>
                    <th>Background</th>
                    <th>Price Status</th>
                </tr>";

        while ($row = $result->fetch_assoc()) {
            $coursename = htmlspecialchars($row['coursename']);
            $duration = htmlspecialchars($row['duration']);
            $background = htmlspecialchars($row['background']);
            
            $price = $row['suggestedprice'] !== null ? number_format($row['suggestedprice'], 2) : "Pending";
            $priceStatus = $row['status'] ?? 'pending';

            echo "<tr>
                <td>$coursename</td>
                <td>{$duration} weeks</td>
                <td>$background</td>
                <td>";

            if ($row['suggestedprice'] === null) {
                echo "Awaiting teacher offer";
            } else {
                echo "$$price <br>Status: " . ucfirst($priceStatus);
                if ($priceStatus === 'pending') {
                    echo "
                        <form method='post' action='respond_price.php' style='display:inline;'>
                            <input type='hidden' name='priceid' value='" . $row['priceid'] . "'>
                            <button name='action' value='accept'>Accept</button>
                            <button name='action' value='reject'>Reject</button>
                        </form>";
                }
            }

            echo "</td></tr>";
        }

        echo "</table>";
    } else {
        echo "<p>You are not enrolled in any courses yet.</p>";
    }

    $sql = "SELECT * FROM courses 
            WHERE courseid NOT IN (
                SELECT courseid FROM enrollments WHERE userid = $userid
            )";
    $result = $conn->query($sql);

    if ($result && $result->num_rows > 0) {
        echo "<h2>Available Courses to Enroll</h2>";
        echo "<table>
                <tr>
                    <th>Course</th>
                    <th>Duration (weeks)</th>
                    <th>Background</th>
                    <th>Action</th>
                </tr>";

        while ($row = $result->fetch_assoc()) {
            echo "<form method='post' action='enrollcourse.php'>
                    <tr>
                        <td>" . htmlspecialchars($row['coursename']) . "</td>
                        <td><input type='number' name='duration' required></td>
                        <td><input type='text' name='background' required></td>
                        <td>
                            <input type='hidden' name='courseid' value='" . $row['courseid'] . "'>
                            <button type='submit' name='register'>Register</button>
                        </td>
                    </tr>
                  </form>";
        }

        echo "</table>";
    } else {
        echo "<p>All courses already enrolled.</p>";
    }

    $conn->close(); 
    ?>

    <br>
    <a href="studentdashboard.php" class="btn">Back to Dashboard</a>
</div>

</body>
</html>
