<?php
session_start();
if (!isset($_SESSION['user_type']) || $_SESSION['user_type'] !== 'teacher') {
    header('Location: ../auth/login.html');
    exit();
}

if (!isset($_SESSION['userid'])) {
    header("Location: ../auth/login.php");
    exit();
}

$teacher_id = $_SESSION['userid'];

$conn = new mysqli('localhost', 'root', '', 'eduplatform');
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "
SELECT 
    e.enrollid,
    u.firstname,
    u.lastname,
    c.coursename,
    e.background,
    e.duration,
    p.suggestedprice
FROM enrollments e
JOIN users u ON e.userid = u.userid
JOIN courses c ON e.courseid = c.courseid
LEFT JOIN pricing p ON e.enrollid = p.enrollid AND p.teacherid = $teacher_id
WHERE p.teacherid IS NULL OR p.teacherid = $teacher_id
";

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="../assets/style.css">
    <title>Teacher Dashboard</title>
</head>
<body>
<div class="container">
    <h2>Teacher Dashboard - Course Enrollments</h2>

    <p>Welcome! Your User ID is: <strong><?php echo $_SESSION['userid']; ?></strong></p>
    <a href="../auth/logout.php" class="btn logout">Logout</a>

    <?php if ($result && $result->num_rows > 0): ?>
        <table>
            <tr>
                <th>Enroll ID</th>
                <th>Student</th>
                <th>Course</th>
                <th>Background</th>
                <th>Duration</th>
                <th>Your Price</th>
                <th>Set Price</th>
            </tr>
            <?php while ($row = $result->fetch_assoc()) { ?>
                <tr>
                    <td><?php echo $row['enrollid']; ?></td>
                    <td><?php echo htmlspecialchars($row['firstname'] . ' ' . $row['lastname']); ?></td>
                    <td><?php echo htmlspecialchars($row['coursename']); ?></td>
                    <td><?php echo htmlspecialchars($row['background']); ?></td>
                    <td><?php echo $row['duration']; ?> weeks</td>
                    <td><?php echo $row['suggestedprice'] ? '$' . $row['suggestedprice'] : 'Not Set'; ?></td>
                    <td>
                        <form action="setprice.php" method="post">
                            <input type="hidden" name="enrollid" value="<?php echo $row['enrollid']; ?>">
                            <input type="text" name="price" placeholder="Enter Price" required>
                            <input type="submit" value="Set" class="btn">
                        </form>
                    </td>
                </tr>
            <?php } ?>
        </table>
    <?php else: ?>
        <p>No student enrollments available.</p>
    <?php endif; ?>
</div>
</body>
</html>

<?php $conn->close(); ?>
