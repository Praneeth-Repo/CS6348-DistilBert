<?php
session_start();

// Database connection
require_once "config.php";

// Get raw inputs (unsanitized - intentionally vulnerable)
$userid = isset($_POST['userid']) ? $_POST['userid'] : '';
$password = isset($_POST['password']) ? $_POST['password'] : '';

/**
 * ML SQL Injection Detection
 * Uses DistilBERT model to classify input as malicious (1) or safe (0)
 */
function isMalicious($input) {
    // Skip empty inputs to avoid unnecessary checks
    if (empty(trim($input))) {
        return false;
    }
    
    // Prepare the Python command
    $cmd = "python predict_sqli.py " . escapeshellarg($input) . " 2>&1";
    $output = shell_exec($cmd);
    
    // Error handling if Python script fails
    if ($output === null) {
        error_log("SQLi detection failed for input: " . substr($input, 0, 100));
        return false; // Fail open rather than blocking all traffic
    }
    
    return intval(trim($output)) === 1;
}

// Block if malicious input detected by ML model
if (isMalicious($userid) || isMalicious($password)) {
    $_SESSION['error'] = "⚠️ Malicious input detected. Access denied.";
    header("Location: login.php");
    exit;
}

//  VULNERABLE SQL QUERY (intentionally left unprotected)
$query = "SELECT * FROM user WHERE userid = '$userid' AND password = '$password'";
$result = $conn->query($query);


// Check login result
if ($result && $result->num_rows >= 1) {
    $user = $result->fetch_assoc();

    if ($user['user_status'] !== 'active') {
        $_SESSION['error'] = "Account is " . $user['user_status'];
        header("Location: login.php");
        exit;
    }

    $_SESSION['userid'] = $user['userid'];
    $_SESSION['user_type'] = $user['user_type'];
    $_SESSION['session_id'] = session_id();

    // Logging session (also intentionally vulnerable)
    $log_query = "INSERT INTO userlog (userid, session_id) VALUES ('{$user['userid']}', '{$_SESSION['session_id']}')";
    $conn->query($log_query);  


    // Redirect based on user type
    if ($user['user_type'] === 'admin') {
        header("Location: admin_dashboard.php");
    } else {
        header("Location: course_management.php");
    }
    exit;
} else {
    $_SESSION['error'] = "Invalid credentials.";
    header("Location: login.php");
    exit;
}
?>