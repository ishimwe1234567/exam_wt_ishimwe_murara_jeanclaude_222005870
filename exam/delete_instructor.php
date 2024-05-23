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
if(isset($_REQUEST['instructor_id'])) {
    $instructor_id = $_REQUEST['instructor_id'];
    
    // Prepare and execute the DELETE statement
    $stmt = $connection->prepare("DELETE FROM instructors WHERE instructor_id=?");
    $stmt->bind_param("i", $instructor_id);
    ?>
    <!DOCTYPE html>
    <html>
    <head>
        <title>Delete Instructor Record</title>
        <script>
            function confirmDelete() {
                return confirm("Are you sure you want to delete this instructor?");
            }
        </script>
    </head>
    <body>
        <form method="post" onsubmit="return confirmDelete();">
            <input type="hidden" name="instructor_id" value="<?php echo $instructor_id; ?>">
            <input type="submit" value="Delete">
        </form>

        <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if ($stmt->execute()) {
        echo "Instructor record deleted successfully.";
    } else {
        echo "Error deleting instructor record: " . $stmt->error;
    }
    }
?>
</body>
</html>
<?php

    $stmt->close();
} else {
    echo "instructor_id is not set.";
}

$connection->close();
?>
