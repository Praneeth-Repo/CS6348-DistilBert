<?php
session_start();
if (!isset($_SESSION['userid']) || $_SESSION['user_type'] !== 'admin') {
    header("Location: login.php");
    exit;
}
require_once "config.php";

$result = $conn->query("SELECT * FROM userlog ORDER BY login_time DESC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>User Logs</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="css/styles.css" />
    <style>
        /* Additional styles for search input */
        #searchInput {
            width: 100%;
            max-width: 400px;
            padding: 0.5rem 0.75rem;
            margin-bottom: 1.5rem;
            border-radius: 8px;
            border: 1px solid #ccc;
            font-size: 1rem;
            transition: border-color 0.2s ease;
        }
        #searchInput:focus {
            outline: none;
            border-color: #4c7ef3;
            background-color: #fff;
        }
    </style>
</head>
<body>
    <?php include 'sidebar.php'; ?>

    <main>
        <header>
            <h1>User Login/Logout Logs</h1>
            <div class="logout"><a href="logout.php">Logout</a></div>
        </header>

        <input
            type="text"
            id="searchInput"
            placeholder="Search logs..."
            aria-label="Search logs"
        />

        <?php if ($result && $result->num_rows > 0): ?>
            <table id="logsTable">
                <thead>
                    <tr>
                        <th>User ID</th>
                        <th>Login Time</th>
                        <th>Logout Time</th>
                        <th>Session ID</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($row['userid']); ?></td>
                            <td><?php echo htmlspecialchars($row['login_time']); ?></td>
                            <td><?php echo htmlspecialchars($row['logout_time'] ?? '---'); ?></td>
                            <td><?php echo htmlspecialchars($row['session_id']); ?></td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>No logs found.</p>
        <?php endif; ?>

        <br />
        <a href="admin_dashboard.php" style="color:#4c7ef3; font-weight:600;">Back to Dashboard</a>
    </main>

    <script>
        const searchInput = document.getElementById('searchInput');
        const table = document.getElementById('logsTable');
        const rows = table ? table.tBodies[0].rows : [];

        searchInput.addEventListener('input', function() {
            const filter = this.value.toLowerCase();

            for (let row of rows) {
                const text = row.textContent.toLowerCase();
                row.style.display = text.includes(filter) ? '' : 'none';
            }
        });
    </script>
</body>
</html>
