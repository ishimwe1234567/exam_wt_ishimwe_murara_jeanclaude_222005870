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

// Check if enrollment_id is set
if (isset($_REQUEST['enrollment_id'])) {
    $enrollment_id = $_REQUEST['enrollment_id'];

    // Use prepared statement
    $stmt = $connection->prepare("SELECT * FROM enrollments WHERE enrollment_id = ?");
    $stmt->bind_param("i", $enrollment_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $user_id = htmlspecialchars($row['user_id'], ENT_QUOTES);
        $course_id = htmlspecialchars($row['course_id'], ENT_QUOTES);
        $enrollment_date = htmlspecialchars($row['enrollment_date'], ENT_QUOTES);
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
    <title>Update Enrollment</title>
 <!-- JavaScript validation and content load for update or modify data-->
    <script>
        function confirmUpdate() {
            return confirm('Are you sure you want to update this record?');
        }
    </script>
</head>
<body><center>
    <!-- Update enrollments form -->
    <h2><u>Update Form of Enrollments</u></h2>
    <form method="POST" onsubmit="return confirmUpdate();">
        <input type="hidden" name="enrollment_id" value="<?php echo isset($enrollment_id) ? $enrollment_id : ''; ?>">
        
        <label for="user_id">User ID:</label>
        <input type="text" name="user_id" value="<?php echo isset($user_id) ? $user_id : ''; ?>" required>
        <br><br>

        <label for="course_id">Course ID:</label>
        <input type="text" name="course_id" value="<?php echo isset($course_id) ? $course_id : ''; ?>" required>
        <br><br>

        <label for="enrollment_date">Enrollment Date:</label>
        <input type="text" name="enrollment_date" value="<?php echo isset($enrollment_date) ? $enrollment_date : ''; ?>" required>
        <br><br>

        <input type="submit" name="up" value="Update">
    </form>

</body>
</html>

<?php
// Handle form submission
if (isset($_POST['up'])) {
    // Retrieve updated values from the form
    $user_id = htmlspecialchars($_POST['user_id'], ENT_QUOTES);
    $course_id = htmlspecialchars($_POST['course_id'], ENT_QUOTES);
    $enrollment_date = htmlspecialchars($_POST['enrollment_date'], ENT_QUOTES);
    $enrollment_id = htmlspecialchars($_POST['enrollment_id'], ENT_QUOTES); // Retrieve enrollment_id from the form

    // Use prepared statement for update
    $stmt = $connection->prepare("UPDATE enrollments SET user_id = ?, course_id = ?, enrollment_date = ? WHERE enrollment_id = ?");
    $stmt->bind_param("iisi", $user_id, $course_id, $enrollment_date, $enrollment_id);

    if ($stmt->execute()) {
        // Redirect to enrollments.php on successful update
        header('Location: enrollments.php');
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
