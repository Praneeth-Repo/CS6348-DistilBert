<?php
session_start();
if ($_SESSION['user_type'] !== 'admin') {
    header("Location: login.php");
    exit;
}
$mysqli = new mysqli("localhost", "root", "", "cs6314");
$result = $mysqli->query("SELECT * FROM userlog ORDER BY login_time DESC");
?>

<!DOCTYPE html>
<html>
<head>
    <title>User Logs</title>
    <style>
        table, th, td { border: 1px solid black; padding: 5px; border-collapse: collapse; }
    </style>
</head>
<body>
    <h2>User Login/Logout Logs</h2>
    <table>
        <tr><th>UserID</th><th>Login Time</th><th>Logout Time</th><th>Session ID</th></tr>
        <?php while($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?php echo $row['userid']; ?></td>
                <td><?php echo $row['login_time']; ?></td>
                <td><?php echo $row['logout_time'] ?? '---'; ?></td>
                <td><?php echo $row['session_id']; ?></td>
            </tr>
        <?php endwhile; ?>
    </table>
    <br><a href="admin_dashboard.php">Back to Dashboard</a>
</body>
</html>
