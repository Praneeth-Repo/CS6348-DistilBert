<?php
session_start();
require_once "config.php";

// Admin check
if (!isset($_SESSION['userid']) || $_SESSION['user_type'] !== 'admin') {
    header("Location: login.php");
    exit;
}

// Handle Add / Update / Delete
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $userid = $_POST['userid'];
    $user_type = $_POST['user_type'];
    $user_status = $_POST['user_status'];
    $first = $_POST['first_name'];
    $last = $_POST['last_name'];
    $email = $_POST['email'];
    $password = !empty($_POST['password']) ? $_POST['password'] : null;

    try {
        if (isset($_POST['add'])) {
            if (!$password) throw new Exception("Password required for new user.");

            $check = $conn->prepare("SELECT COUNT(*) FROM user WHERE userid = ?");
            $check->bind_param("s", $userid);
            $check->execute();
            $check->bind_result($exists);
            $check->fetch();
            $check->close();

            if ($exists > 0) throw new Exception("User ID '$userid' already exists.");

            $stmt = $conn->prepare("INSERT INTO user (userid, password, user_type, user_status, first_name, last_name, email)
                                    VALUES (?, ?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("sssssss", $userid, $password, $user_type, $user_status, $first, $last, $email);
            if (!$stmt->execute()) throw new Exception("Failed to add user.");
            $_SESSION['success'] = "User '$userid' added.";
        }

        if (isset($_POST['update'])) {
            if ($password) {
                $stmt = $conn->prepare("UPDATE user SET password=?, user_type=?, user_status=?, first_name=?, last_name=?, email=? WHERE userid=?");
                $stmt->bind_param("sssssss", $password, $user_type, $user_status, $first, $last, $email, $userid);
            } else {
                $stmt = $conn->prepare("UPDATE user SET user_type=?, user_status=?, first_name=?, last_name=?, email=? WHERE userid=?");
                $stmt->bind_param("ssssss", $user_type, $user_status, $first, $last, $email, $userid);
            }
            if (!$stmt->execute()) throw new Exception("Failed to update user.");
            $_SESSION['success'] = "User '$userid' updated.";
        }

        if (isset($_POST['delete'])) {
            $stmt = $conn->prepare("DELETE FROM user WHERE userid=?");
            $stmt->bind_param("s", $userid);
            if (!$stmt->execute()) throw new Exception("Failed to delete user.");
            $_SESSION['success'] = "User '$userid' deleted.";
        }
    } catch (Exception $e) {
        $_SESSION['error'] = $e->getMessage();
    }

    header("Location: manage_users.php");
    exit;
}

// Get users
$users = $conn->query("SELECT * FROM user ORDER BY user_type DESC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>Manage Users</title>
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="css/styles.css" />
</head>
<body>
    <?php include 'sidebar.php'; ?>

    <div class="main">
        <div class="header">
            <h1>Manage Users</h1>
            <div class="logout"><a href="logout.php">Logout</a></div>
        </div>

        <?php if (isset($_SESSION['success'])): ?>
            <div class="message success"><?php echo $_SESSION['success']; unset($_SESSION['success']); ?></div>
        <?php endif; ?>
        <?php if (isset($_SESSION['error'])): ?>
            <div class="message error"><?php echo $_SESSION['error']; unset($_SESSION['error']); ?></div>
        <?php endif; ?>

        <form method="post" class="user-form" autocomplete="off">
            <div class="form-grid">
                <div>
                    <label for="userid">User ID</label>
                    <input type="text" name="userid" id="userid" required />
                </div>
                <div>
                    <label for="password">Password <small>(leave blank to keep existing)</small></label>
                    <input type="password" name="password" id="password" />
                </div>
                <div>
                    <label for="first_name">First Name</label>
                    <input type="text" name="first_name" id="first_name" />
                </div>
                <div>
                    <label for="last_name">Last Name</label>
                    <input type="text" name="last_name" id="last_name" />
                </div>
                <div>
                    <label for="email">Email</label>
                    <input type="email" name="email" id="email" />
                </div>
                <div>
                    <label for="user_type">User Type</label>
                    <select name="user_type" id="user_type" required>
                        <option value="user">User</option>
                        <option value="admin">Admin</option>
                    </select>
                </div>
                <div>
                    <label for="user_status">User Status</label>
                    <select name="user_status" id="user_status" required>
                        <option value="active">Active</option>
                        <option value="inactive">Inactive</option>
                        <option value="revoked">Revoked</option>
                        <option value="deleted">Deleted</option>
                    </select>
                </div>
            </div>

            <div class="form-buttons">
                <button type="submit" name="add">Add User</button>
                <button type="submit" name="update">Update User</button>
                <button type="submit" name="delete">Delete User</button>
            </div>
        </form>

        <h2>Current Users</h2>
        <div class="table-wrapper">
            <table>
                <thead>
                    <tr>
                        <th>User ID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Type</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($u = $users->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($u['userid']); ?></td>
                            <td><?php echo htmlspecialchars($u['first_name'] . ' ' . $u['last_name']); ?></td>
                            <td><?php echo htmlspecialchars($u['email']); ?></td>
                            <td><?php echo htmlspecialchars($u['user_type']); ?></td>
                            <td><?php echo htmlspecialchars($u['user_status']); ?></td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
