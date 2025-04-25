<?php
session_start();
$mysqli = new mysqli("localhost", "root", "", "cs6314");

if (isset($_SESSION['userid'], $_SESSION['session_id'])) {
    $stmt = $mysqli->prepare("UPDATE userlog SET logout_time = NOW() WHERE userid = ? AND session_id = ? ORDER BY id DESC LIMIT 1");
    $stmt->bind_param("ss", $_SESSION['userid'], $_SESSION['session_id']);
    $stmt->execute();
}

$_SESSION = [];
session_destroy();
header("Location: login.php");
exit;
?>
