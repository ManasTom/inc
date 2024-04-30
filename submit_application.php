<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize user input
    $fullName = htmlspecialchars($_POST['fullName']);
    $contactNumber = htmlspecialchars($_POST['contactNumber']);
    $email = htmlspecialchars($_POST['email']);
    $place = htmlspecialchars($_POST['place']);
    $dob = htmlspecialchars($_POST['dob']);
    $workExperience = htmlspecialchars($_POST['workExperience']);
    $certifiedTrainer = $_POST['certifiedTrainer'];
    $certificationName = htmlspecialchars($_POST['certificationName']);
    $relocate = $_POST['relocate'];
    $salaryExpectations = htmlspecialchars($_POST['salaryExpectations']);
    $immediateJoin = $_POST['immediateJoin'];



    // File upload handling for the resume
    $resume = $_FILES['resume'];
    $resumeFileName = $resume['name'];
    $resumeTmpName = $resume['tmp_name'];
    $resumeFileSize = $resume['size'];

    // Set the recipient email addresses
    $recipients = array(
        "manastom670@gmail.com"
    );

    // Set a consistent "From" address for the confirmation email
    $confirmationFrom = "manastom670@gmail.com"; // Replace with the desired email address

    // Set the subject of the email
    $subject = "Job Application";

    // Build the email message
    $messageBody = "Applicant Name: $fullName\n";
 
    $messageBody .= "Contact Number: $contactNumber\n";
    $messageBody .= "Email: $email\n";
    $messageBody .= "Place: $place\n";
    $messageBody .= "Date of Birth:\n$dob\n";
    $messageBody .= "Experience:\n$workExperience\n";
    $messageBody .= "Certified Trainer:\n$certifiedTrainer\n";
    $messageBody .= "Certification Name:\n$certificationName\n";
    $messageBody .= "Able to relocate? :\n$relocate\n";
    $messageBody .= "Salary expectations:\n$salaryExpectations\n";
    $messageBody .= "Immediate Joining?:\n$immediateJoin\n";

    // Create a boundary for the email
    $boundary = md5(time());

    // Headers for the email
    $headers = "From: $email\r\n";
    $headers .= "Reply-To: $email\r\n";
    $headers .= "MIME-Version: 1.0\r\n";
    $headers .= "Content-Type: multipart/mixed; boundary=\"$boundary\"\r\n";

    // Message text
    $body = "--$boundary\r\n";
    $body .= "Content-Type: text/plain; charset=ISO-8859-1\r\n";
    $body .= "Content-Transfer-Encoding: 7bit\r\n\r\n";
    $body .= $messageBody . "\r\n\r\n";

    // Attach resume file
    $fileContent = file_get_contents($resumeTmpName);
    $body .= "--$boundary\r\n";
    $body .= "Content-Type: application/octet-stream; name=\"$resumeFileName\"\r\n";
    $body .= "Content-Disposition: attachment; filename=\"$resumeFileName\"\r\n";
    $body .= "Content-Transfer-Encoding: base64\r\n\r\n";
    $body .= chunk_split(base64_encode($fileContent)) . "\r\n";

    // Send the email to multiple recipients
    foreach ($recipients as $recipient) {
        if (!mail($recipient, $subject, $body, $headers)) {
            echo "Error sending email to $recipient";
            exit;
        }
    }

    // Confirmation email to the applicant
    $confirmationSubject = "Application Confirmation";
    $confirmationMessage = "Dear $fullName,\n\nThank you for submitting your job application for 'xxxxxx'. We have received your application and will review it shortly.\n\nBest regards,\nThe Illford Digital Hiring Team";

    // Headers for the confirmation email with a consistent "From" address
    $confirmationHeaders = "From: $confirmationFrom\r\n";
    $confirmationHeaders .= "Reply-To: $confirmationFrom\r\n";

    // Send the confirmation email to the applicant
    if (!mail($email, $confirmationSubject, $confirmationMessage, $confirmationHeaders)) {
        echo "Error sending confirmation email to $email";
        exit;
    }

    // Redirect to the thank-you page
    echo "submitted";
} else {
    // Redirect to the error page if there's an issue with the form submission
    echo "oops error!!";
}
?>