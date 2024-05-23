<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "online_debt_managment_course_platform"; 

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST["name"];
    $email = $_POST["email"];
    $message = $_POST["message"];
    
    $to = "info@murara.com"; 
    $subject = "Contact Form Submission";
    $body = "Name: $name\nEmail: $email\nMessage: $message";
    $headers = "From: $email";

    if (mail($to, $subject, $body, $headers)) {
        echo "<p>Your message has been sent successfully!</p>";
    } else {
        echo "<p>Sorry, there was an error sending your message.</p>";
    }
}
?>
