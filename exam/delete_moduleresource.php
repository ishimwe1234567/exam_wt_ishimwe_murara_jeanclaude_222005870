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
if(isset($_REQUEST['resource_id'])) {
    $resource_id = $_REQUEST['resource_id'];
    
    // Prepare and execute the DELETE statement
    $stmt = $connection->prepare("DELETE FROM moduleresources WHERE resource_id=?");
    $stmt->bind_param("i", $resource_id);
    ?>
    <!DOCTYPE html>
    <html>
    <head>
        <title>Delete Module Resource Record</title>
        <script>
            function confirmDelete() {
                return confirm("Are you sure you want to delete this module resource?");
            }
        </script>
    </head>
    <body>
        <form method="post" onsubmit="return confirmDelete();">
            <input type="hidden" name="resource_id" value="<?php echo $resource_id; ?>">
            <input type="submit" value="Delete">
        </form>

        <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if ($stmt->execute()) {
        echo "Module resource record deleted successfully.";
    } else {
        echo "Error deleting module resource record: " . $stmt->error;
    }
    }
?>
</body>
</html>
<?php

    $stmt->close();
} else {
    echo "resource_id is not set.";
}

$connection->close();
?>
