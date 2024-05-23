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
if(isset($_REQUEST['course_id'])) {
    $course_id = $_REQUEST['course_id'];
    
    // Prepare and execute the DELETE statement
    $stmt = $connection->prepare("DELETE FROM courses WHERE course_id=?");
    $stmt->bind_param("i", $course_id);
    ?>
    <!DOCTYPE html>
    <html>
    <head>
        <title>Delete Course Record</title>
        <script>
            function confirmDelete() {
                return confirm("Are you sure you want to delete this course?");
            }
        </script>
    </head>
    <body>
        <form method="post" onsubmit="return confirmDelete();">
            <input type="hidden" name="course_id" value="<?php echo $course_id; ?>">
            <input type="submit" value="Delete">
        </form>

        <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if ($stmt->execute()) {
        echo "Course record deleted successfully.";
    } else {
        echo "Error deleting course record: " . $stmt->error;
    }
    }
?>
</body>
</html>
<?php

    $stmt->close();
} else {
    echo "course_id is not set.";
}

$connection->close();
?>
