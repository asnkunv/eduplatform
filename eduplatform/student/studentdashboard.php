<?php
session_start();
if (!isset($_SESSION['userid'])) {
    header("Location: ../auth/login.php");
    exit();
}

$userid = $_SESSION['userid'];
?>

<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="../assets/style.css">
    <title>Student Dashboard</title>
</head>
<body>

<div class="container">
    <h2>Student Dashboard</h2>

    <p>Welcome! Your User ID is: <strong><?php echo htmlspecialchars($userid); ?></strong></p>

    <form method="post" action="mycourses.php" class="form-box">
        <label for="userid">Enter Your User ID:</label>
        <input type="text" name="userid" id="userid" value="<?php echo htmlspecialchars($userid); ?>" required>
        <input type="submit" value="View My Courses" class="btn">
        <a href="../auth/logout.php" class="btn logout">Logout</a>
    </form>
</div>

</body>
</html>
