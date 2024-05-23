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
      border-collapse: collapse;
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
  <script>
    function confirmInsert() {
      return confirm("Are you sure you want to insert this record?");
    }
  </script>
</head>
<body style="background-color: lightblue;">
  <header>
    <ul style="list-style-type: none; padding: 0;">
      <li style="display: inline; margin-right: 10px;">
        <ul style="list-style-type: none; padding: 0;">
          <li style="display: inline; margin-right: 8px;"><a href="./home.html">HOME</a></li>
          <li style="display: inline; margin-right: 10px;"><a href="./about.html">ABOUT</a></li>
          <li style="display: inline; margin-right: 10px;"><a href="./contact.html">CONTACT 
             <li class="dropdown" style="display: inline; margin-right: 5px;">
            <a href="#" style="padding: 10px; color: white; background-color: greenyellow; text-decoration: none; margin-right: 10px;">tables</a>
            <div class="dropdown-contents">
             <a href="./Courses.php">COURSES</a>
          <a href="./coursemodules.php">COURSEMODULE</a>
          <a href="./enrollments.php">ENROLLMENTS</a>
          <a href="./instructors.php"> INSTRUCTORS</a>
          <a href="./enrollments.php">ENROLLMENTS</a>
          <a href="./moduleresources.php">moduleresources</a>
          <a href="./payments.php">PAYMENTS</a>
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
    <h1>Debt Management Resources Form</h1>
    <form method="post" onsubmit="return confirmInsert();">
      <label for="resource_id">Resource ID:</label>
      <input type="number" id="resource_id" name="resource_id" required><br><br>

      <label for="resource_type">Resource Type:</label>
      <input type="text" id="resource_type" name="resource_type" required><br><br>

      <label for="resource_title">Resource Title:</label>
      <input type="text" id="resource_title" name="resource_title" required><br><br>

      <label for="resource_description">Resource Description:</label>
      <input type="text" id="resource_description" name="resource_description" required><br><br>

      <label for="resource_url">Resource URL:</label>
      <input type="text" id="resource_url" name="resource_url" required><br><br>

      <input type="submit" name="add" value="Insert"><br><br>

      <a href="./home.html">Go Back to Home</a>
    </form>

    <?php
    include('database_connection.php');

    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add'])) {
        $resource_id = $_POST['resource_id'];
        $resource_type = $_POST['resource_type'];
        $resource_title = $_POST['resource_title'];
        $resource_description = $_POST['resource_description'];
        $resource_url = $_POST['resource_url'];

        $stmt = $connection->prepare("INSERT INTO debtmanagementresources (resource_id, resource_type, resource_title, resource_description, resource_url) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("issss", $resource_id, $resource_type, $resource_title, $resource_description, $resource_url);

        if ($stmt->execute()) {
            echo "New record has been added successfully.<br><br><a href='debtmanagementresources.php'>Back to Form</a>";
        } else {
            echo "Error inserting data: " . $stmt->error;
        }

        $stmt->close();
    }
    ?>

    <section>
      <h2>Debt Management Resources Detail</h2>
      <table>
        <tr>
          <th>Resource ID</th>
          <th>Resource Type</th>
          <th>Resource Title</th>
          <th>Resource Description</th>
          <th>Resource URL</th>
          <th>Delete</th>
          <th>Update</th>
        </tr>
        <?php
        $sql = "SELECT * FROM debtmanagementresources";
        $result = $connection->query($sql);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<tr>
                        <td>{$row['resource_id']}</td>
                        <td>{$row['resource_type']}</td>
                        <td>{$row['resource_title']}</td>
                        <td>{$row['resource_description']}</td>
                        <td>{$row['resource_url']}</td>
                        <td><a style='padding:4px' href='delete_debtmanagementresource.php?resource_id={$row['resource_id']}'>Delete</a></td> 
                        <td><a style='padding:4px' href='update_debtmanagementresource.php?resource_id={$row['resource_id']}'>Update</a></td> 
                      </tr>";
            }
        } else {
            echo "<tr><td colspan='7'>No data found</td></tr>";
        }
        ?>
      </table>
    </section>

    <footer>
      <h2>UR CBE BIT &copy; 2024 &reg; Designed by: @murara</h2>
    </footer>

  </body>
</html>
