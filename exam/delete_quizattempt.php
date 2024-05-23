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
if(isset($_REQUEST['attempt_id'])) {
    $attempt_id = $_REQUEST['attempt_id'];
    
    // Prepare and execute the DELETE statement
    $stmt = $connection->prepare("DELETE FROM quizattempts WHERE attempt_id=?");
    $stmt->bind_param("i", $attempt_id);
    ?>
    <!DOCTYPE html>
    <html>
    <head>
        <title>Delete Quiz Attempt Record</title>
        <script>
            function confirmDelete() {
                return confirm("Are you sure you want to delete this quiz attempt?");
            }
        </script>
    </head>
    <body>
        <form method="post" onsubmit="return confirmDelete();">
            <input type="hidden" name="attempt_id" value="<?php echo $attempt_id; ?>">
            <input type="submit" value="Delete">
        </form>

        <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if ($stmt->execute()) {
        echo "Quiz attempt record deleted successfully.";
    } else {
        echo "Error deleting quiz attempt record: " . $stmt->error;
    }
    }
?>
</body>
</html>
<?php

    $stmt->close();
} else {
    echo "attempt_id is not set.";
}

$connection->close();
?>
