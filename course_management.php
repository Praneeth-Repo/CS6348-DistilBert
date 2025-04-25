<?php
session_start();
if (!isset($_SESSION['userid']) || $_SESSION['user_type'] !== 'user') {
    header("Location: login.php");
    exit;
}   
// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "cs6314";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Function to generate a unique Course ID if not provided
function generateCourseID($conn) {
    $prefix = "CS";
    do {
        $random_number = rand(1000, 9999);
        $new_id = $prefix . $random_number;

        $check_sql = "SELECT COUNT(*) FROM course1 WHERE course_id = '$new_id'";
        $result = $conn->query($check_sql);
        $row = $result->fetch_array();
    } while ($row[0] > 0);

    return $new_id;
}

// Handle Add Course
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['add'])) {
        $course_id = isset($_POST['course_id']) && !empty($_POST['course_id']) ? 
                     $conn->real_escape_string($_POST['course_id']) : generateCourseID($conn);

        $class_title = $conn->real_escape_string($_POST['class_title']);
        $instructors = $conn->real_escape_string($_POST['instructors']);
        $class_section = $conn->real_escape_string($_POST['class_section']);
        $classroom_location = $conn->real_escape_string($_POST['classroom_location']);
        $date_time = $conn->real_escape_string($_POST['date_time']);

        $sql = "INSERT INTO course1 (course_id, class_title, instructors, class_section, classroom_location, date_time) 
                VALUES ('$course_id', '$class_title', '$instructors', '$class_section', '$classroom_location', '$date_time')";

        $conn->query($sql);
    }

    // Handle Delete Course
    if (isset($_POST['delete']) && isset($_POST['course_id'])) {
        $course_id = $conn->real_escape_string($_POST['course_id']);
        $sql = "DELETE FROM course1 WHERE course_id='$course_id'";
        $conn->query($sql);
    }

    // Handle Update Course
    if (isset($_POST['update'])) {
        $course_id = $conn->real_escape_string($_POST['course_id']);
        $class_title = isset($_POST['class_title']) ? $conn->real_escape_string($_POST['class_title']) : '';
        $instructors = isset($_POST['instructors']) ? $conn->real_escape_string($_POST['instructors']) : '';
        $class_section = isset($_POST['class_section']) ? $conn->real_escape_string($_POST['class_section']) : '';
        $classroom_location = isset($_POST['classroom_location']) ? $conn->real_escape_string($_POST['classroom_location']) : '';
        $date_time = isset($_POST['date_time']) ? $conn->real_escape_string($_POST['date_time']) : '';

        $sql = "UPDATE course1 
                SET class_title='$class_title', instructors='$instructors', class_section='$class_section', 
                    classroom_location='$classroom_location', date_time='$date_time' 
                WHERE course_id='$course_id'";

        $conn->query($sql);
    }

    // Redirect to refresh the page after a form submission
    header("Location: " . $_SERVER['PHP_SELF']);
    exit;
}

// Fetch all courses
$sql = "SELECT * FROM course1";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Course Management</title>
</head>
<body>
    <h1>Course Offerings</h1>
    <table border="1">
        <tr>
            <th>Course ID</th>
            <th>Class Title</th>
            <th>Instructor</th>
            <th>Class Section</th>
            <th>Location</th>
            <th>Date-Time</th>
            <th>Actions</th>
        </tr>
        <?php while ($row = $result->fetch_assoc()) { ?>
        <tr>
            <td><?php echo isset($row['course_id']) ? htmlspecialchars($row['course_id']) : ''; ?></td>
            <td><?php echo isset($row['class_title']) ? htmlspecialchars($row['class_title']) : 'N/A'; ?></td>
            <td><?php echo isset($row['instructors']) ? htmlspecialchars($row['instructors']) : 'N/A'; ?></td>
            <td><?php echo isset($row['class_section']) ? htmlspecialchars($row['class_section']) : 'None'; ?></td>
            <td><?php echo isset($row['classroom_location']) ? htmlspecialchars($row['classroom_location']) : 'N/A'; ?></td>
            <td><?php echo isset($row['date_time']) ? htmlspecialchars($row['date_time']) : 'N/A'; ?></td>

            <td>
                <form method="post" style="display:inline;">
                    <input type="hidden" name="course_id" value="<?php echo htmlspecialchars($row['course_id']); ?>">
                    <button type="submit" name="delete">Delete</button>
                </form>
            </td>
        </tr>
        <?php } ?>
    </table>

    <h2>Add Course</h2>
    <form method="post">
        <input type="text" name="course_id" placeholder="Course ID (Auto if left empty)">
        <input type="text" name="class_title" placeholder="Class Title" required>
        <input type="text" name="instructors" placeholder="Instructor">
        <input type="text" name="class_section" placeholder="Class Section">
        <input type="text" name="classroom_location" placeholder="Location">
        <input type="text" name="date_time" placeholder="Date-Time">
        <button type="submit" name="add">Add Course</button>
    </form>

    <h2>Update Course</h2>
    <form method="post">
        <input type="text" name="course_id" placeholder="Course ID" required>
        <input type="text" name="class_title" placeholder="Class Title">
        <input type="text" name="instructors" placeholder="Instructor">
        <input type="text" name="class_section" placeholder="Class Section">
        <input type="text" name="classroom_location" placeholder="Location">
        <input type="text" name="date_time" placeholder="Date-Time">
        <button type="submit" name="update">Update Course</button>
    </form>
</body>
<form action="logout.php" method="post">
    <button type="submit">Logout</button>
</form>


</html>
