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

// Check if quiz_id is set
if (isset($_REQUEST['quiz_id'])) {
    $quiz_id = $_REQUEST['quiz_id'];

    // Use prepared statement
    $stmt = $connection->prepare("SELECT * FROM quizzes WHERE quiz_id = ?");
    $stmt->bind_param("i", $quiz_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $module_id = htmlspecialchars($row['module_id'], ENT_QUOTES);
        $quiz_name = htmlspecialchars($row['quiz_name'], ENT_QUOTES);
        $quiz_description = htmlspecialchars($row['quiz_description'], ENT_QUOTES);
        $passing_score = htmlspecialchars($row['passing_score'], ENT_QUOTES);
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
    <title>Update Quiz</title>
    <!-- JavaScript validation and content load for update or modify data-->
    <script>
        function confirmUpdate() {
            return confirm('Are you sure you want to update this record?');
        }
    </script>
</head>
<body>
    <center>
        <!-- Update quiz form -->
        <h2><u>Update Quiz Details</u></h2>
        <form method="POST" onsubmit="return confirmUpdate();">
            <input type="hidden" name="quiz_id" value="<?php echo isset($quiz_id) ? $quiz_id : ''; ?>">
            
            <label for="module_id">Module ID:</label>
            <input type="text" name="module_id" value="<?php echo isset($module_id) ? $module_id : ''; ?>" required>
            <br><br>

            <label for="quiz_name">Quiz Name:</label>
            <input type="text" name="quiz_name" value="<?php echo isset($quiz_name) ? $quiz_name : ''; ?>" required>
            <br><br>

            <label for="quiz_description">Quiz Description:</label>
            <textarea name="quiz_description" required><?php echo isset($quiz_description) ? $quiz_description : ''; ?></textarea>
            <br><br>

            <label for="passing_score">Passing Score:</label>
            <input type="text" name="passing_score" value="<?php echo isset($passing_score) ? $passing_score : ''; ?>" required>
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
    $module_id = htmlspecialchars($_POST['module_id'], ENT_QUOTES);
    $quiz_name = htmlspecialchars($_POST['quiz_name'], ENT_QUOTES);
    $quiz_description = htmlspecialchars($_POST['quiz_description'], ENT_QUOTES);
    $passing_score = htmlspecialchars($_POST['passing_score'], ENT_QUOTES);
    $quiz_id = htmlspecialchars($_POST['quiz_id'], ENT_QUOTES); // Retrieve quiz_id from the form

    // Use prepared statement for update
    $stmt = $connection->prepare("UPDATE quizzes SET module_id = ?, quiz_name = ?, quiz_description = ?, passing_score = ? WHERE quiz_id = ?");
    $stmt->bind_param("issdi", $module_id, $quiz_name, $quiz_description, $passing_score, $quiz_id);

    if ($stmt->execute()) {
        // Redirect to quizzes.php on successful update
        header('Location: quizzes.php');
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
