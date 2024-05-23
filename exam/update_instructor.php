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

// Check if instructor_id is set
if (isset($_REQUEST['instructor_id'])) {
    $instructor_id = $_REQUEST['instructor_id'];

    // Use prepared statement
    $stmt = $connection->prepare("SELECT * FROM instructors WHERE instructor_id = ?");
    $stmt->bind_param("i", $instructor_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $user_id = htmlspecialchars($row['user_id'], ENT_QUOTES);
        $bio = htmlspecialchars($row['bio'], ENT_QUOTES);
        $expertise_area = htmlspecialchars($row['expertise_area'], ENT_QUOTES);
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
    <title>Update Instructor</title>
    <!-- JavaScript validation and content load for update or modify data-->
    <script>
        function confirmUpdate() {
            return confirm('Are you sure you want to update this record?');
        }
    </script>
</head>
<body>
    <center>
        <!-- Update instructors form -->
        <h2><u>Update Form of Instructors</u></h2>
        <form method="POST" onsubmit="return confirmUpdate();">
            <input type="hidden" name="instructor_id" value="<?php echo isset($instructor_id) ? $instructor_id : ''; ?>">
            
            <label for="user_id">User ID:</label>
            <input type="text" name="user_id" value="<?php echo isset($user_id) ? $user_id : ''; ?>" required>
            <br><br>

            <label for="bio">Bio:</label>
            <input type="text" name="bio" value="<?php echo isset($bio) ? $bio : ''; ?>" required>
            <br><br>

            <label for="expertise_area">Expertise Area:</label>
            <input type="text" name="expertise_area" value="<?php echo isset($expertise_area) ? $expertise_area : ''; ?>" required>
            <br><br>

            <input type="submit" name="up" value="Update">
        </form>
    </center>
</body>
</html>

<?php
// Handle form submission
if (isset($_POST['up'])) {
    // Retrieve updated values from the form
    $user_id = htmlspecialchars($_POST['user_id'], ENT_QUOTES);
    $bio = htmlspecialchars($_POST['bio'], ENT_QUOTES);
    $expertise_area = htmlspecialchars($_POST['expertise_area'], ENT_QUOTES);
    $instructor_id = htmlspecialchars($_POST['instructor_id'], ENT_QUOTES); // Retrieve instructor_id from the form

    // Use prepared statement for update
    $stmt = $connection->prepare("UPDATE instructors SET user_id = ?, bio = ?, expertise_area = ? WHERE instructor_id = ?");
    $stmt->bind_param("isii", $user_id, $bio, $expertise_area, $instructor_id);

    if ($stmt->execute()) {
        // Redirect to instructors.php on successful update
        header('Location: instructors.php');
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
