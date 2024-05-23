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

// Check if user_id is set
if (isset($_REQUEST['user_id'])) {
    $user_id = $_REQUEST['user_id'];

    // Use prepared statement
    $stmt = $connection->prepare("SELECT * FROM users WHERE user_id = ?");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $username = htmlspecialchars($row['username'], ENT_QUOTES);
        $email = htmlspecialchars($row['email'], ENT_QUOTES);
        $password = htmlspecialchars($row['password'], ENT_QUOTES);
        $role = htmlspecialchars($row['role'], ENT_QUOTES);
        $registration_date = htmlspecialchars($row['registration_date'], ENT_QUOTES);
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
    <title>Update User</title>
    <!-- JavaScript validation and content load for update or modify data-->
    <script>
        function confirmUpdate() {
            return confirm('Are you sure you want to update this record?');
        }
    </script>
</head>
<body>
    <center>
        <!-- Update user form -->
        <h2><u>Update User Details</u></h2>
        <form method="POST" onsubmit="return confirmUpdate();">
            <input type="hidden" name="user_id" value="<?php echo isset($user_id) ? $user_id : ''; ?>">
            
            <label for="username">Username:</label>
            <input type="text" name="username" value="<?php echo isset($username) ? $username : ''; ?>" required>
            <br><br>

            <label for="email">Email:</label>
            <input type="email" name="email" value="<?php echo isset($email) ? $email : ''; ?>" required>
            <br><br>

            <label for="password">Password:</label>
            <input type="password" name="password" value="<?php echo isset($password) ? $password : ''; ?>" required>
            <br><br>

            <label for="role">Role:</label>
            <select name="role" required>
                <option value="student" <?php echo isset($role) && $role === 'student' ? 'selected' : ''; ?>>Student</option>
                <option value="instructor" <?php echo isset($role) && $role === 'instructor' ? 'selected' : ''; ?>>Instructor</option>
                <option value="admin" <?php echo isset($role) && $role === 'admin' ? 'selected' : ''; ?>>Admin</option>
            </select>
            <br><br>

            <label for="registration_date">Registration Date:</label>
            <input type="text" name="registration_date" value="<?php echo isset($registration_date) ? $registration_date : ''; ?>" required>
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
    $username = htmlspecialchars($_POST['username'], ENT_QUOTES);
    $email = htmlspecialchars($_POST['email'], ENT_QUOTES);
    $password = htmlspecialchars($_POST['password'], ENT_QUOTES);
    $role = htmlspecialchars($_POST['role'], ENT_QUOTES);
    $registration_date = htmlspecialchars($_POST['registration_date'], ENT_QUOTES);
    $user_id = htmlspecialchars($_POST['user_id'], ENT_QUOTES);

    // Use prepared statement for update
    $stmt = $connection->prepare("UPDATE users SET username = ?, email = ?, password = ?, role = ?, registration_date = ? WHERE user_id = ?");
    $stmt->bind_param("sssssi", $username, $email, $password, $role, $registration_date, $user_id);

    if ($stmt->execute()) {
        // Redirect to users.php on successful update
        header('Location: users.php');
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
