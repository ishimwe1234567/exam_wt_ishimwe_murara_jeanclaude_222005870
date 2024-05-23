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

// Check if resource_id is set
if (isset($_REQUEST['resource_id'])) {
    $resource_id = $_REQUEST['resource_id'];

    // Use prepared statement
    $stmt = $connection->prepare("SELECT * FROM debtmanagementresources WHERE resource_id = ?");
    $stmt->bind_param("i", $resource_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $resource_type = htmlspecialchars($row['resource_type'], ENT_QUOTES);
        $resource_title = htmlspecialchars($row['resource_title'], ENT_QUOTES);
        $resource_description = htmlspecialchars($row['resource_description'], ENT_QUOTES);
        $resource_url = htmlspecialchars($row['resource_url'], ENT_QUOTES);
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
    <title>Update Resource</title>
    <!-- JavaScript validation and content load for update or modify data-->
    <script>
        function confirmUpdate() {
            return confirm('Are you sure you want to update this record?');
        }
    </script>
</head>
<body>
    <center>
        <!-- Update resources form -->
        <h2><u>Update Form of Resources</u></h2>
        <form method="POST" onsubmit="return confirmUpdate();">
            <input type="hidden" name="resource_id" value="<?php echo isset($resource_id) ? $resource_id : ''; ?>">
            
            <label for="resource_type">Resource Type:</label>
            <input type="text" name="resource_type" value="<?php echo isset($resource_type) ? $resource_type : ''; ?>" required>
            <br><br>

            <label for="resource_title">Resource Title:</label>
            <input type="text" name="resource_title" value="<?php echo isset($resource_title) ? $resource_title : ''; ?>" required>
            <br><br>

            <label for="resource_description">Resource Description:</label>
            <input type="text" name="resource_description" value="<?php echo isset($resource_description) ? $resource_description : ''; ?>" required>
            <br><br>

            <label for="resource_url">Resource URL:</label>
            <input type="text" name="resource_url" value="<?php echo isset($resource_url) ? $resource_url : ''; ?>" required>
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
    $resource_type = htmlspecialchars($_POST['resource_type'], ENT_QUOTES);
    $resource_title = htmlspecialchars($_POST['resource_title'], ENT_QUOTES);
    $resource_description = htmlspecialchars($_POST['resource_description'], ENT_QUOTES);
    $resource_url = htmlspecialchars($_POST['resource_url'], ENT_QUOTES);

    // Use prepared statement for update
    $stmt = $connection->prepare("UPDATE debtmanagementresources SET resource_type = ?, resource_title = ?, resource_description = ?, resource_url = ? WHERE resource_id = ?");
    $stmt->bind_param("ssssi", $resource_type, $resource_title, $resource_description, $resource_url, $resource_id);

    if ($stmt->execute()) {
        // Redirect to debtmanagementresources.php on successful update
        header('Location: debtmanagementresources.php');
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
