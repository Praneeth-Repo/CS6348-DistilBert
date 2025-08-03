<?php
$currentPage = basename($_SERVER['PHP_SELF']);
?>

<aside>
    <h2>Admin Panel</h2>
    <a href="admin_dashboard.php" class="nav-link <?= $currentPage == 'admin_dashboard.php' ? 'active' : '' ?>">Dashboard</a>
    <a href="manage_users.php" class="nav-link <?= $currentPage == 'manage_users.php' ? 'active' : '' ?>">Manage Users</a>
    <a href="view_logs.php" class="nav-link <?= $currentPage == 'view_logs.php' ? 'active' : '' ?>">View Logs</a>
    <a href="logout.php" class="nav-link">Logout</a>
</aside>
