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

// Check if attempt_id is set
if (isset($_REQUEST['attempt_id'])) {
    $attempt_id = $_REQUEST['attempt_id'];

    // Use prepared statement
    $stmt = $connection->prepare("SELECT * FROM quizattempts WHERE attempt_id = ?");
    $stmt->bind_param("i", $attempt_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $user_id = htmlspecialchars($row['user_id'], ENT_QUOTES);
        $quiz_id = htmlspecialchars($row['quiz_id'], ENT_QUOTES);
        $attempt_date = htmlspecialchars($row['attempt_date'], ENT_QUOTES);
        $score = htmlspecialchars($row['score'], ENT_QUOTES);
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
    <title>Update Quiz Attempt</title>
    <!-- JavaScript validation and content load for update or modify data-->
    <script>
        function confirmUpdate() {
            return confirm('Are you sure you want to update this record?');
        }
    </script>
</head>
<body>
    <center>
        <!-- Update quiz attempts form -->
        <h2><u>Update Form of Quiz Attempts</u></h2>
        <form method="POST" onsubmit="return confirmUpdate();">
            <input type="hidden" name="attempt_id" value="<?php echo isset($attempt_id) ? $attempt_id : ''; ?>">
            
            <label for="user_id">User ID:</label>
            <input type="text" name="user_id" value="<?php echo isset($user_id) ? $user_id : ''; ?>" required>
            <br><br>

            <label for="quiz_id">Quiz ID:</label>
            <input type="text" name="quiz_id" value="<?php echo isset($quiz_id) ? $quiz_id : ''; ?>" required>
            <br><br>

            <label for="attempt_date">Attempt Date:</label>
            <input type="text" name="attempt_date" value="<?php echo isset($attempt_date) ? $attempt_date : ''; ?>" required>
            <br><br>

            <label for="score">Score:</label>
            <input type="text" name="score" value="<?php echo isset($score) ? $score : ''; ?>" required>
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
    $quiz_id = htmlspecialchars($_POST['quiz_id'], ENT_QUOTES);
    $attempt_date = htmlspecialchars($_POST['attempt_date'], ENT_QUOTES);
    $score = htmlspecialchars($_POST['score'], ENT_QUOTES);
    $attempt_id = htmlspecialchars($_POST['attempt_id'], ENT_QUOTES); // Retrieve attempt_id from the form

    // Use prepared statement for update
    $stmt = $connection->prepare("UPDATE quizattempts SET user_id = ?, quiz_id = ?, attempt_date = ?, score = ? WHERE attempt_id = ?");
    $stmt->bind_param("iisdi", $user_id, $quiz_id, $attempt_date, $score, $attempt_id);

    if ($stmt->execute()) {
        // Redirect to quizattempts.php on successful update
        header('Location: quizattempts.php');
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
