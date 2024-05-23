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
if(isset($_REQUEST['module_id'])) {
    $module_id = $_REQUEST['module_id'];
    
    // Prepare and execute the DELETE statement
    $stmt = $connection->prepare("DELETE FROM coursemodules WHERE module_id=?");
    $stmt->bind_param("i", $module_id);
    ?>
    <!DOCTYPE html>
    <html>
    <head>
        <title>Delete Module Record</title>
        <script>
            function confirmDelete() {
                return confirm("Are you sure you want to delete this module?");
            }
        </script>
    </head>
    <body>
        <form method="post" onsubmit="return confirmDelete();">
            <input type="hidden" name="module_id" value="<?php echo $module_id; ?>">
            <input type="submit" value="Delete">
        </form>

        <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if ($stmt->execute()) {
        echo "Module record deleted successfully.";
    } else {
        echo "Error deleting module record: " . $stmt->error;
    }
    }
?>
</body>
</html>
<?php

    $stmt->close();
} else {
    echo "module_id is not set.";
}

$connection->close();
?>
