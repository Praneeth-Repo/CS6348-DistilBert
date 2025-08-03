<?php
session_start();
if (!isset($_SESSION['userid']) || $_SESSION['user_type'] !== 'user') {
    header("Location: login.php");
    exit;
}

require_once "config.php";

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

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    try {
        if (isset($_POST['add'])) {
            $course_id = !empty($_POST['course_id']) ? $conn->real_escape_string($_POST['course_id']) : generateCourseID($conn);
            $class_title = $conn->real_escape_string($_POST['class_title']);
            $instructors = $conn->real_escape_string($_POST['instructors']);
            $class_section = $conn->real_escape_string($_POST['class_section']);
            $classroom_location = $conn->real_escape_string($_POST['classroom_location']);
            $date_time = $conn->real_escape_string($_POST['date_time']);

            if (empty($class_title)) {
                throw new Exception("Class Title is required.");
            }

            $sql = "INSERT INTO course1 (course_id, class_title, instructors, class_section, classroom_location, date_time)
                    VALUES (?, ?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ssssss", $course_id, $class_title, $instructors, $class_section, $classroom_location, $date_time);
            if (!$stmt->execute()) throw new Exception("Failed to add course: " . $stmt->error);
            $_SESSION['success'] = "Course '$course_id' added successfully.";
            $stmt->close();
        }

        if (isset($_POST['update'])) {
            $course_id = $conn->real_escape_string($_POST['course_id']);
            if (empty($course_id)) throw new Exception("Course ID is required for update.");

            $class_title = $conn->real_escape_string($_POST['class_title']);
            $instructors = $conn->real_escape_string($_POST['instructors']);
            $class_section = $conn->real_escape_string($_POST['class_section']);
            $classroom_location = $conn->real_escape_string($_POST['classroom_location']);
            $date_time = $conn->real_escape_string($_POST['date_time']);

            $sql = "UPDATE course1 SET class_title=?, instructors=?, class_section=?, classroom_location=?, date_time=? WHERE course_id=?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ssssss", $class_title, $instructors, $class_section, $classroom_location, $date_time, $course_id);
            if (!$stmt->execute()) throw new Exception("Failed to update course: " . $stmt->error);
            $_SESSION['success'] = "Course '$course_id' updated successfully.";
            $stmt->close();
        }

        if (isset($_POST['delete'])) {
            $course_id = $conn->real_escape_string($_POST['course_id']);
            if (empty($course_id)) throw new Exception("Course ID is required for delete.");

            $stmt = $conn->prepare("DELETE FROM course1 WHERE course_id=?");
            $stmt->bind_param("s", $course_id);
            if (!$stmt->execute()) throw new Exception("Failed to delete course: " . $stmt->error);
            $_SESSION['success'] = "Course '$course_id' deleted successfully.";
            $stmt->close();
        }
    } catch (Exception $e) {
        $_SESSION['error'] = $e->getMessage();
    }

    header("Location: " . $_SERVER['PHP_SELF']);
    exit;
}

