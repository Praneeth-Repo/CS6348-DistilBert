<?php
session_start();
if (!isset($_SESSION['userid']) || $_SESSION['user_type'] !== 'admin') {
    header("Location: login.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Dashboard</title>
</head>
<body>
    <h2>Welcome, Admin: <?php echo $_SESSION['userid']; ?></h2>
    <ul>
        <li><a href="manage_users.php">Manage Users</a></li>
        <li><a href="view_logs.php">View User Logs</a></li>
        <li><a href="logout.php">Logout</a></li>
    </ul>
</body>
</html>
