 <!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8"> 
  <meta name="viewport" content="width=device-width, initial-scale=1.0"> 
  <title>Workerinfo</title>
  <link rel="stylesheet" type="text/css" href="style.css">
  <style>
a:link {
    color: #0066cc;
    text-decoration: none;
}

a:hover {
    text-decoration: underline;
}

    a {
      padding: 7px;
      color: white;
      background-color: turquoise;
      text-decoration: none;
      margin-right: 5px;
    }

    a:visited {
      color: purple;
    }

    a:link {
      color: brown;
    }

    a:hover {
      background-color: white;
    }

    a:active {
      background-color: red;
    }

    button.btn {
      margin-left: 15px; 
      margin-top: 7px;
    }

    input.form-control {
      padding: 10px;
    }

    table {
      width: 75%; 
      border-collapse: revert;

table {
    width: 70%;
    border-collapse: collapse;
}

td:first-child {
    background-color: #333333;
    color: #ffffff;
}

/* Table Cells */
td {
    padding: 8px;
    border-bottom: 1px solid #dddddd;
}

/* Hover Effect */
tr:hover {
    background-color: #e9e9e9;
}

    }

    th, td {
      border: 2px solid black; 
      padding: 10px; 
      text-align: left;
    }

    th {
      background-color: orange; 
    }

    section {
      padding: 20px; 
      border-bottom: 3px solid #ddd;
    }

    footer {
      text-align: center; 
      padding: 10px; 
      background-color: darkgray; 
    }
  </style>
  <!-- JavaScript function for insert confirmation -->
  <script>
    function confirmInsert() {
      return confirm("Are you sure you want to insert this record?");
    }
  </script>
</head>

<body style="background-color: lightblue;"> <!-- Corrected placement of body tag -->
  <header>
    <ul style="list-style-type: none; padding: 0;"> <!-- No list-style -->
      <li style="display: inline; margin-right: 10px;">
           <ul style="list-style-type: none; padding: 0;">
    </li>
    <li style="display: inline; margin-right: 8px;"><a href="./home.html">HOME</a></li>
    <li style="display: inline; margin-right: 10px;"><a href="./about.html">ABOUT</a></li>
    <li style="display: inline; margin-right: 10px;"><a href="./contact.html">CONTACT</a></li>

        <li class="dropdown" style="display: inline; margin-right: 5px;">
            <a href="#" style="padding: 10px; color: white; background-color: greenyellow; text-decoration: none; margin-right: 10px;">tables</a>
            <div class="dropdown-contents">
             <a href="./Courses.php">COURSES</a>
          <a href="./coursemodules.php">COURSEMODULES</a>
          <a href="./enrollments.php">ENROLLMENTS</a>
          <a href="./instructors.php"> INSTRUCTORS</a>
          <a href="./enrollments.php">ENROLLMENTS</a>
          <a href="./payments.php">PAYMENTS</a>
          <a href="./moduleresources.php">moduleresources</a>
          <a href="./quizattempts.php">QUIZATTEMPS</a>
          <a href="./quizzes.php">QUIZZES</a>
          <a href="./users.php">USERS</a>
            </div>
          </li>
              <a href="logout.php">Logout</a>
            </div>
          </li>
        </ul>
      </li>
    </ul>
  </header>
<body style="background-color: yellowgreen;">

    <h1>Course Modules Form</h1>
    <form method="post" onsubmit="return confirmInsert();">
        <label for="module_id">Module ID:</label>
        <input type="number" id="module_id" name="module_id" required><br><br>

        <label for="course_id">Course ID:</label>
        <input type="number" id="course_id" name="course_id" required><br><br>

        <label for="module_name">Module Name:</label>
        <input type="text" id="module_name" name="module_name" required><br><br>

        <label for="module_description">Module Description:</label>
        <input type="text" id="module_description" name="module_description" required><br><br>

        <label for="module_order">Module Order:</label>
        <input type="number" id="module_order" name="module_order" required><br><br>
 
 

        <input type="submit" name="add" value="Insert"><br><br>

        <a href="./home.html">Go Back to Home</a> <!-- Corrected the path to start with "./" -->
    </form>

    <?php
    include('database_connection.php'); // Include the database connection

    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add'])) {
        // Retrieve input values from POST request
        $module_id = $_POST['module_id'];
        $course_id = $_POST['course_id'];
        $module_name = $_POST['module_name'];
        $module_description = $_POST['module_description'];
        $module_order = $_POST['module_order'];

        // Prepare SQL statement for insertion
        $stmt = $connection->prepare("INSERT INTO coursemodules (module_id, course_id, module_name, module_description, module_order) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("iisss", $module_id, $course_id, $module_name, $module_description, $module_order); // Bind parameters

        // Execute the statement and check for success
        if ($stmt->execute()) {
            echo "New record has been added successfully.<br><br><a href='coursemodules.php'>Back to Form</a>";
        } else {
            echo "Error inserting data: " . $stmt->error;
        }

        // Close the statement
        $stmt->close();
    }
    ?>

    <section>
        <h2>Course Modules Detail</h2>
        <table>
            <tr>
                <th>Module ID</th>
                <th>Course ID</th>
                <th>Module Name</th>
                <th>Module Description</th>
                <th>Module Order</th>
                <th>Delete</th>
                <th>Update</th>
            </tr>
            <?php
            // Select all course modules from the database
            $sql = "SELECT * FROM coursemodules";
            $result = $connection->query($sql); // Execute the query

            if ($result->num_rows > 0) {
                // Loop through the results and generate table rows
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>
                            <td>{$row['module_id']}</td>
                            <td>{$row['course_id']}</td>
                            <td>{$row['module_name']}</td>
                            <td>{$row['module_description']}</td>
                            <td>{$row['module_order']}</td>
                            <td><a style='padding:4px' href='delete_coursemodule.php?module_id={$row['module_id']}'>Delete</a></td> 
                            <td><a style='padding:4px' href='update_coursemodule.php?module_id={$row['module_id']}'>Update</a></td> 
                          </tr>";
                }
            } else {
                // If no data is found, display a message in the table
                echo "<tr><td colspan='7'>No data found</td></tr>";
            }
            ?>
        </table>
    </section>

    <footer>
        <h2>UR CBE BIT &copy; 2024 &reg; Designed by: @murara</h2> <!-- Corrected "Designer" to "Designed" -->
    </footer>

</body>
</html>
