<?php
// Check if the 'query' GET parameter is set and not empty
if (isset($_GET['query']) && !empty($_GET['query'])) {
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

    // Prepare a statement to prevent SQL injection
    $searchTerm = "%" . $connection->real_escape_string($_GET['query']) . "%";

    // Queries for different tables
    $queries = [
        'courses' => "SELECT course_name FROM courses WHERE course_name LIKE ?",
        'coursemodules' => "SELECT module_name FROM coursemodules WHERE module_name LIKE ?",
        'debtmanagementresources' => "SELECT resource_name FROM debtmanagementresources WHERE resource_name LIKE ?",
        'enrollments' => "SELECT enrollment_id FROM enrollments WHERE enrollment_id LIKE ?",
        'instructors' => "SELECT instructor_name FROM instructors WHERE instructor_name LIKE ?",
        'moduleresources' => "SELECT resource_name FROM moduleresources WHERE resource_id LIKE ?",
        'payments' => "SELECT payment_id FROM payments WHERE payment_id LIKE ?",
        'quizattempts' => "SELECT attempt_date FROM quizattempts WHERE attempt_date LIKE ?",
        'quizzes' => "SELECT quiz_name FROM quizzes WHERE quiz_name LIKE ?",
        'users' => "SELECT username FROM users WHERE username LIKE ?",
    ];

    echo "<h2><u>Search Results:</u></h2>";

    foreach ($queries as $table => $sql) {
        $stmt = $connection->prepare($sql);
        $stmt->bind_param("s", $searchTerm);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result === false) {
            echo "<p>Error executing query for table $table: " . $connection->error . "</p>";
            continue; 
        }

        echo "<h3>Table: $table</h3>";
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<p>" . htmlspecialchars($row[array_keys($row)[0]]) . "</p>"; // Dynamic field extraction from result
            }
        } else {
            echo "<p>No results found in $table matching the search term: '" . htmlspecialchars($_GET['query']) . "'</p>";
        }

        $stmt->close();
    }

    // Close the connection
    $connection->close();
} else {
    echo "<p>No search term was provided.</p>";
}
?>
