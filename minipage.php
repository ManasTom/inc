<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $name = htmlspecialchars($_POST['name']);
    $email = htmlspecialchars($_POST['email']);
    $message = htmlspecialchars($_POST['message']);

    // Validate form data
    if (!empty($name) && !empty($email) && !empty($message) && filter_var($email, FILTER_VALIDATE_EMAIL)) {
        // Email details
        $to = "plyofitacademy@gmail.com";
        $subject = "New Enquiry on Courses";
        $headers = "From: $email\r\n";
        $headers .= "Reply-To: $email\r\n";
        $headers .= "Content-Type: text/plain; charset=UTF-8\r\n";

        // Email body
        $emailBody = "Name: $name\n";
        $emailBody .= "Email: $email\n\n";
        $emailBody .= "Message:\n$message\n";

        // Send email
        if (mail($to, $subject, $emailBody, $headers)) {
            echo "<script type='text/javascript'>alert('Thank you for getting in touch!');</script>";
        } else {
            echo "<script type='text/javascript'>alert('Sorry, something went wrong. Please try again.');</script>";
        }
    } else {
        echo "<script type='text/javascript'>alert('Please fill in all fields correctly.');</script>";
    }
} else {
    echo "<script type='text/javascript'>alert('Invalid request method.');</script>";
}
?>
