<?php
// Connection details
$host = "localhost";
$user = "ishimwe"; 
$pass = "222005870"; 
$database = "online_debt_managment_course_platform";

// Creating connection
$connection = new mysqli($host, $user, $pass, $database);

// Check connection
if ($connection->connect_error) {
    die("Connection failed: " . $connection->connect_error);
}

// Check if course_id is set
if (isset($_REQUEST['course_id'])) {
    $course_id = $_REQUEST['course_id'];

    // Use prepared statement
    $stmt = $connection->prepare("SELECT * FROM courses WHERE course_id = ?");
    $stmt->bind_param("i", $course_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $course_name = htmlspecialchars($row['course_name'], ENT_QUOTES);
        $instructor_id = htmlspecialchars($row['instructor_id'], ENT_QUOTES);
        $description = htmlspecialchars($row['description'], ENT_QUOTES);
        $start_date = htmlspecialchars($row['start_date'], ENT_QUOTES);
        $end_date = htmlspecialchars($row['end_date'], ENT_QUOTES);
        $price = htmlspecialchars($row['price'], ENT_QUOTES);
        $status = htmlspecialchars($row['status'], ENT_QUOTES);
    } else {
        echo "Page not found.";
        exit();
    }

    // Close statement
    $stmt->close();
}

?>

<!DOCTYPE html>
<html>
<head>
    <title>Update Course</title>
 <!-- JavaScript validation and content load for update or modify data-->
    <script>
        function confirmUpdate() {
            return confirm('Are you sure you want to update this record?');
        }
    </script>
</head>
<body><center>
    <!-- Update courses form -->
    <h2><u>Update Form of Courses</u></h2>
    <form method="POST" onsubmit="return confirmUpdate();">
        <label for="course_name">Course Name:</label>
        <input type="text" name="course_name" value="<?php echo isset($course_name) ? $course_name : ''; ?>" required>
        <br><br>

        <label for="instructor_id">Instructor ID:</label>
        <input type="text" name="instructor_id" value="<?php echo isset($instructor_id) ? $instructor_id : ''; ?>" required>
        <br><br>

        <label for="description">description:</label>
        <input type="text" name="description" value="<?php echo isset($description) ? $description : ''; ?>" required>
        <br><br>

        <label for="start_date">Start Date:</label>
        <input type="date" name="start_date" value="<?php echo isset($start_date) ? $start_date : ''; ?>" required>
        <br><br>

        <label for="end_date">End Date:</label>
        <input type="date" name="end_date" value="<?php echo isset($end_date) ? $end_date : ''; ?>" required>
        <br><br>

        <label for="price">Price:</label>
        <input type="text" name="price" value="<?php echo isset($price) ? $price : ''; ?>" required>
        <br><br>

        <label for="status">Status:</label>
        <input type="text" name="status" value="<?php echo isset($status) ? $status : ''; ?>" required>
        <br><br>

        <input type="submit" name="up" value="Update">
    </form>

</body>
</html>

<?php
// Handle form submission
if (isset($_POST['up'])) {
    // Retrieve updated values from the form
    $course_name = htmlspecialchars($_POST['course_name'], ENT_QUOTES);
    $instructor_id = htmlspecialchars($_POST['instructor_id'], ENT_QUOTES);
    $description = htmlspecialchars($_POST['description'], ENT_QUOTES);
    $start_date = htmlspecialchars($_POST['start_date'], ENT_QUOTES);
    $end_date = htmlspecialchars($_POST['end_date'], ENT_QUOTES);
    $price = htmlspecialchars($_POST['price'], ENT_QUOTES);
    $status = htmlspecialchars($_POST['status'], ENT_QUOTES);

    // Use prepared statement for update
    $stmt = $connection->prepare("UPDATE courses SET course_name = ?, instructor_id = ?, description = ?, start_date = ?, end_date = ?, price = ?, status = ? WHERE course_id = ?");
    $stmt->bind_param("sssssssi", $course_name, $instructor_id, $description, $start_date, $end_date, $price, $status, $course_id);

    if ($stmt->execute()) {
        // Redirect to course.php on successful update
        header('Location: courses.php');
        exit(); // Ensure that no other content is sent after the header redirection
    } else {
        // Handle error (e.g., display an error message)
        echo "Failed to update. Please try again.";
    }

    // Close statement
    $stmt->close();
}

// Close connection
$connection->close();
?> 
