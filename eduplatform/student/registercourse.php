<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="../assets/style.css">
    <title>Register for a Course</title>
</head>
<body>

<div class="container">
    <h2>Course Registration Form</h2>

    <form action="../auth/submit_registration.php" method="post" class="form-box">
        <div class="form-group">
            <label for="userid">User ID:</label>
            <input type="text" name="userid" id="userid" required>
        </div>

        <div class="form-group">
            <label for="courseid">Choose Course:</label>
            <select name="courseid" id="courseid" required>
                <?php
                $conn = new mysqli('localhost', 'root', '', 'eduplatform');
                if ($conn->connect_error) {
                    die("Connection failed: " . $conn->connect_error);
                }

                $sql = "SELECT courseid, coursename FROM courses";
                $result = $conn->query($sql);
                while ($row = $result->fetch_assoc()) {
                    echo "<option value='" . $row['courseid'] . "'>" . htmlspecialchars($row['coursename']) . "</option>";
                }
                $conn->close();
                ?>
            </select>
        </div>

        <div class="form-group">
            <label for="background">Your Background:</label>
            <input type="text" name="background" id="background" required>
        </div>

        <div class="form-group">
            <label for="duration">Participation Duration (weeks):</label>
            <input type="number" name="duration" id="duration" required>
        </div>

        <input type="submit" value="Submit Registration" class="btn">
    </form>
</div>

</body>
</html>
