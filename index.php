<!DOCTYPE html>
<html>
<head><title>My Project</title></head>
<body>
<h2>Available Files</h2>
<ul>
<?php
foreach (scandir('.') as $file) {
    if ($file !== '.' && $file !== '..') {
        echo "<li><a href='$file'>$file</a></li>";
    }
}
?>
</ul>
</body>
</html>