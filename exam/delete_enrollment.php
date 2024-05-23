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
if(isset($_REQUEST['enrollment_id'])) {
    $enrollment_id = $_REQUEST['enrollment_id'];
    
    // Prepare and execute the DELETE statement
    $stmt = $connection->prepare("DELETE FROM enrollments WHERE enrollment_id=?");
    $stmt->bind_param("i", $enrollment_id);
    ?>
    <!DOCTYPE html>
    <html>
    <head>
        <title>Delete Enrollment Record</title>
        <script>
            function confirmDelete() {
                return confirm("Are you sure you want to delete this enrollment?");
            }
        </script>
    </head>
    <body>
        <form method="post" onsubmit="return confirmDelete();">
            <input type="hidden" name="enrollment_id" value="<?php echo $enrollment_id; ?>">
            <input type="submit" value="Delete">
        </form>

        <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if ($stmt->execute()) {
        echo "Enrollment record deleted successfully.";
    } else {
        echo "Error deleting enrollment record: " . $stmt->error;
    }
    }
?>
</body>
</html>
<?php

    $stmt->close();
} else {
    echo "enrollment_id is not set.";
}

$connection->close();
?>
