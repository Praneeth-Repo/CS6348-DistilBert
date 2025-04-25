<?php
// Check if shell_exec is available
if (function_exists('shell_exec')) {
    echo "<p style='color:green'>shell_exec() is enabled.</p>";
    
    // Try to run a simple command
    $output = shell_exec('echo "Hello from shell"');
    if ($output) {
        echo "<p style='color:green'>shell_exec() is working! Output: " . htmlspecialchars($output) . "</p>";
    } else {
        echo "<p style='color:red'>shell_exec() is enabled but not working properly.</p>";
    }
} else {
    echo "<p style='color:red'>shell_exec() is disabled in this PHP installation.</p>";
}

// Check for disabled functions
$disabled = ini_get('disable_functions');
if ($disabled) {
    $disabled_array = explode(',', $disabled);
    if (in_array('shell_exec', $disabled_array)) {
        echo "<p style='color:red'>shell_exec() is specifically disabled in php.ini</p>";
    }
    echo "<p>Disabled functions: " . htmlspecialchars($disabled) . "</p>";
}

// Display PHP version
echo "<p>PHP Version: " . phpversion() . "</p>";
?>