$result = $conn->query("SELECT * FROM course1 ORDER BY course_id ASC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<title>Course Management</title>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet" />
<link rel="stylesheet" href="css/styles.css" />
<style>



  /* Responsive for mobile */
  @media (max-width: 720px) {
    aside.user-sidebar {
      width: 100%;
      height: auto;
      position: relative;
      padding: 1rem;
      display: flex;
      justify-content: space-around;
    }
    aside.user-sidebar a.nav-link {
      margin-bottom: 0;
      padding: 0.5rem 1rem;
    }
    .main {
      margin-left: 0;
    }
  }
</style>
</head>
<body>



<div class="main" role="main">
    <div class="header">
        <h1>Course Management</h1>
        <div class="logout"><a href="logout.php">Logout</a></div>
    </div>

    <?php if (!empty($_SESSION['success'])): ?>
        <div class="message success" role="alert"><?php echo $_SESSION['success']; unset($_SESSION['success']); ?></div>
    <?php endif; ?>
    <?php if (!empty($_SESSION['error'])): ?>
        <div class="message error" role="alert"><?php echo $_SESSION['error']; unset($_SESSION['error']); ?></div>
    <?php endif; ?>

    <h2>Current Courses</h2>
    <div class="table-wrapper" style="margin-bottom: 2rem;">
        <table>
            <thead>
                <tr>
                    <th>Course ID</th>
                    <th>Class Title</th>
                    <th>Instructor(s)</th>
                    <th>Class Section</th>
                    <th>Location</th>
                    <th>Date &amp; Time</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($result && $result->num_rows > 0): ?>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($row['course_id']); ?></td>
                            <td><?php echo htmlspecialchars($row['class_title'] ?: 'N/A'); ?></td>
                            <td><?php echo htmlspecialchars($row['instructors'] ?: 'N/A'); ?></td>
                            <td><?php echo htmlspecialchars($row['class_section'] ?: 'N/A'); ?></td>
                            <td><?php echo htmlspecialchars($row['classroom_location'] ?: 'N/A'); ?></td>
                            <td><?php echo htmlspecialchars($row['date_time'] ?: 'N/A'); ?></td>
                            <td>
                                <form method="post" onsubmit="return confirm('Delete this course?');" style="display:inline;">
                                    <input type="hidden" name="course_id" value="<?php echo htmlspecialchars($row['course_id']); ?>">
                                    <button type="submit" name="delete" class="btn-delete">Delete</button>
                                </form>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr><td colspan="7" style="text-align:center;">No courses found.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <h2>Add Course</h2>
    <form method="post" class="user-form" autocomplete="off" novalidate>
        <div class="form-grid">
            <div>
                <label for="course_id_add">Course ID (optional)</label>
                <input type="text" name="course_id" id="course_id_add" placeholder="Leave blank for auto-generated ID" />
            </div>
            <div>
                <label for="class_title_add">Class Title *</label>
                <input type="text" name="class_title" id="class_title_add" required />
            </div>
            <div>
                <label for="instructors_add">Instructor(s)</label>
                <input type="text" name="instructors" id="instructors_add" />
            </div>
            <div>
                <label for="class_section_add">Class Section</label>
                <input type="text" name="class_section" id="class_section_add" />
            </div>
            <div>
                <label for="location_add">Location</label>
                <input type="text" name="classroom_location" id="location_add" />
            </div>
            <div>
                <label for="date_time_add">Date &amp; Time</label>
                <input type="text" name="date_time" id="date_time_add" placeholder="e.g. Mon 10:00AM" />
            </div>
        </div>
        <div class="form-buttons">
            <button type="submit" name="add">Add Course</button>
        </div>
    </form>

    <h2>Update Course</h2>
    <form method="post" class="user-form" autocomplete="off" novalidate>
        <div class="form-grid">
            <div>
                <label for="course_id_update">Course ID *</label>
                <input type="text" name="course_id" id="course_id_update" required />
            </div>
            <div>
                <label for="class_title_update">Class Title</label>
                <input type="text" name="class_title" id="class_title_update" />
            </div>
            <div>
                <label for="instructors_update">Instructor(s)</label>
                <input type="text" name="instructors" id="instructors_update" />
            </div>
            <div>
                <label for="class_section_update">Class Section</label>
                <input type="text" name="class_section" id="class_section_update" />
            </div>
            <div>
                <label for="location_update">Location</label>
                <input type="text" name="classroom_location" id="location_update" />
            </div>
            <div>
                <label for="date_time_update">Date &amp; Time</label>
                <input type="text" name="date_time" id="date_time_update" placeholder="e.g. Mon 10:00AM" />
            </div>
        </div>
        <div class="form-buttons">
            <button type="submit" name="update">Update Course</button>
        </div>
    </form>
</div>

</body>
</html>
