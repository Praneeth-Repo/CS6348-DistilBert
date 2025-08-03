<?php
session_start();
require_once "config.php";

if (!isset($_SESSION['userid']) || $_SESSION['user_type'] !== 'admin') {
    header("Location: login.php");
    exit;
}

$total_users = $conn->query("SELECT COUNT(*) as count FROM user")->fetch_assoc()['count'];
$active_users = $conn->query("SELECT COUNT(*) as count FROM user WHERE user_status = 'active'")->fetch_assoc()['count'];
$total_courses = $conn->query("SELECT COUNT(*) as count FROM course1")->fetch_assoc()['count'];

$log_query = $conn->query("SELECT userid, login_time FROM userlog ORDER BY login_time DESC LIMIT 5");
$logs = $log_query->fetch_all(MYSQLI_ASSOC);
?>
<meta name="viewport" content="width=device-width, initial-scale=1" />

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>Admin Dashboard</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="css/styles.css" />
</head>
<body>
    <?php include 'sidebar.php'; ?>

    <div class="main">
        <div class="header">
            <h1>Welcome, Admin: <?php echo htmlspecialchars($_SESSION['userid']); ?></h1>
            <div class="logout"><a href="logout.php">Logout</a></div>
        </div>

        <div class="stats" role="region" aria-label="Key statistics">
            <div class="card" role="region" aria-labelledby="users-stat">
                <p id="users-stat">Total Users</p>
                <h2><?php echo $total_users; ?></h2>
            </div>
            <div class="card" role="region" aria-labelledby="active-users-stat">
                <p id="active-users-stat">Active Users</p>
                <h2><?php echo $active_users; ?></h2>
            </div>
            <div class="card" role="region" aria-labelledby="courses-stat">
                <p id="courses-stat">Total Courses</p>
                <h2><?php echo $total_courses; ?></h2>
            </div>
        </div>

        <div class="activity" role="region" aria-label="Recent login activity">
            <h3>Recent Login Activity</h3>
            <?php if (count($logs) > 0): ?>
                <?php foreach ($logs as $log): ?>
                    <div class="log-entry">
                        <span><?php echo htmlspecialchars($log['userid']); ?></span>
                        <span><?php echo htmlspecialchars($log['login_time']); ?></span>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p>No recent logins found.</p>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>
