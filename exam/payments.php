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
      background-color: blueviolet;
    }

    section {
      padding: 20px; 
      border-bottom: 3px solid #ddd;
    }

    footer {
      text-align: center; 
      padding: 10px; 
      background-color: darkblue;
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

          <li class="dropdown" style="display: inline; margin-right: 5px;">
            <a href="#" style="padding: 10px; color: white; background-color: greenyellow; text-decoration: none; margin-right: 10px;">tables</a>
            <div class="dropdown-contents">
             <a href="./Courses.php">COURSES</a>
          <a href="./coursemodules.php">COURSEMODULE</a>
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
    <h1>Payments Form</h1>
    <form method="post" onsubmit="return confirmInsert();">
      <label for="payment_id">Payment ID:</label>
      <input type="text" id="payment_id" name="payment_id" required><br><br>

      <label for="user_id">User ID:</label>
      <input type="number" id="user_id" name="user_id" required><br><br>

      <label for="course_id">Course ID:</label>
      <input type="number" id="course_id" name="course_id" required><br><br>

      <label for="payment_date">Payment Date:</label>
      <input type="date" id="payment_date" name="payment_date" required><br><br>

      <label for="amount">Amount:</label>
      <input type="number" id="amount" name="amount" required><br><br>

      <label for="payment_status">Payment Status:</label>
      <input type="text" id="payment_status" name="payment_status" required><br><br>

      <input type="submit" name="add_payment" value="Insert Payment"><br><br>

      <a href="./home.html">Go Back to Home</a>
    </form>

    <?php
    include('database_connection.php');

    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add_payment'])) {
        $payment_id = $_POST['payment_id'];
        $user_id = $_POST['user_id'];
        $course_id = $_POST['course_id'];
        $payment_date = $_POST['payment_date'];
        $amount = $_POST['amount'];
        $payment_status = $_POST['payment_status'];

        $stmt = $connection->prepare("INSERT INTO payments (payment_id, user_id, course_id, payment_date, amount, payment_status) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("iiisss", $payment_id, $user_id, $course_id, $payment_date, $amount, $payment_status);

        if ($stmt->execute()) {
            echo "New payment record has been added successfully.<br><br><a href='payments.php'>Back to Form</a>";
        } else {
            echo "Error inserting payment data: " . $stmt->error;
        }

        $stmt->close();
    }
    ?>

    <section>
      <h2>Payments Detail</h2>
      <table>
        <tr>
          <th>Payment ID</th>
          <th>User ID</th>
          <th>Course ID</th>
          <th>Payment Date</th>
          <th>Amount</th>
          <th>Payment Status</th>
           <th>Delete</th>
          <th>Update</th>
        </tr>
        <?php
        $sql = "SELECT * FROM payments";
        $result = $connection->query($sql);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<tr>
                        <td>{$row['payment_id']}</td>
                        <td>{$row['user_id']}</td>
                        <td>{$row['course_id']}</td>
                        <td>{$row['payment_date']}</td>
                        <td>{$row['amount']}</td>
                        <td>{$row['payment_status']}</td>
                        <td><a style='padding:4px' href='delete_payment.php?payment_id={$row['payment_id']}'>Delete</a></td> 
                        <td><a style='padding:4px' href='update_payment.php?payment_id={$row['payment_id']}'>Update</a></td> 
                      </tr>";
            }
        } else {
            echo "<tr><td colspan='8'>No payment data found</td></tr>";
        }
        ?>
      </table>
    </section>

    <footer>
      <h2>UR CBE BIT &copy; 2024 &reg; Designed by: @murara</h2>
    </footer>

  </body>
</html>
