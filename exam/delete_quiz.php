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
if(isset($_REQUEST['quiz_id'])) {
    $quiz_id = $_REQUEST['quiz_id'];
    
    // Prepare and execute the DELETE statement
    $stmt = $connection->prepare("DELETE FROM quizzes WHERE quiz_id=?");
    $stmt->bind_param("i", $quiz_id);
    ?>
    <!DOCTYPE html>
    <html>
    <head>
        <title>Delete Quiz Record</title>
        <script>
            function confirmDelete() {
                return confirm("Are you sure you want to delete this quiz?");
            }
        </script>
    </head>
    <body>
        <form method="post" onsubmit="return confirmDelete();">
            <input type="hidden" name="quiz_id" value="<?php echo $quiz_id; ?>">
            <input type="submit" value="Delete">
        </form>

        <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if ($stmt->execute()) {
        echo "Quiz record deleted successfully.";
    } else {
        echo "Error deleting quiz record: " . $stmt->error;
    }
    }
?>
</body>
</html>
<?php

    $stmt->close();
} else {
    echo "quiz_id is not set.";
}

$connection->close();
?>
