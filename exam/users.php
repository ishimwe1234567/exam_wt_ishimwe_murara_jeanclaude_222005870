<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8"> <!-- Proper character encoding -->
  <meta name="viewport" content="width=device-width, initial-scale=1.0"> <!-- Responsive design -->
  <title>Workerinfo</title>
  <link rel="stylesheet" type="text/css" href="style.css"> <!-- External CSS -->
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

/* Special Styling for First Column */
td:first-child {
    background-color: #333333;
    color: #ffffff;
}

td {
    padding: 8px;
    border-bottom: 1px solid #dddddd;
}

tr:hover {
    background-color: #e9e9e9;
}

    }

    th, td {
      border: 2px solid black; /* Table borders */
      padding: 10px; /* Padding for readability */
      text-align: left;
    }

    th {
      background-color: orange; /* Header row color */
    }

    section {
      padding: 20px; 
      border-bottom: 3px solid #ddd; /* Bottom border for section */
    }

    footer {
      text-align: center; 
      padding: 10px; 
      background-color: darkgray; /* Footer background color */
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
      <a href="#" style="padding: 10px; color: white; background-color: greenyellow; text-decoration: none; margin-right: 10px;">Settings</a>
      <div class="dropdown-contents">
        <!-- Links inside the dropdown menu -->
        <a href="login.php">Login</a>
        <a href="register.php">Register</a>
        <a href="logout.php">Logout</a>
        </div>
      </a>
    </li>
    </ul>
  </header>
<body style="background-color: yellowgreen;">

    <h1>Users Form</h1>
    <form method="post" onsubmit="return confirmInsert();">
        <label for="user_id">User ID:</label>
        <input type="number" id="user_id" name="user_id" required><br><br>

        <label for="username">Username:</label>
        <input type="text" id="username" name="username" required><br><br>

        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required><br><br>

        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required><br><br>

                <label for="role">role:</label>
        <input type="text" id="role" name="role" required><br><br>

         <label for="registration_date">registration_date:</label>
        <input type="date" id="registration_date" name="registration_date" required><br><br>
 
 

        <input type="submit" name="add" value="Insert"><br><br>

        <a href="./home.html">Go Back to Home</a> <!-- Corrected the path to start with "./" -->
    </form>

    <?php
    include('database_connection.php'); // Include the database connection

    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add'])) {
        // Retrieve input values from POST request
        $user_id = $_POST['user_id'];
        $username = $_POST['username'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        $role = $_POST['role'];
        $registration_date= $_POST['registration_date'];

        // Prepare SQL statement for insertion
        $stmt = $connection->prepare("INSERT INTO users (user_id, username, email, password, role,registration_date) VALUES (?, ?,?, ?, ?, ?)");
        $stmt->bind_param("isssss", $user_id, $username, $email, $password, $role,$registration_date); // Bind parameters

        // Execute the statement and check for success
        if ($stmt->execute()) {
            echo "New record has been added successfully.<br><br><a href='users.php'>Back to Form</a>";
        } else {
            echo "Error inserting data: " . $stmt->error;
        }

        // Close the statement
        $stmt->close();
    }
    ?>

    <section>
        <h2>Users Detail</h2>
        <table>
            <tr>
                <th>User ID</th>
                <th>Username</th>
                <th>Email</th>
                <th>Password</th>
                <th>role</th>
                <th>registration_date</th>
                <th>Delete</th>
                <th>Update</th>
            </tr>
            <?php
            // Select all users from the database
            $sql = "SELECT * FROM users";
            $result = $connection->query($sql); // Execute the query

            if ($result->num_rows > 0) {
                // Loop through the results and generate table rows
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>
                            <td>{$row['user_id']}</td>
                            <td>{$row['username']}</td>
                            <td>{$row['email']}</td>
                            <td>{$row['password']}</td>
                            <td>{$row['role']}</td>
                            <td>{$row['registration_date']}</td>
                            <td><a style='padding:4px' href='delete_user.php?user_id={$row['user_id']}'>Delete</a></td> 
                            <td><a style='padding:4px' href='update_user.php?user_id={$row['user_id']}'>Update</a></td> 
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
        <h2>UR CBE BIT &copy; 2024 &reg; Designed by: @murara</h2> 
    </footer>

</body>
</html>