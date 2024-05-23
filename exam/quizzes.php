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
          <li style="display: inline; margin-right: 10px;"><a href="./contact.html">CONTACT</a></li>
          <li style="display: inline; margin-right: 10px;"><a href="./Courses.php">COURSES</a></li>
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

    <h1>Quizzes Form</h1>
    <!-- Your form content here -->
    <form method="post" onsubmit="return confirmInsert();">
      <label for="quiz_id">Quiz ID:</label>
      <input type="number" id="quiz_id" name="quiz_id" required><br><br>

      <label for="module_id">Module ID:</label>
      <input type="number" id="module_id" name="module_id" required><br><br>

      <label for="quiz_name">Quiz Name:</label>
      <input type="text" id="quiz_name" name="quiz_name" required><br><br>

      <label for="quiz_description">Quiz Description:</label>
      <input type="text" id="quiz_description" name="quiz_description" required><br><br>

      <label for="passing_score">Passing Score:</label>
      <input type="number" id="passing_score" name="passing_score" required><br><br>

      <input type="submit" name="add" value="Insert"><br><br>

      <a href="./home.html">Go Back to Home</a>
    </form>

    <?php
    include('database_connection.php');

    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add'])) {
        $quiz_id = $_POST['quiz_id'];
        $module_id = $_POST['module_id'];
        $quiz_name = $_POST['quiz_name'];
        $quiz_description = $_POST['quiz_description'];
        $passing_score = $_POST['passing_score'];

        $stmt = $connection->prepare("INSERT INTO quizzes (quiz_id, module_id, quiz_name, quiz_description, passing_score) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("iissi", $quiz_id, $module_id, $quiz_name, $quiz_description, $passing_score);

        if ($stmt->execute()) {
            echo "New record has been added successfully.<br><br><a href='quizzes.php'>Back to Form</a>";
        } else {
            echo "Error inserting data: " . $stmt->error;
        }

        $stmt->close();
    }
    ?>

    <section>
      <h2>Quizzes Detail</h2>
      <table>
        <tr>
          <th>Quiz ID</th>
          <th>Module ID</th>
          <th>Quiz Name</th>
          <th>Quiz Description</th>
          <th>Passing Score</th>
          <th>Delete</th>
          <th>Update</th>
        </tr>
        <?php
        $sql = "SELECT * FROM quizzes";
        $result = $connection->query($sql);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<tr>
                        <td>{$row['quiz_id']}</td>
                        <td>{$row['module_id']}</td>
                        <td>{$row['quiz_name']}</td>
                        <td>{$row['quiz_description']}</td>
                        <td>{$row['passing_score']}</td>
                        <td><a style='padding:4px' href='delete_quiz.php?quiz_id={$row['quiz_id']}'>Delete</a></td> 
                        <td><a style='padding:4px' href='update_quiz.php?quiz_id={$row['quiz_id']}'>Update</a></td> 
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
