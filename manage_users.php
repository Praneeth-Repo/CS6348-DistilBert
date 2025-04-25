<?php
session_start();
$mysqli = new mysqli("localhost", "root", "", "cs6314");

// Admin access check
if (!isset($_SESSION['userid']) || $_SESSION['user_type'] !== 'admin') {
    header("Location: login.php");
    exit;
}

// Handle Add, Update, Delete
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $userid = $_POST['userid'];
    $user_type = $_POST['user_type'];
    $user_status = $_POST['user_status'];
    $first = $_POST['first_name'];
    $last = $_POST['last_name'];
    $email = $_POST['email'];

    // ❌ Store password as plain text for testing (insecure)
    $password = !empty($_POST['password']) ? $_POST['password'] : null;

    try {
        if (isset($_POST['add'])) {
            if (!$password) {
                throw new Exception("Password cannot be empty when adding a user.");
            }

            // Check if user already exists
            $check = $mysqli->prepare("SELECT COUNT(*) FROM user WHERE userid = ?");
            $check->bind_param("s", $userid);
            $check->execute();
            $check->bind_result($exists);
            $check->fetch();
            $check->close();

            if ($exists > 0) {
                throw new Exception("User ID '$userid' already exists.");
            }

            $stmt = $mysqli->prepare("INSERT INTO user (userid, password, user_type, user_status, first_name, last_name, email)
                                      VALUES (?, ?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("sssssss", $userid, $password, $user_type, $user_status, $first, $last, $email);

            if (!$stmt->execute()) {
                throw new Exception("Failed to add user: " . $stmt->error);
            }

            $_SESSION['success'] = "User '$userid' added successfully.";
        }

        if (isset($_POST['update'])) {
            if ($password) {
                $stmt = $mysqli->prepare("UPDATE user SET password=?, user_type=?, user_status=?, first_name=?, last_name=?, email=? WHERE userid=?");
                $stmt->bind_param("sssssss", $password, $user_type, $user_status, $first, $last, $email, $userid);
            } else {
                $stmt = $mysqli->prepare("UPDATE user SET user_type=?, user_status=?, first_name=?, last_name=?, email=? WHERE userid=?");
                $stmt->bind_param("ssssss", $user_type, $user_status, $first, $last, $email, $userid);
            }

            if (!$stmt->execute()) {
                throw new Exception("Failed to update user: " . $stmt->error);
            }

            $_SESSION['success'] = "User '$userid' updated successfully.";
        }

        if (isset($_POST['delete'])) {
            $stmt = $mysqli->prepare("DELETE FROM user WHERE userid=?");
            $stmt->bind_param("s", $userid);

            if (!$stmt->execute()) {
                throw new Exception("Failed to delete user: " . $stmt->error);
            }

            $_SESSION['success'] = "User '$userid' deleted successfully.";
        }
    } catch (Exception $e) {
        $_SESSION['error'] = $e->getMessage();
    }

    header("Location: manage_users.php");
    exit;
}

// Fetch all users
$users = $mysqli->query("SELECT * FROM user ORDER BY user_type DESC");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Manage Users</title>
    <style>
        table, th, td { border: 1px solid black; border-collapse: collapse; padding: 5px; }
        .success { color: green; }
        .error { color: red; }
    </style>
</head>
<body>
    <h2>Manage Users</h2>

    <!-- Show Success or Error Messages -->
    <?php if (isset($_SESSION['success'])): ?>
        <p class="success"><?php echo $_SESSION['success']; unset($_SESSION['success']); ?></p>
    <?php endif; ?>
    <?php if (isset($_SESSION['error'])): ?>
        <p class="error"><?php echo $_SESSION['error']; unset($_SESSION['error']); ?></p>
    <?php endif; ?>

    <!-- User Form -->
    <form method="post">
        <input name="userid" placeholder="User ID" required />
        <input name="password" placeholder="Password (leave blank to keep existing)" />
        <input name="first_name" placeholder="First Name" />
        <input name="last_name" placeholder="Last Name" />
        <input name="email" placeholder="Email" />
        <select name="user_type">
            <option value="user">User</option>
            <option value="admin">Admin</option>
        </select>
        <select name="user_status">
            <option value="active">Active</option>
            <option value="inactive">Inactive</option>
            <option value="revoked">Revoked</option>
            <option value="deleted">Deleted</option>
        </select>
        <button type="submit" name="add">Add</button>
        <button type="submit" name="update">Update</button>
        <button type="submit" name="delete">Delete</button>
    </form>

    <h3>Current Users</h3>
    <table>
        <tr>
            <th>User ID</th><th>Name</th><th>Email</th><th>Type</th><th>Status</th>
        </tr>
        <?php while ($u = $users->fetch_assoc()): ?>
            <tr>
                <td><?php echo htmlspecialchars($u['userid']); ?></td>
                <td><?php echo htmlspecialchars($u['first_name'] . ' ' . $u['last_name']); ?></td>
                <td><?php echo htmlspecialchars($u['email']); ?></td>
                <td><?php echo htmlspecialchars($u['user_type']); ?></td>
                <td><?php echo htmlspecialchars($u['user_status']); ?></td>
            </tr>
        <?php endwhile; ?>
    </table>

    <br><a href="admin_dashboard.php">Back to Dashboard</a>
</body>
</html>
