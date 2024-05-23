<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Workerinfo</title>
  <link rel="stylesheet" type="text/css" href="style.css">
  <style>
    /* CSS styles for consistent styling */
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
          <a href="./moduleresources.php">moduleresources</a>
          <a href="./instructors.php"> INSTRUCTORS</a>
          <a href="./enrollments.php">ENROLLMENTS</a>
          <a href="./payments.php">PAYMENTS</a>
          <a href="./debtmanagementresources.php">DEBTMANAGEMENTRESOURCES</a>
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
    <h1>Instructors Form</h1>
    <form method="post" onsubmit="return confirmInsert();">
      <label for="instructor_id">Instructor ID:</label>
      <input type="number" id="instructor_id" name="instructor_id" required><br><br>

      <label for="user_id">User ID:</label>
      <input type="number" id="user_id" name="user_id" required><br><br>

      <label for="bio">Bio:</label>
      <input type="text" id="bio" name="bio" required><br><br>

      <label for="expertise_area">Expertise Area:</label>
      <input type="text" id="expertise_area" name="expertise_area" required><br><br>

      <input type="submit" name="add" value="Insert"><br><br>

      <a href="./home.html">Go Back to Home</a>
    </form>

    <?php
    include('database_connection.php');

    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add'])) {
        $instructor_id = $_POST['instructor_id'];
        $user_id = $_POST['user_id'];
        $bio = $_POST['bio'];
        $expertise_area = $_POST['expertise_area'];

        $stmt = $connection->prepare("INSERT INTO instructors (instructor_id, user_id, bio, expertise_area) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("iiss", $instructor_id, $user_id, $bio, $expertise_area);

        if ($stmt->execute()) {
            echo "New record has been added successfully.<br><br><a href='instructors.php'>Back to Form</a>";
        } else {
            echo "Error inserting data: " . $stmt->error;
        }

        $stmt->close();
    }
    ?>

    <section>
      <h2>Instructors Detail</h2>
      <table>
        <tr>
          <th>Instructor ID</th>
          <th>User ID</th>
          <th>Bio</th>
          <th>Expertise Area</th>
          <th>Delete</th>
          <th>Update</th>
        </tr>
        <?php
        $sql = "SELECT * FROM instructors";
        $result = $connection->query($sql);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<tr>
                        <td>{$row['instructor_id']}</td>
                        <td>{$row['user_id']}</td>
                        <td>{$row['bio']}</td>
                        <td>{$row['expertise_area']}</td>
                        <td><a style='padding:4px' href='delete_instructor.php?instructor_id={$row['instructor_id']}'>Delete</a></td> 
                        <td><a style='padding:4px' href='update_instructor.php?instructor_id={$row['instructor_id']}'>Update</a></td> 
                      </tr>";
            }
        } else {
            echo "<tr><td colspan='6'>No data found</td></tr>";
        }
        ?>
      </table>
    </section>

    <footer>
      <h2>UR CBE BIT &copy; 2024 &reg; Designed by: @murara</h2>
    </footer>

  </body>
</html>
