<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="../assets/style.css">
    <title>Admin Dashboard</title>
</head>
<body>
<div class="container">

    <?php
    session_start();
    if (!isset($_SESSION['userid'])) {
        header("Location: ../auth/login.html");
        exit();
    }

    echo "<p class='welcome'>Welcome, Admin! Your User ID is: <strong>" . $_SESSION['userid'] . "</strong></p>";
    ?>

    <h2>Admin Dashboard</h2>

    <h3>Add a New Course</h3>
    <form method="post" action="addcourse.php" class="form-box">
        <input type="text" name="coursename" placeholder="Course Name" required>
        <input type="submit" value="Add Course" class="btn">
    </form>

    <h3>Delete a Course</h3>
    <form method="post" action="deletecourse.php" class="form-box">
        <input type="number" name="courseid" placeholder="Course ID to Delete" required>
        <input type="submit" value="Delete Course" class="btn btn-danger">
    </form>

    <h3>Current Course List</h3>

    <?php
    $conn = new mysqli('localhost', 'root', '', 'eduplatform');
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "SELECT * FROM courses";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        echo "<table class='course-table'>
                <tr>
                    <th>Course ID</th>
                    <th>Course Name</th>
                </tr>";
        while ($row = $result->fetch_assoc()) {
            echo "<tr>
                    <td>{$row['courseid']}</td>
                    <td>{$row['coursename']}</td>
                  </tr>";
        }
        echo "</table>";
    } else {
        echo "<p>No courses available.</p>";
    }

    $conn->close();
    ?>

    <p><a href="../auth/logout.php" class="logout-link">Logout</a></p>

</div>
</body>
</html>
