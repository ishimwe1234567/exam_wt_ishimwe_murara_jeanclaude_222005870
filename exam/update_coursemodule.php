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

// Check if module_id is set
if (isset($_REQUEST['module_id'])) {
    $module_id = $_REQUEST['module_id'];

    // Use prepared statement
    $stmt = $connection->prepare("SELECT * FROM coursemodules WHERE module_id = ?");
    $stmt->bind_param("i", $module_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $course_id = htmlspecialchars($row['course_id'], ENT_QUOTES);
        $module_name = htmlspecialchars($row['module_name'], ENT_QUOTES);
        $module_description = htmlspecialchars($row['module_description'], ENT_QUOTES);
        $module_order = htmlspecialchars($row['module_order'], ENT_QUOTES);
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
    <title>Update Module</title>
    <!-- JavaScript validation and content load for update or modify data-->
    <script>
        function confirmUpdate() {
            return confirm('Are you sure you want to update this record?');
        }
    </script>
</head>
<body>
    <center>
        <!-- Update modules form -->
        <h2><u>Update Form of Modules</u></h2>
        <form method="POST" onsubmit="return confirmUpdate();">
            <input type="hidden" name="module_id" value="<?php echo isset($module_id) ? $module_id : ''; ?>">
            
            <label for="course_id">Course ID:</label>
            <input type="text" name="course_id" value="<?php echo isset($course_id) ? $course_id : ''; ?>" required>
            <br><br>

            <label for="module_name">Module Name:</label>
            <input type="text" name="module_name" value="<?php echo isset($module_name) ? $module_name : ''; ?>" required>
            <br><br>

            <label for="module_description">Module Description:</label>
            <input type="text" name="module_description" value="<?php echo isset($module_description) ? $module_description : ''; ?>" required>
            <br><br>

            <label for="module_order">Module Order:</label>
            <input type="text" name="module_order" value="<?php echo isset($module_order) ? $module_order : ''; ?>" required>
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
    $course_id = htmlspecialchars($_POST['course_id'], ENT_QUOTES);
    $module_name = htmlspecialchars($_POST['module_name'], ENT_QUOTES);
    $module_description = htmlspecialchars($_POST['module_description'], ENT_QUOTES);
    $module_order = htmlspecialchars($_POST['module_order'], ENT_QUOTES);

    // Use prepared statement for update
    $stmt = $connection->prepare("UPDATE coursemodules SET course_id = ?, module_name = ?, module_description = ?, module_order = ? WHERE module_id = ?");
    $stmt->bind_param("isssi", $course_id, $module_name, $module_description, $module_order, $module_id);

    if ($stmt->execute()) {
        // Redirect to coursemodules.php on successful update
        header('Location: coursemodules.php');
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
