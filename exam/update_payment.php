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

// Check if payment_id is set
if (isset($_REQUEST['payment_id'])) {
    $payment_id = $_REQUEST['payment_id'];

    // Use prepared statement
    $stmt = $connection->prepare("SELECT * FROM payments WHERE payment_id = ?");
    $stmt->bind_param("i", $payment_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $user_id = htmlspecialchars($row['user_id'], ENT_QUOTES);
        $course_id = htmlspecialchars($row['course_id'], ENT_QUOTES);
        $payment_date = htmlspecialchars($row['payment_date'], ENT_QUOTES);
        $amount = htmlspecialchars($row['amount'], ENT_QUOTES);
        $payment_status = htmlspecialchars($row['payment_status'], ENT_QUOTES);
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
    <title>Update Payment</title>
    <!-- JavaScript validation and content load for update or modify data-->
    <script>
        function confirmUpdate() {
            return confirm('Are you sure you want to update this record?');
        }
    </script>
</head>
<body>
    <center>
        <!-- Update payments form -->
        <h2><u>Update Form of Payments</u></h2>
        <form method="POST" onsubmit="return confirmUpdate();">
            <input type="hidden" name="payment_id" value="<?php echo isset($payment_id) ? $payment_id : ''; ?>">
            
            <label for="user_id">User ID:</label>
            <input type="text" name="user_id" value="<?php echo isset($user_id) ? $user_id : ''; ?>" required>
            <br><br>

            <label for="course_id">Course ID:</label>
            <input type="text" name="course_id" value="<?php echo isset($course_id) ? $course_id : ''; ?>" required>
            <br><br>

            <label for="payment_date">Payment Date:</label>
            <input type="text" name="payment_date" value="<?php echo isset($payment_date) ? $payment_date : ''; ?>" required>
            <br><br>

            <label for="amount">Amount:</label>
            <input type="text" name="amount" value="<?php echo isset($amount) ? $amount : ''; ?>" required>
            <br><br>

            <label for="payment_status">Payment Status:</label>
            <input type="text" name="payment_status" value="<?php echo isset($payment_status) ? $payment_status : ''; ?>" required>
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
    $course_id = htmlspecialchars($_POST['course_id'], ENT_QUOTES);
    $payment_date = htmlspecialchars($_POST['payment_date'], ENT_QUOTES);
    $amount = htmlspecialchars($_POST['amount'], ENT_QUOTES);
    $payment_status = htmlspecialchars($_POST['payment_status'], ENT_QUOTES);
    $payment_id = htmlspecialchars($_POST['payment_id'], ENT_QUOTES); // Retrieve payment_id from the form

    // Use prepared statement for update
    $stmt = $connection->prepare("UPDATE payments SET user_id = ?, course_id = ?, payment_date = ?, amount = ?, payment_status = ? WHERE payment_id = ?");
    $stmt->bind_param("iisdsi", $user_id, $course_id, $payment_date, $amount, $payment_status, $payment_id);

    if ($stmt->execute()) {
        // Redirect to payments.php on successful update
        header('Location: payments.php');
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
