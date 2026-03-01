<!DOCTYPE html>
<html>
<head>
    <title>Available Courses</title>
    <link rel="stylesheet" href="../assets/style.css">
</head>
<body>

<div class="container">
    <div class="navbar">
        <a href="../student/studentdashboard.php">Dashboard</a>
        <a href="../auth/logout.php">Logout</a>
    </div>

    <h1>Available Courses</h1>

    <?php
    $conn = new mysqli('localhost', 'root', '', 'eduplatform');
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "SELECT coursename, description FROM courses";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        echo "<table>
                <tr><th>Course Name</th><th>Description</th></tr>";
        while ($row = $result->fetch_assoc()) {
            echo "<tr>
                    <td>" . htmlspecialchars($row['coursename']) . "</td>
                    <td>" . htmlspecialchars($row['description']) . "</td>
                </tr>";
        }
        echo "</table>";
    } else {
        echo "<p>No courses found.</p>";
    }

    $conn->close();
    ?>
</div>

</body>
</html>
